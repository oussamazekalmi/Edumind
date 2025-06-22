<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cycle;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EleveController extends Controller
{
    public function index(Request $request)
    {
        $query = Eleve::query();

        if ($request->filled('search')) {
            $searchTerm = trim($request->input('search'));
            $searchTerms = preg_split('/\s+/', $searchTerm); // split by spaces

            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->where(function ($sub) use ($term) {
                        $sub->where('nom', 'LIKE', "%{$term}%")
                            ->orWhere('prenom', 'LIKE', "%{$term}%");
                    });
                }
            });
        }

        $eleves = $query->where('statut', 'en_cours')->get();

        foreach ($eleves as $eleve) {
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

            $eleve->statut_paiement = [
                'inscription' => $restant_inscription == 0 ? 'paye' : ($restant_inscription < $eleve->classe->niveau->cycle->montant_inscription ? 'partiel' : 'non'),
                'scolarite'   => $restant_scolarite == 0 ? 'paye' : ($restant_scolarite < ($total_scolarite) ? 'partiel' : 'non'),
                'transport'   => $restant_transport == 0 ? 'paye' : ($restant_transport < ($total_transport) ? 'partiel' : 'non'),
            ];
        }

        return view('eleves.index', compact('eleves'));
    }

    public function show($id)
    {
        $eleve = Eleve::where('statut', 'en_cours')->with(['classe.niveau.cycle', 'frais'])->findOrFail($id);

        $montant_inscription = $eleve->classe->niveau->cycle->montant_inscription ?? 0;
        $paiementsInscription = $eleve->frais->where('type', 'inscription');
        $totalPayeInscription = $paiementsInscription->sum('montant');

        $etatInscription = match (true) {
            $totalPayeInscription >= $montant_inscription => 'payé',
            $totalPayeInscription > 0 => 'partiel',
            default => 'non payé',
        };

        $paiementsEtudes = $eleve->frais->where('type', 'scolaire')->sortBy('date_paiement');
        $paiementsTransport = $eleve->frais->where('type', 'transport')->sortBy('date_paiement');

        $fraisInscPartiels = $paiementsInscription->where('statut', 'partiel');
        $fraisScocPartiels = $paiementsEtudes->where('statut', 'partiel');
        $fraisTransPartiels = $paiementsTransport->where('statut', 'partiel');

        $fraisScocPayed = $paiementsEtudes->where('statut', '!=', 'non payé');
        $fraisTransPayed = $paiementsTransport->where('statut', '!=', 'non payé');


        $date_actuelle = Carbon::now();
        $periode_modification = $date_actuelle->between(
            Carbon::createFromFormat('d-m', '01-07'),
            Carbon::createFromFormat('d-m', '01-09')
        );

        $paiementInscription = null;
        if ($etatInscription === 'payé') {
            $paiementInscription = $paiementsInscription->sortByDesc('date_paiement')->first();
        }

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

        $etatScolarite = match (true) {
            $paye_scolarite >= $total_scolarite => 'payé',
            $paye_scolarite > 0 => 'partiel',
            default => 'non payé',
        };

        $etatTransport = match (true) {
            $paye_transport >= $total_transport => 'payé',
            $paye_transport > 0 => 'partiel',
            default => 'non payé',
        };

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
                $start->month === $end->month ? $periode = "$startMonth" : $periode = "$startMonth - $endMonth";
            }
            else
            {
                $periode = "$startMonth - $endMonth";
            }

            $frais->periode = $periode;

            return $frais;
        });

        return view('eleves.show', compact(
            'eleve',
            'etatInscription',
            'fraisInscPartiels',
            'montant_inscription',
            'periode_modification',
            'paiementInscription',
            'paiementsEtudes',
            'paiementsTransport',
            'fraisScocPartiels',
            'fraisTransPartiels',
            'fraisScocPayed',
            'fraisTransPayed',
            'etatScolarite',
            'etatTransport',
            'total_scolarite',
            'paye_scolarite',
            'total_transport',
            'paye_transport'
        ));
    }

    public function updateStatutBatch(Request $request)
    {
        $submitType = $request->input('submit_type');

        if ($submitType === 'passation') {
            $passationData = $request->input('passation');

            foreach ($passationData as $eleveId => $isReussit) {
                $eleve = Eleve::findOrFail($eleveId);

                $eleve->isreussit = $isReussit;

                $currentYear = now()->year;
                $startOfAcademicYear = now()->month >= 9 ? $currentYear : $currentYear - 1;
                $academicYear = $startOfAcademicYear . ' - ' . ($startOfAcademicYear + 1);
                $eleve->annee_academique = $academicYear;

                if ($eleve->isreussit) {
                    $lastNiveau = Niveau::orderBy('id', 'desc')->first();
                    $nextNiveau = Niveau::where('id', '>', $eleve->classe->id_niveau)->orderBy('id')->first();

                    if ($nextNiveau) {
                        $firstClasseInNextNiveau = Classe::where('id_niveau', $nextNiveau->id)->orderBy('id')->first();

                        if ($firstClasseInNextNiveau) {
                            $eleve->id_classe = $firstClasseInNextNiveau->id;
                        }
                    } elseif ($eleve->classe->id_niveau == $lastNiveau->id) {
                        $eleve->statut = 'lauréat';
                        $eleve->annee_obtention_bac = now()->year;
                        $eleve->id_classe = null;
                    }
                }

                $eleve->save();
            }
            return back();
        }

        if ($submitType === 'classe') {
            $classData = $request->input('classes');

            foreach ($classData as $eleveId => $classId) {
                $eleve = Eleve::findOrFail($eleveId);
                $eleve->id_classe = $classId;
                $eleve->save();
            }

            return back();
        }

        return back();
    }

    public function updateStatut(Request $request, $id)
    {
        $eleve = Eleve::findOrFail($id);
        $eleve->isreussit = $request->input('isreussit');

        $currentYear = now()->year;
        $startOfAcademicYear = now()->month >= 9 ? $currentYear : $currentYear - 1;
        $academicYear = $startOfAcademicYear . ' - ' . ($startOfAcademicYear + 1);
        $eleve->annee_academique = $academicYear;

        if ($eleve->isreussit) {
            $lastNiveau = Niveau::orderBy('id', 'desc')->first();
            $nextNiveau = Niveau::where('id', '>', $eleve->classe->id_niveau)->orderBy('id')->first();

            if ($nextNiveau) {
                $firstClasseInNextNiveau = Classe::where('id_niveau', $nextNiveau->id)->orderBy('id')->first();

                if ($firstClasseInNextNiveau) {
                    $eleve->id_classe = $firstClasseInNextNiveau->id;
                }
            } elseif ($eleve->classe->id_niveau == $lastNiveau->id) {
                $eleve->statut = 'lauréat';
                $eleve->annee_obtention_bac = now()->year;
                $eleve->id_classe = null;
            }
        }

        $eleve->save();

        return back();
    }

    public function revertStatut(Request $request, $id)
    {
        $eleve = Eleve::findOrFail($id);

        $request->validate([
            'isreussit' => 'required|boolean',
        ]);

        $newStatus = $request->input('isreussit');

        $currentYear = now()->year;
        $startOfAcademicYear = now()->month >= 9 ? $currentYear : $currentYear - 1;
        $academicYear = $startOfAcademicYear . ' - ' . ($startOfAcademicYear + 1);
        $eleve->annee_academique = $academicYear;

        $lastNiveau = Niveau::orderBy('id', 'desc')->first();
        $currentClasse = $eleve->classe;
        $currentNiveauId = $currentClasse->id_niveau ?? null;

        if ($eleve->isreussit == 1 && $newStatus == 0) {
            if ($currentNiveauId !== null) {
                $previousNiveau = Niveau::where('id', '<', $currentNiveauId)->orderBy('id', 'desc')->first();

                if ($previousNiveau) {
                    $fallbackClasse = Classe::where('id_niveau', $previousNiveau->id)->orderBy('id')->first();

                    if ($fallbackClasse) {
                        $eleve->id_classe = $fallbackClasse->id;
                        $eleve->statut = 'en_cours';
                        $eleve->annee_obtention_bac = null;
                    }
                }
            }
        }

        elseif ($eleve->isreussit == 0 && $newStatus == 1) {
            if ($currentNiveauId !== null) {
                $nextNiveau = Niveau::where('id', '>', $currentNiveauId)->orderBy('id')->first();

                if ($nextNiveau) {
                    $nextClasse = Classe::where('id_niveau', $nextNiveau->id)->orderBy('id')->first();

                    if ($nextClasse) {
                        $eleve->id_classe = $nextClasse->id;
                        $eleve->statut = 'en_cours';
                    }
                } elseif ($currentNiveauId == $lastNiveau->id) {
                    $eleve->statut = 'lauréat';
                    $eleve->annee_obtention_bac = now()->year;
                    $eleve->id_classe = null;
                }
            }
        }

        $eleve->isreussit = $newStatus;
        $eleve->save();

        return back();
    }

    public function elevesReussis(Request $request)
    {
        $currentYear = now()->year;
        $currentAcademicYear = now()->month >= 9 ? $currentYear . ' - ' . ($currentYear + 1) : ($currentYear - 1) . ' - ' . $currentYear;
        $previousAcademicYear = now()->month >= 9 ? ($currentYear - 1) . ' - ' . $currentYear : ($currentYear - 2) . ' - ' . ($currentYear - 1);

        $searchTerm = $request->input('search');
        $cycleId = $request->input('cycle_id');
        $niveauId = $request->input('niveau_id');
        $classeId = $request->input('classe_id');

        $baseQuery = function ($query) use ($searchTerm) {
            if ($searchTerm) {
                $terms = explode(' ', trim($searchTerm));
                $query->where(function ($q) use ($terms) {
                    foreach ($terms as $term) {
                        $q->orWhere('nom', 'LIKE', "%{$term}%")
                        ->orWhere('prenom', 'LIKE', "%{$term}%");
                    }
                });
            }
        };

        $classes = Classe::all()->groupBy('id_niveau');
        $niveaux = Niveau::orderBy('id')->get();
        $cycles = Cycle::all();

        $eleves = Eleve::with('classe.niveau.cycle')
            ->where('statut', 'en_cours')
            ->when($request->filled('cycle_id'), function ($query) use ($request) {
                $query->whereHas('classe.niveau', function ($q) use ($request) {
                    $q->where('id_cycle', $request->input('cycle_id'));
                });
            })
            ->when($request->filled('niveau_id'), function ($query) use ($request) {
                $query->whereHas('classe', function ($q) use ($request) {
                    $q->where('id_niveau', $request->input('niveau_id'));
                });
            })
            ->when($request->filled('classe_id'), function ($query) use ($request) {
                $query->where('id_classe', $request->input('classe_id'));
            })
            ->get();

        $eleves_reussis = Eleve::with('classe.niveau.cycle')
            ->where('isreussit', 1)
            ->where('statut', 'en_cours')
            ->where('annee_academique', $previousAcademicYear)
            ->when($request->filled('cycle_id'), function ($query) use ($request) {
                $query->whereHas('classe.niveau', function ($q) use ($request) {
                    $q->where('id_cycle', $request->input('cycle_id'));
                });
            })
            ->when($request->filled('niveau_id'), function ($query) use ($request) {
                $query->whereHas('classe', function ($q) use ($request) {
                    $q->where('id_niveau', $request->input('niveau_id'));
                });
            })
            ->when($request->filled('classe_id'), function ($query) use ($request) {
                $query->where('id_classe', $request->input('classe_id'));
            })
            ->where($baseQuery)
            ->get();

        $eleves_redoublants = Eleve::with('classe.niveau.cycle')
            ->where('isreussit', 0)
            ->where('statut', 'en_cours')
            ->where('annee_academique', $previousAcademicYear)
            ->when($request->filled('cycle_id'), function ($query) use ($request) {
                $query->whereHas('classe.niveau', function ($q) use ($request) {
                    $q->where('id_cycle', $request->input('cycle_id'));
                });
            })
            ->when($request->filled('niveau_id'), function ($query) use ($request) {
                $query->whereHas('classe', function ($q) use ($request) {
                    $q->where('id_niveau', $request->input('niveau_id'));
                });
            })
            ->when($request->filled('classe_id'), function ($query) use ($request) {
                $query->where('id_classe', $request->input('classe_id'));
            })
            ->where($baseQuery)
            ->get();

        $eleves_laureats = Eleve::with('classe.niveau.cycle')
            ->where('statut', 'lauréat')
            ->when($request->filled('cycle_id'), function ($query) use ($request) {
                $query->whereHas('classe.niveau', function ($q) use ($request) {
                    $q->where('id_cycle', $request->input('cycle_id'));
                });
            })
            ->when($request->filled('niveau_id'), function ($query) use ($request) {
                $query->whereHas('classe', function ($q) use ($request) {
                    $q->where('id_niveau', $request->input('niveau_id'));
                });
            })
            ->when($request->filled('classe_id'), function ($query) use ($request) {
                $query->where('id_classe', $request->input('classe_id'));
            })
            ->where($baseQuery)
            ->get();

        $eleves_quittes = Eleve::with('classe.niveau.cycle')
            ->where('statut', 'quitté')
            ->where($baseQuery)
            ->when($request->filled('cycle_id'), function ($query) use ($request) {
                $query->whereHas('classe.niveau', function ($q) use ($request) {
                    $q->where('id_cycle', $request->input('cycle_id'));
                });
            })
            ->when($request->filled('niveau_id'), function ($query) use ($request) {
                $query->whereHas('classe', function ($q) use ($request) {
                    $q->where('id_niveau', $request->input('niveau_id'));
                });
            })
            ->when($request->filled('classe_id'), function ($query) use ($request) {
                $query->where('id_classe', $request->input('classe_id'));
            })
            ->get();

        if ($eleves->isEmpty() || ($eleves_reussis->isEmpty() && $eleves_redoublants->isEmpty() && $eleves_laureats->isEmpty() && $eleves_quittes->isEmpty())) {

            return redirect()->back();
        }
        return view('eleves.liste-reussis', compact('eleves', 'classes', 'niveaux', 'eleves_reussis', 'eleves_redoublants', 'eleves_laureats', 'eleves_quittes', 'currentAcademicYear'));
    }

    public function ajouterEleve() {
        $cycles = Cycle::all();
        if(count($cycles) < 1) return redirect()->back();
        $cycle = DB::table('cycles')->orderBy('id','asc')->first();
        $niveaux = Niveau::where('id_cycle',$cycle->id)->get();
        return view('eleves.add-eleve',compact(['cycles','niveaux']));
    }


    public function filterNiveau(Request $request) {
        $cycle = $request->query('cycle_id');
        $niveaux = Niveau::where('id_cycle',$cycle)->get();
        return response()->json($niveaux);
    }

    public function filterClasses(Request $request)
    {
        $niveauId = $request->query('niveau_id');

        if (!$niveauId) {
            return response()->json([]);
        }
        $classes = Classe::where('id_niveau', $niveauId)->get(['id', 'nom']);

        return response()->json($classes);
    }

    public function storeEleve(Request $request)
    {
        $validation = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'string|max:255',
            'cne' => [
                'required',
                'unique:eleves,cne',
                'regex:/^[A-Za-z]{1}[0-9]{9}$/'
            ],
            'cin' => [
                'nullable',
                'regex:/^[Ff][0-9]{6}$/'
            ],
            'id_classe' => 'required',
            'a_transport' => 'required',
            'statut'=> 'required',
            'discount' => 'nullable|in:0,5,10,15,20,25',
            'transport_discount' => 'nullable|in:0,25,50,75'
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'date_naissance.required' => 'La date de naissance est obligatoire.',
            'date_naissance.date' => 'Veuillez entrer une date valide.',
            'lieu_naissance.max' => 'Le lieu de naissance ne doit pas dépasser 255 caractères.',
            'cne.required' => 'Le CNE est obligatoire.',
            'cne.unique' => 'Ce CNE est déjà enregistré.',
            'cne.regex' => 'Le CNE doit commencer par une lettre suivie de 9 chiffres.',
            'cin.regex' => 'La CIN doit commencer par "F" suivi de 6 chiffres.',
            'id_classe.required' => 'La classe est obligatoire.',
            'a_transport.required' => 'Il est nécessaire de spécifier si le transport est disponible.',
            'statut.required' => 'Il est nécessaire de spécifier si le statut.',
            'discount.in' => 'Le pourcentage de réduction sélectionné est invalide.',
            'transport_discount.in' => 'Le pourcentage de réduction sélectionné est invalide.'
        ]);

        $nextId = Eleve::count() + 1;

        if ($nextId > 9999) {
            return redirect()->route('eleves.index')->with("error", "Vous avez dépassé le nombre maximum des inscriptions autorisé.");
        }

        $num_inscription = 'GS-RAM' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        Eleve::create([
            'num_inscription' => $num_inscription,
            'nom' => $validation['nom'],
            'prenom' => $validation['prenom'],
            'cne' => $validation['cne'],
            'cin' => $request->input('cin'),
            'genre' => $request->input('genre'),
            'statut' => $request->input('statut'),
            'date_inscription' => date('Y-m-d'),
            'date_naissance' => $validation['date_naissance'],
            'lieu_naissance' => $validation['lieu_naissance'],
            'adresse' => $request->input('adresse'),
            'statut_familial' => $request->input('statut_familial'),
            'statut_responsable' => $request->input('statut_responsable'),
            'statut_autre' => $request->input('statut_autre'),
            'nom_responsable' => $request->input('nom_responsable'),
            'tel_responsable' => $request->input('tel_responsable'),
            'nom_pere' => $request->input('nom_pere'),
            'nom_mere' => $request->input('nom_mere'),
            'tel_pere' => $request->input('tel_pere'),
            'tel_mere' => $request->input('tel_mere'),
            'profession_pere' => $request->input('profession_pere'),
            'profession_mere' => $request->input('profession_mere'),
            'a_transport' => (int)$request->input('a_transport'),
            'id_classe' => (int)$request->input('id_classe'),
            'discount' => $request->input('discount') ?? 0,
            'transport_discount' => $request->input('transport_discount') ?? 0
        ]);

        return redirect()->route('eleves.index');
    }

    public function modifierEleve($id)
    {
        $eleve = Eleve::findOrFail($id);
        $cycles = Cycle::all();

        $classe = Classe::with('niveau')->find($eleve->id_classe);
        $niveaux = Niveau::where('id_cycle', $classe->niveau->id_cycle)->get();
        $classes = Classe::where('id_niveau', $classe->id_niveau)->get();

        return view('eleves.update-eleve', compact('eleve', 'cycles', 'niveaux', 'classes'));
    }

    public function updateEleve(Request $request, $id)
    {
        $eleve = Eleve::findOrFail($id);

        $validation = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'cne' => [
                'required',
                'unique:eleves,cne,' . $eleve->id,
                'regex:/^[A-Za-z]{1}[0-9]{9}$/'
            ],
            'cin' => [
                'nullable',
                'regex:/^[Ff][0-9]{6}$/'
            ],
            'id_classe' => 'required',
            'a_transport' => 'required',
            'statut'=> 'required',
            'discount' => 'nullable|in:0,5,10,15,20,25',
            'transport_discount' => 'nullable|in:0,25,50,75'
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'date_naissance.required' => 'La date de naissance est obligatoire.',
            'date_naissance.date' => 'Veuillez entrer une date valide.',
            'lieu_naissance.max' => 'Le lieu de naissance ne doit pas dépasser 255 caractères.',
            'cne.required' => 'Le CNE est obligatoire.',
            'cne.unique' => 'Ce CNE est déjà enregistré.',
            'cne.regex' => 'Le CNE doit commencer par une lettre suivie de 9 chiffres.',
            'cin.regex' => 'La CIN doit commencer par "F" suivi de 6 chiffres.',
            'id_classe.required' => 'La classe est obligatoire.',
            'a_transport.required' => 'Il est nécessaire de spécifier si le transport est disponible.',
            'statut.required' => 'Il est nécessaire de spécifier si le statut.',
            'discount.in' => 'Le pourcentage de réduction sélectionné est invalide.',
            'transport_discount.in' => 'Le pourcentage de réduction sélectionné est invalide.'
        ]);

        $idClasse = $request->input('statut') === 'quitté' ? null : (int) $request->input('id_classe');

        $res_statut = in_array($request->input('statut_responsable'), ['père', 'mère']);

        $statut_autre = $res_statut ? null : $request->input('statut_autre');
        $nom_responsable = $res_statut ? null : $request->input('nom_responsable');
        $tel_responsable = $res_statut ? null : $request->input('tel_responsable');


        $eleve->update([
            'nom' => $validation['nom'],
            'prenom' => $validation['prenom'],
            'cne' => $validation['cne'],
            'cin' => $request->input('cin'),
            'genre' => $request->input('genre'),
            'date_naissance' => $validation['date_naissance'],
            'lieu_naissance' => $validation['lieu_naissance'],
            'adresse' => $request->input('adresse'),
            'statut' => $request->input('statut'),
            'statut_familial' => $request->input('statut_familial'),
            'statut_responsable' => $request->input('statut_responsable'),
            'statut_autre' => $statut_autre,
            'nom_responsable' => $nom_responsable,
            'tel_responsable' => $tel_responsable,
            'nom_pere' => $request->input('nom_pere'),
            'nom_mere' => $request->input('nom_mere'),
            'tel_pere' => $request->input('tel_pere'),
            'tel_mere' => $request->input('tel_mere'),
            'profession_pere' => $request->input('profession_pere'),
            'profession_mere' => $request->input('profession_mere'),
            'a_transport' => (int)$request->input('a_transport'),
            'id_classe' => $idClasse,
            'discount' => $request->input('discount') ?? 0,
            'transport_discount' => $request->input('transport_discount') ?? 0
        ]);

        return redirect()->route('eleves.index');
    }
}