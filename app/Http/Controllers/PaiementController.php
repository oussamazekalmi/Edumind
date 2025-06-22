<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frais;
use App\Models\Eleve;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{

    public function traiter($id)
    {
        $eleve = Eleve::with('classe.niveau.cycle')->findOrFail($id);

        $montant_inscription = $eleve->classe->niveau->cycle->montant_inscription;
        $montant_scolarite_mensuel = $eleve->classe->niveau->montant_scolarite;
        $montant_transport_mensuel = $eleve->classe->niveau->cycle->montant_transport;

        $discount = $eleve->discount ?? 0;
        $transport_discount = $eleve->transport_discount ?? 0;
        $reduction = ($montant_scolarite_mensuel * $discount) / 100;
        $transport_reduction = ($montant_transport_mensuel * $transport_discount) / 100;
        $montant_scolarite_mensuel -= $reduction;
        $montant_transport_mensuel -= $transport_reduction;

        $total_scolarite = $montant_scolarite_mensuel * 10;
        $total_transport = $montant_transport_mensuel * 10;

        $paye_inscription = $eleve->frais()->where('type', 'inscription')->where('statut', '!=', 'non payé')->sum('montant');
        $paye_scolarite = $eleve->frais()->where('type', 'scolaire')->where('statut', '!=', 'non payé')->sum('montant');
        $paye_transport = $eleve->frais()->where('type', 'transport')->where('statut', '!=', 'non payé')->sum('montant');

        $restant_inscription = max($montant_inscription - $paye_inscription, 0);
        $restant_scolarite = max($total_scolarite - $paye_scolarite, 0);
        $restant_transport = max($total_transport - $paye_transport, 0);

        if($restant_inscription <= 0 && $restant_scolarite <= 0 && $restant_transport <= 0) {
            return redirect()->route("eleves.show", $id);
        }

        return view('eleves.add-payment', compact(
            'eleve',
            'restant_inscription',
            'restant_scolarite',
            'restant_transport'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
                'type' => 'required',
                'montant' => 'required|numeric',
                'interval_debut' => 'nullable|date',
                'interval_fin' => 'nullable|date|after_or_equal:interval_debut',
                'id_eleve' => 'required|exists:eleves,id'
            ],
            [
                'type.required' => 'Le type de paiement est requis.',
                'montant.required' => 'Le montant est requis.',
                'montant.numeric' => 'Le montant doit être un nombre.',
                'interval_debut.date' => 'La date de début doit être une date valide.',
                'interval_fin.date' => 'La date de fin doit être une date valide.',
                'interval_fin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
                'id_eleve.required' => "L'élève est requis.",
                'id_eleve.exists' => "L'élève sélectionné est introuvable."
            ]
        );

        $eleve = Eleve::with('classe.niveau.cycle')->findOrFail($request->id_eleve);
        $cycle = $eleve->classe->niveau->cycle;
        $niveau = $eleve->classe->niveau;

        $montantInscription = $cycle->montant_inscription;
        $montant_scolarite_mensuel = $niveau->montant_scolarite;
        $montant_transport_mensuel = $cycle->montant_transport;

        $discount = $eleve->discount ?? 0;
        $transport_discount = $eleve->transport_discount ?? 0;
        $reduction = ($montant_scolarite_mensuel * $discount) / 100;
        $transport_reduction = ($montant_transport_mensuel * $transport_discount) / 100;
        $montant_scolarite_mensuel -= $reduction;
        $montant_transport_mensuel -= $transport_reduction;

        $montantScolarite = $montant_scolarite_mensuel * 10;
        $montantTransport = $montant_transport_mensuel * 10;

        $totalPayeInsc = Frais::where('id_eleve', $eleve->id)
            ->where('type', 'inscription')
            ->sum('montant');

        $totalPayeSco = Frais::where('id_eleve', $eleve->id)
        ->where('type', 'scolaire')
        ->sum('montant');

        $totalPayeTrans = Frais::where('id_eleve', $eleve->id)
        ->where('type', 'transport')
        ->sum('montant');

        $nouveauTotalInsc = $totalPayeInsc + $request->montant;
        $nouveauTotalSco = $totalPayeSco + $request->montant;
        $nouveauTotalTrans = $totalPayeTrans + $request->montant;

        // if($request->type === 'inscription') {
        //     $statut = ($nouveauTotalInsc >= $montantInscription) ? 'payé' : 'partiel';
        // }
        // elseif($request->type === 'scolaire') {
        //     $statut = ($nouveauTotalSco >= $montantScolarite) ? 'payé' : 'partiel';
        // }
        // elseif($request->type === 'transport') {
        //     $statut = ($nouveauTotalTrans >= $montantTransport) ? 'payé' : 'partiel';
        // }

        $paiement = new Frais();
        $paiement->type = $request->type;
        $paiement->frequence_paiement = $request->frequence_paiement;
        $paiement->mode_paiement = $request->mode_paiement;
        $paiement->montant = $request->montant;
        $paiement->date_paiement = now();
        $paiement->interval_debut = Carbon::parse($request->interval_debut)->format('Y-m-d');
        $paiement->interval_fin = Carbon::parse($request->interval_fin)->format('Y-m-d');
        $paiement->statut = 'partiel';
        $paiement->année = Carbon::parse($request->interval_debut)->year;
        $paiement->id_eleve = $eleve->id;
        $paiement->id_user = 1;

        try {
            $paiement->save();
        } catch (\Exception $e) {
            return back();
        }

        return redirect()->route('paiement.print', ['id' => $paiement->id, 'from' => 'add']);
    }


    public function print(Request $request, $id)
    {
        $paiement = Frais::findOrFail($id);
        $logoPath = public_path('assets/images/logo/logo4.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $start = Carbon::parse($paiement->interval_debut);
        $end = Carbon::parse($paiement->interval_fin);
        $startMonth = ucfirst($start->translatedFormat('F'));
        $endMonth = ucfirst($end->translatedFormat('F'));

        $eleve = $paiement->eleve;
        $cycle = $paiement->eleve->classe->niveau->cycle;
        $montantInscription = $cycle->montant_inscription;

        $totalUpdate = Frais::where('id_eleve', $eleve->id)
            ->where('type', 'inscription')
            ->where('id', '!=', $paiement->id)
            ->sum('montant') + $paiement->montant;

        $restantUpdate = $montantInscription - $totalUpdate;


        $totalAdd = Frais::where('id_eleve', $eleve->id)
            ->where('type', 'inscription')
            ->sum('montant');

        $restantAdd = $montantInscription - $totalAdd;

        $montantPaiement = $paiement->montant;

        $from = $request->query('from');

        return view('eleves.print_payement', compact('paiement', 'from', 'restantUpdate', 'restantAdd', 'montantPaiement', 'logoBase64', 'start', 'end', 'startMonth', 'endMonth'));
    }

    public function liste($id)
    {
        $eleve = Eleve::with('frais')->findOrFail($id);

        $eleve->frais->transform(function ($frais) {
            $start = Carbon::parse($frais->interval_debut);
            $end = Carbon::parse($frais->interval_fin);

            $months = [
                'January' => 'Janvier', 'February' => 'Février', 'March' => 'Mars',
                'April' => 'Avril', 'May' => 'Mai', 'June' => 'Juin',
                'July' => 'Juillet', 'August' => 'Août', 'September' => 'Septembre',
                'October' => 'Octobre', 'November' => 'Novembre', 'December' => 'Décembre'
            ];

            $startMonth = $months[$start->format('F')];
            $endMonth = $months[$end->format('F')];

            if($start->year === $end->year)
            {
                $start->month === $end->month ? $periode = "$startMonth $start->year" : $periode = "$startMonth / $endMonth $start->year";
            }
            else
            {
                $periode = "$startMonth $start->year / $endMonth $end->year";
            }

            $frais->periode = $periode;

            return $frais;
        });

        $currentYear = now()->year;
        $academicYear = now()->month >= 9 ? $currentYear . ' - ' . ($currentYear + 1) : ($currentYear - 1) . ' - ' . $currentYear;

        return view('eleves.list-payment', compact('eleve', 'academicYear'));
    }

    public function edit($id)
    {
        $paiement = Frais::with('eleve.classe.niveau.cycle')->findOrFail($id);
        $eleve = $paiement->eleve;

        $montant_inscription = $eleve->classe->niveau->cycle->montant_inscription;
        $montant_scolarite_mensuel = $eleve->classe->niveau->montant_scolarite;
        $montant_transport_mensuel = $eleve->classe->niveau->cycle->montant_transport;

        $discount = $eleve->discount ?? 0;
        $transport_discount = $eleve->transport_discount ?? 0;
        $reduction = ($montant_scolarite_mensuel * $discount) / 100;
        $transport_reduction = ($montant_transport_mensuel * $transport_discount) / 100;
        $montant_scolarite_mensuel -= $reduction;
        $montant_transport_mensuel -= $transport_reduction;

        $total_scolarite = $montant_scolarite_mensuel * 10;
        $total_transport = $montant_transport_mensuel * 10;

        $paye_inscription = $eleve->frais()->where('type', 'inscription')->where('statut', '!=', 'non payé')->where('id', '!=', $id)->sum('montant');
        $paye_scolarite = $eleve->frais()->where('type', 'scolaire')->where('statut', '!=', 'non payé')->where('id', '!=', $id)->sum('montant');
        $paye_transport = $eleve->frais()->where('type', 'transport')->where('statut', '!=', 'non payé')->where('id', '!=', $id)->sum('montant');

        $restant_inscription = max($montant_inscription - $paye_inscription, 0);
        $restant_scolarite = max($total_scolarite - $paye_scolarite, 0);
        $restant_transport = max($total_transport - $paye_transport, 0);

        return view('eleves.edit-payment', compact(
            'paiement',
            'eleve',
            'restant_inscription',
            'restant_scolarite',
            'restant_transport'
        ));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'type' => 'required',
            'montant' => 'required|numeric',
            'id_eleve' => 'required|exists:eleves,id',
        ];

        if (in_array($request->type, ['scolaire', 'transport'])) {
            $rules['interval_debut'] = 'required|date';
            $rules['interval_fin'] = 'required|date|after_or_equal:interval_debut';
        } else {
            $rules['interval_debut'] = 'nullable|date';
            $rules['interval_fin'] = 'nullable|date|after_or_equal:interval_debut';
        }

        $messages = [
            'type.required' => 'Le type de paiement est requis.',
            'montant.required' => 'Le montant est requis.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'interval_debut.required' => 'La date de début est requise.',
            'interval_debut.date' => 'La date de début doit être une date valide.',
            'interval_fin.required' => 'La date de fin est requise.',
            'interval_fin.date' => 'La date de fin doit être une date valide.',
            'interval_fin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
            'id_eleve.required' => "L'élève est requis.",
            'id_eleve.exists' => "L'élève sélectionné est introuvable.",
        ];

        $request->validate($rules, $messages);

        $paiement = Frais::findOrFail($id);
        $eleve = Eleve::with('classe.niveau.cycle')->findOrFail($request->id_eleve);
        $cycle = $eleve->classe->niveau->cycle;
        $niveau = $eleve->classe->niveau;

        $montantInscription = $cycle->montant_inscription;
        $montant_scolarite_mensuel = $niveau->montant_scolarite;
        $montant_transport_mensuel = $cycle->montant_transport;

        $discount = $eleve->discount ?? 0;
        $transport_discount = $eleve->transport_discount ?? 0;
        $reduction = ($montant_scolarite_mensuel * $discount) / 100;
        $transport_reduction = ($montant_transport_mensuel * $transport_discount) / 100;
        $montant_scolarite_mensuel -= $reduction;
        $montant_transport_mensuel -= $transport_reduction;

        $montantScolarite = $montant_scolarite_mensuel * 10;
        $montantTransport = $montant_transport_mensuel * 10;

        $totalPayeInsc = Frais::where('id_eleve', $eleve->id)
            ->where('type', 'inscription')
            ->where('id', '!=', $paiement->id)
            ->sum('montant');

        $totalPayeSco = Frais::where('id_eleve', $eleve->id)
        ->where('type', 'scolaire')
        ->where('id', '!=', $paiement->id)
        ->sum('montant');

        $totalPayeTrans = Frais::where('id_eleve', $eleve->id)
        ->where('type', 'transport')
        ->where('id', '!=', $paiement->id)
        ->sum('montant');

        $nouveauTotalInsc = $totalPayeInsc + $request->montant;
        $nouveauTotalSco = $totalPayeSco + $request->montant;
        $nouveauTotalTrans = $totalPayeTrans + $request->montant;

        // $statut = '';

        // if($request->type === 'Inscription') {
        //     $statut = ($nouveauTotalInsc >= $montantInscription) ? 'payé' : 'partiel';
        // }
        // elseif($request->type === 'Scolaire') {
        //     $statut = ($nouveauTotalSco >= $montantScolarite) ? 'payé' : 'partiel';
        // }
        // elseif($request->type === 'Transport') {
        //     $statut = ($nouveauTotalTrans >= $montantTransport) ? 'payé' : 'partiel';
        // }

        $paiement->type = $request->type;
        $paiement->frequence_paiement = $request->frequence_paiement;
        $paiement->mode_paiement = $request->mode_paiement;
        $paiement->montant = $request->montant;
        $paiement->interval_debut = $request->interval_debut ? Carbon::parse($request->interval_debut)->format('Y-m-d') : null;
        $paiement->interval_fin = $request->interval_fin ? Carbon::parse($request->interval_fin)->format('Y-m-d') : null;
        $paiement->année = $request->interval_debut ? Carbon::parse($request->interval_debut)->year : null;
        $paiement->statut = 'partiel';
        $paiement->id_eleve = $eleve->id;
        $paiement->id_user = Auth::id() ?? 1;

        try {
            $paiement->save();
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour du paiement.');
        }

        return redirect()->route('paiement.print', ['id' => $paiement->id, 'from' => 'update']);
    }


    public function destroy($id)
    {
        $paiement = Frais::findOrFail($id);

        if ($paiement) {
            $paiement->delete();

            return redirect()->route('paiements.liste', $paiement->id_eleve);
        }

        return redirect()->route('paiements.liste', $paiement->id_eleve);
    }
}