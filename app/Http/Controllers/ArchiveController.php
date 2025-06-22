<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frais;
use App\Models\Eleve;
use App\Models\FraisArchive;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ArchiveController extends Controller
{
    public function archiveFrais()
    {
        $currentDate = now();
        $startDate = now()->setMonth(7)->setDay(1);
        $endDate = now()->setMonth(9)->setDay(1);

        if ($currentDate->between($startDate, $endDate)) {
            DB::transaction(function () {
                DB::table('frais_archives')->insertUsing(
                    ['type', 'montant', 'mode_paiement', 'date_paiement', 'frequence_paiement', 'interval_debut', 'interval_fin', 'statut', 'année', 'id_eleve', 'id_user', 'created_at', 'updated_at'],
                    DB::table('frais')->whereNull('deleted_at')->select('type', 'montant', 'mode_paiement', 'date_paiement', 'frequence_paiement', 'interval_debut', 'interval_fin', 'statut', 'année', 'id_eleve', 'id_user', DB::raw('NOW() as created_at'), DB::raw('NOW() as updated_at'))
                );

                DB::table('frais')->delete();
            });
            return redirect()->back();
        }
        else {
            return redirect()->back();
        }
    }

    public function archivedFrais(Request $request)
    {
        $query = FraisArchive::query();

        if ($request->filled('academic_year') && $request->input('academic_year') !== 'all') {
            $academicYear = $request->input('academic_year');
            $query->filterByAcademicYear($academicYear);
        }

        if ($request->filled('search')) {
            $searchTerm = trim($request->input('search'));
            $searchTerms = explode(' ', $searchTerm);

            $query->whereHas('eleve', function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->where(function ($subQ) use ($term) {
                        $subQ->where('nom', 'LIKE', "%{$term}%")
                             ->orWhere('prenom', 'LIKE', "%{$term}%");
                    });
                }
            });
        }

        $fraisArchives = $query->get();

        $fraisArchives->transform(function ($frais) {
            $start = \Carbon\Carbon::parse($frais->interval_debut);
            $end = \Carbon\Carbon::parse($frais->interval_fin);
            $datePaiement = \Carbon\Carbon::parse($frais->date_paiement);

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
                $start->month === $end->month ? $periode = "$startMonth $start->year" : $periode = "$startMonth - $endMonth";
            }
            else
            {
                $periode = "$startMonth - $endMonth";
            }

            $academicYear = $start->month >= 9 ?
                $start->year . ' - ' . ($start->year + 1) :
                ($start->year - 1) . ' - ' . $start->year;

            $frais->datePaiementFormatee = $datePaiement->format('d') . ' ' . $months[$datePaiement->format('F')] . ' ' . $datePaiement->year;

            $frais->periode = $periode;
            $frais->academicYear = $academicYear;

            return $frais;
        });

        $academicYears = FraisArchive::selectRaw('YEAR(date_paiement) - IF(MONTH(date_paiement) >= 9, 0, 1) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('eleves.archived_payments', compact('fraisArchives', 'academicYears'));
    }

    public function viderArchives()
    {
        try {
            FraisArchive::truncate();
            return back();
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur lors du vidage des archives.'], 500);
        }
    }

    public function corbeille()
    {
        $fraisSupprimes = Frais::onlyTrashed()->get();

        $fraisSupprimes->transform(function ($frais) {
            $start = \Carbon\Carbon::parse($frais->interval_debut);
            $end = \Carbon\Carbon::parse($frais->interval_fin);

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
                $start->month === $end->month ? $periode = "$startMonth $start->year" : $periode = "$startMonth - $endMonth";
            }
            else
            {
                $periode = "$startMonth - $endMonth";
            }

            $academicYear = $start->month >= 9 ?
                $start->year . ' - ' . ($start->year + 1) :
                ($start->year - 1) . ' - ' . $start->year;

            $frais->periode = $periode;
            $frais->academicYear = $academicYear;

            return $frais;
        });

        return view('eleves.trash', compact('fraisSupprimes'));
    }

    public function corbeilleEleve($eleve_id)
    {
        $eleve = Eleve::findOrFail($eleve_id);
        $fraisSupprimes = Frais::onlyTrashed()->where('id_eleve', $eleve_id)->get();

        $fraisSupprimes->transform(function ($frais) {
            $start = \Carbon\Carbon::parse($frais->interval_debut);
            $end = \Carbon\Carbon::parse($frais->interval_fin);

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
                $start->month === $end->month ? $periode = "$startMonth $start->year" : $periode = "$startMonth - $endMonth";
            }
            else
            {
                $periode = "$startMonth - $endMonth";
            }

            $academicYear = $start->month >= 9 ?
                $start->year . ' - ' . ($start->year + 1) :
                ($start->year - 1) . ' - ' . $start->year;

            $frais->periode = $periode;
            $frais->academicYear = $academicYear;

            return $frais;
        });

        return view('eleves.trash_eleve', compact('eleve', 'fraisSupprimes'));
    }

    public function restore($id)
    {
        $frais = Frais::onlyTrashed()->findOrFail($id);
        $frais->restore();

        return redirect()->route('frais.corbeille');
    }

    public function restoreAll()
    {
        Frais::onlyTrashed()->restore();

        return redirect()->route('frais.corbeille');
    }

    public function restoreForEleve($eleve_id, $id)
    {
        $frais = Frais::onlyTrashed()->where('id_eleve', $eleve_id)->findOrFail($id);
        $frais->restore();

        return redirect()->route('frais.corbeille.eleve', $eleve_id);
    }

    public function restoreAllForEleve($eleve_id)
    {
        Frais::onlyTrashed()->where('id_eleve', $eleve_id)->restore();

        return redirect()->route('frais.corbeille.eleve', $eleve_id);
    }

    public function viderCorbeilleGenerale()
    {
        Frais::onlyTrashed()->forceDelete();

        return redirect()->back();
    }

    public function viderCorbeilleParEleve($eleve_id)
    {
        Frais::onlyTrashed()->where('id_eleve', $eleve_id)->forceDelete();

        return redirect()->back();
    }
}
