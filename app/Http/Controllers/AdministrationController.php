<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Models\Niveau;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdministrationController extends Controller
{
    public function listeCycle() {
        $cycles = Cycle::all();
        return view('administration.Cycle.listeCycle',compact('cycles'));
    }

    public function ajouterCycle() {
        return view('administration.Cycle.ajouterCycle');
    }

    public function storeCycle(Request $request) {
        $validation = $request->validate([
            'cycle' => 'required|string',
            'montant_inscription' => 'required',
            'montant_transport' => 'required'
        ], [
            'cycle.required' => 'Le nom du cycle est requis.',
            'cycle.string' => 'Le nom du cycle doit être une chaîne de caractères.',
            'montant_inscription.required' => 'Le montant d\'inscription est requis.',
            'montant_transport.required' => 'Le montant de transport est requis.'
        ]);

        Cycle::create([
            'nom' => $validation['cycle'],
            'montant_inscription' => $validation['montant_inscription'],
            'montant_transport' => $validation['montant_transport']
        ]);

        return redirect()->route('cycle.liste');
    }

    public function modifierCycle(Cycle $cycle) {
        return view('administration.Cycle.modifierCycle',compact('cycle'));
    }


    public function updateCycle(Request $request, Cycle $cycle) {
        $validation = $request->validate([
            'cycle' => 'required|string',
            'montant_inscription' => 'required',
            'montant_transport' => 'required'
        ], [
            'cycle.required' => 'Le nom du cycle est requis.',
            'cycle.string' => 'Le nom du cycle doit être une chaîne de caractères.',
            'montant_inscription.required' => 'Le montant d\'inscription est requis.',
            'montant_transport.required' => 'Le montant de transport est requis.'
        ]);

        $cycle->nom = $validation['cycle'];
        $cycle->montant_inscription = $validation['montant_inscription'];
        $cycle->montant_transport = $validation['montant_transport'];
        $cycle->save();

        return redirect()->route('cycle.liste');
    }

    public function deleteCycle($cycleId)
    {
        $cycle = Cycle::findOrFail($cycleId);
        $cycle->delete();

        return redirect()->route('cycle.liste');
    }

    public function listeNiveau()
    {
        $cycles = Cycle::all();

        if ($cycles->isEmpty()) {

            return redirect()->route('cycle.liste');
        }
        else {
            $cycle = $cycles->first();
            $niveaux = Niveau::where('id_cycle', $cycle->id)->get();

            return view('administration.Niveau.listeNiveau', compact(['cycles', 'niveaux']));
        }
    }

    public function ajouterNiveau() {
        $cycles = Cycle::all();

        return view('administration.Niveau.ajouterNiveau',compact('cycles'));
    }

    public function storeNiveau(Request $request) {
        $validation = $request->validate([
            'niveau' => 'required|string',
            'cycle' => 'required|integer',
            'montant_scolarite' => 'required'
        ], [
            'niveau.required' => 'Le nom du niveau est requis.',
            'niveau.string' => 'Le nom du niveau doit être une chaîne de caractères.',
            'cycle.required' => 'Le cycle est requis.',
            'cycle.integer' => 'Le cycle doit être un identifiant valide.',
            'montant_scolarite.required' => 'Le montant de scolarité est requis.'
        ]);

        Niveau::create([
            'nom' => $validation['niveau'],
            'id_cycle' => $validation['cycle'],
            'montant_scolarite' => $validation['montant_scolarite']
        ]);

        return redirect()->route('niveau.liste');
    }

    public function modifierNiveau(Niveau $niveau) {
        $cycles = Cycle::all();
        return view('administration.Niveau.modifierNiveau',compact(['niveau','cycles']));
    }

    public function updateNiveau(Request $request, Niveau $niveau) {

        $validation = $request->validate([
            'niveau' => 'required|string',
            'cycle' => 'required|integer',
            'montant_scolarite' => 'required'
        ], [
            'niveau.required' => 'Le nom du niveau est requis.',
            'niveau.string' => 'Le nom du niveau doit être une chaîne de caractères.',
            'cycle.required' => 'Le cycle est requis.',
            'cycle.integer' => 'Le cycle doit être un identifiant valide.',
            'montant_scolarite.required' => 'Le montant de scolarité est requis.'
        ]);

        $niveau->nom = $validation['niveau'];
        $niveau->id_cycle = $validation['cycle'];
        $niveau->montant_scolarite = $validation['montant_scolarite'];
        $niveau->save();

        return redirect()->route('niveau.liste');
    }

    public function deleteNiveau($niveauId)
    {
        $niveau = Niveau::findOrFail($niveauId);
        $niveau->delete();

        return back();
    }

    public function filtreNiveau(Request $request)
    {
        $cycles = Cycle::all();
        $cycleId = $request->select;

        $niveaux = $cycleId ? Niveau::where('id_cycle', $cycleId)->get() : Niveau::all();

        return view('administration.Niveau.listeNiveau', compact(['niveaux', 'cycles']));
    }

    // Classes Logic

    public function indexClasse() {
        $cycles = Cycle::all();
        $cycle = DB::table('cycles')->orderBy('id', 'asc')->first();

        if ($cycles->isEmpty()) {

            return redirect()->route('cycle.liste');
        }
        else {
            $niveaux = Niveau::where('id_cycle', $cycle->id)->get();
        }

        if ($niveaux->isEmpty()) {
            return redirect()->route('niveau.liste');
        }
        else {
            $classes = Classe::with('niveau')->get();
            return view('administration.Classe.index', compact(['cycles', 'niveaux', 'classes']));
        }
    }

    public function filterClasse(Request $request)
    {
        $cycleId = $request->cycle;
        $niveauId = $request->niveau;
        $cycles = Cycle::all();
        $niveaux = $cycleId ? Niveau::where('id_cycle', $cycleId)->get() : Niveau::all();

        if ($niveauId) {
            $classes = Classe::where('id_niveau', $niveauId)->get();
        } elseif ($cycleId) {
            $niveauIds = Niveau::where('id_cycle', $cycleId)->pluck('id');
            $classes = Classe::whereIn('id_niveau', $niveauIds)->get();
        } else {
            $classes = Classe::all();
        }

        return view('administration.Classe.index', compact('cycles', 'niveaux', 'classes'));
    }


    public function insertClasse() {
        $cycles = Cycle::all();
        $niveaux = Niveau::all();

        return view('administration.Classe.insert', compact(['cycles', 'niveaux']));
    }

    public function storeClasse(Request $request) {
        $validation = $request->validate([
            'classe' => 'required|string',
            'niveau' => 'required|integer'
        ], [
            'classe.required' => 'Le nom de la classe est requis.',
            'classe.string' => 'Le nom de la classe doit être une chaîne de caractères.',
            'niveau.required' => 'Le niveau est requis.',
            'niveau.integer' => 'Le niveau doit être un identifiant valide.'
        ]);

        Classe::create([
            'nom' => $validation['classe'],
            'id_niveau' => $validation['niveau']
        ]);

        return redirect()->route('classes.index');
    }

    public function editClasse(Classe $classe) {
        $cycles = Cycle::all();
        $niveaux = Niveau::all();

        return view('administration.Classe.edit', compact(['classe', 'cycles', 'niveaux']));
    }

    public function updateClasse(Request $request, Classe $classe) {
        $validation = $request->validate([
            'classe' => 'required|string',
            'niveau' => 'required|integer'
        ], [
            'classe.required' => 'Le nom de la classe est requis.',
            'classe.string' => 'Le nom de la classe doit être une chaîne de caractères.',
            'niveau.required' => 'Le niveau est requis.',
            'niveau.integer' => 'Le niveau doit être un identifiant valide.'
        ]);

        $classe->nom = $validation['classe'];
        $classe->id_niveau = $validation['niveau'];
        $classe->save();

        return redirect()->route('classes.index');
    }

    public function deleteClasse($classeId)
    {
        $classe = Classe::findOrFail($classeId);
        $classe->delete();

        return back();
    }
}