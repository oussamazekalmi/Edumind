@extends('layout.master')

@section('title')
    Détails de l'élève {{$eleve->prenom.' '.$eleve->nom}}
@endsection

<style>
    .form-control {
        background-color: white !important;
        border: none !important;
        outline: none !important;
        padding: 14px 20px !important;
    }
    .radio-input-s1:checked {
        background-color: lightblue !important;
        box-shadow: 0 0 0 3px #F0FFFF !important;
    }
    .radio-input-s2:checked {
        background-color: #F9B948 !important;
        box-shadow: 0 0 0 3px rgba(249, 185, 72, 0.5) !important;

    }

    .tooltip-icon {
        position: relative;
    }

    .tooltip-icon::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 125%; /* Position above the icon */
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        white-space: nowrap;
        font-size: 12px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease-in-out;
        z-index: 1000;
    }

    .tooltip-icon:hover::after {
        opacity: 1;
    }

    .form-control {
        background-color: #f8f9fa !important;
        color: #2e2e2e !important;
    }

    label {
        color: #6c757d;
    }

    .card-custom {
        padding: 34px 0 8px;
        border-radius: .3rem .3rem 0 0 !important;
    }
</style>

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="d-flex">
                                <li><a href="{{ route("cycle.liste") }}" style="cursor: pointer; color: #6c757d;"><span style="border-bottom: 1px solid #6c757d; padding-bottom: 2px;">{{ $eleve->classe->niveau->cycle->nom }}</span></a></li>
                                <li><a href="{{ route("niveau.liste") }}" style="cursor: pointer; margin: 0 22px; color: #6c757d;"><span style="border-bottom: 1px solid #6c757d; padding-bottom: 2px;">{{ $eleve->classe->niveau->nom }}</span></a></li>
                                <li><a href="{{ route("classes.index") }}" style="cursor: pointer; color: #6c757d;"><span style="border-bottom: 1px solid #6c757d; padding-bottom: 2px;">{{ $eleve->classe->nom }}</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="card shadow-sm p-3 rounded-0 position-relative">
                            <div class="mb-5">
                                <div class="row mt-5">
                                    @if (!empty($eleve->num_inscription))
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="num_inscription">numèro inscription</label>
                                            <input type="text" id="num_inscription" style="width: 96%;cursor:default;"
                                                class="form-control fw-normal rounded-0  mt-1"
                                                value="{{ $eleve->num_inscription }}" readonly>
                                        </div>
                                    </div>
                                    @endif

                                    @if (!empty($eleve->nom))
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nom_complet">nom complet</label>
                                            <input type="text" id="nom_complet" style="width: 96%;cursor:default;"
                                                class="form-control fw-normal rounded-0  mt-1"
                                                value="{{ $eleve->prenom.' '.$eleve->nom }}" readonly>
                                        </div>
                                    </div>
                                    @endif

                                    @if (!empty($eleve->cne))
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cne">cne</label>
                                            <input type="text" id="cne" style="width: 96%;cursor:default;"
                                                class="form-control fw-normal rounded-0  mt-1"
                                                value="{{ $eleve->cne }}" readonly>
                                        </div>
                                    </div>
                                    @endif

                                    @if (!empty($eleve->cin))
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cin">cin</label>
                                            <input type="text" id="cin" style="width: 96%;cursor:default;"
                                                class="form-control fw-normal rounded-0  mt-1"
                                                value="{{ $eleve->cin }}" readonly>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <div class="row my-1">
                                    @if (!empty($eleve->nom_pere))
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nom_pere">nom père</label>
                                            <input type="text" id="nom_pere" style="width: 96%;cursor:default;"
                                                class="form-control fw-normal rounded-0 mt-1"
                                                value="{{ $eleve->nom_pere }}" readonly>
                                        </div>
                                    </div>
                                    @endif

                                    @if (!empty($eleve->nom_mere))
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nom_mere">nom mère</label>
                                            <input type="text" id="nom_mere" style="width: 96%;cursor:default;"
                                                class="form-control fw-normal rounded-0 mt-1"
                                                value="{{ $eleve->nom_mere }}" readonly>
                                        </div>
                                    </div>
                                    @endif

                                    @if (!empty($eleve->tel_pere))
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tel_pere">téléphone père</label>
                                            <input type="text" id="tel_pere" style="width: 96%;cursor:default;"
                                                class="form-control fw-normal rounded-0 mt-1"
                                                value="{{ $eleve->tel_pere }}" readonly>
                                        </div>
                                    </div>
                                    @endif

                                    @if (!empty($eleve->tel_mere))
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tel_mere">téléphone mère</label>
                                            <input type="text" id="tel_mere" style="width: 96%;cursor:default;"
                                                class="form-control fw-normal rounded-0 mt-1"
                                                value="{{ $eleve->tel_mere }}" readonly>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                @if (($eleve->statut_responsable !== 'père' && $eleve->statut_responsable !== 'mère'))
                                    <div class="row mb-1">
                                        @if (!empty($eleve->profession_pere))
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="profession_pere">profession père</label>
                                                    <input type="text" id="profession_pere" style="width: 96%;cursor:default;"
                                                        class="form-control fw-normal rounded-0 mt-1"
                                                        value="{{ $eleve->profession_pere }}" readonly>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($eleve->profession_mere))
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="profession_mere">profession mère</label>
                                                    <input type="text" id="profession_mere" style="width: 96%;cursor:default;"
                                                        class="form-control fw-normal rounded-0 mt-1"
                                                        value="{{ $eleve->profession_mere }}" readonly>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <div class="row">
                                    @if (($eleve->statut_responsable === 'père' || $eleve->statut_responsable === 'mère'))
                                        @if (!empty($eleve->statut_responsable))
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="statut_responsable">responsable</label>
                                                    <input type="text" id="statut_responsable" style="width: 96%;cursor:default;"
                                                        class="form-control fw-normal rounded-0  mt-1"
                                                        value="{{ $eleve->statut_responsable }}" readonly>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    @if (($eleve->statut_responsable !== 'père' && $eleve->statut_responsable !== 'mère'))
                                        @if (!empty($eleve->statut_autre))
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="statut_autre">responsable</label>
                                                    <input type="text" id="statut_autre" style="width: 96%;cursor:default;"
                                                        class="form-control fw-normal rounded-0  mt-1"
                                                        value="{{ $eleve->statut_autre }}" readonly>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!empty($eleve->nom_responsable))
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="nom_res">nom {{strtolower($eleve->statut_autre)}}</label>
                                                    <input type="text" id="nom_res" style="width: 96%;cursor:default;"
                                                        class="form-control fw-normal rounded-0  mt-1"
                                                        value="{{ $eleve->nom_responsable }}" readonly>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!empty($eleve->tel_responsable))
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tel_res">téléphone {{strtolower($eleve->statut_autre)}}</label>
                                                    <input type="text" id="tel_res" style="width: 96%;cursor:default;"
                                                        class="form-control fw-normal rounded-0  mt-1"
                                                        value="{{ $eleve->tel_responsable }}" readonly>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        @if (!empty($eleve->profession_pere))
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="profession_pere">profession père</label>
                                                    <input type="text" id="profession_pere" style="width: 96%;cursor:default;"
                                                        class="form-control fw-normal rounded-0 mt-1"
                                                        value="{{ $eleve->profession_pere }}" readonly>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($eleve->profession_mere))
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="profession_mere">profession mère</label>
                                                    <input type="text" id="profession_mere" style="width: 96%;cursor:default;"
                                                        class="form-control fw-normal rounded-0 mt-1"
                                                        value="{{ $eleve->profession_mere }}" readonly>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    @if (!empty($eleve->adresse))
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="adresse">adresse élève</label>
                                                <input type="text" id="adresse" style="width: 96%;cursor:default;"
                                                    class="form-control fw-normal rounded-0  mt-1"
                                                    value="{{ $eleve->adresse }}" readonly>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <a href="{{ route('eleve.modifier', $eleve->id) }}" class="text-black tooltip-icon" data-tooltip="Modifier" style="position:absolute; top:0; right:0; padding: 15px 20px; background-color:#f8f9fa;">
                                <i class="fas fa-edit"></i>
                            </a>

                            @php
                                $nextStudent = \App\Models\Eleve::where('statut', 'en_cours')
                                    ->where('id', '>', $eleve->id)
                                    ->orderBy('id')
                                    ->first();

                                $prevStudent = \App\Models\Eleve::where('statut', 'en_cours')
                                    ->where('id', '<', $eleve->id)
                                    ->orderByDesc('id')
                                    ->first();

                                $isLast = !$nextStudent;
                            @endphp

                            @if (!$isLast)
                                @if ($prevStudent)
                                    <a href="{{ route('eleves.show', $prevStudent->id) }}" class="text-black tooltip-icon" data-tooltip="Précédent"
                                    style="position:absolute; bottom:0; right:18.5%; padding: 15px 20px; background-color:#f8f9fa;">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                @endif

                                @if ($nextStudent)
                                    <a href="{{ route('eleves.show', $nextStudent->id) }}" class="text-black tooltip-icon" data-tooltip="Suivant"
                                    style="position:absolute; bottom:0; right:0; padding: 15px 20px; background-color:#f8f9fa;">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                @endif
                            @elseif ($prevStudent)
                                <a href="{{ route('eleves.show', $prevStudent->id) }}" class="text-black tooltip-icon" data-tooltip="Précédent"
                                style="position:absolute; bottom:0; right:0; padding: 15px 20px; background-color:#f8f9fa;">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            @endif

                            @if (!empty($eleve->statut_familial))
                                <span style="position:absolute; top:0; left:0; padding: 10px 15px; background-color: #f8f9fa !important;">
                                    @if ($eleve->statut_familial === 'divorcé')
                                        <div style="color: #F9B948">
                                            <i class="fas fa-heart-broken"></i>
                                            <span class="ms-2">
                                                Parents divorcés
                                            </span>
                                        </div>
                                    @else
                                        <div style="color: lightblue">
                                            <i class="fas fa-heart"></i>
                                            <span class="ms-2">
                                                Parents mariés
                                            </span>
                                        </div>

                                    @endif
                                </span>
                            @endif
                            @php
                                $currentYear = now()->year;
                                $currentAcademicYear = now()->month >= 9
                                    ? $currentYear . ' - ' . ($currentYear + 1)
                                    : ($currentYear - 1) . ' - ' . $currentYear;
                            @endphp
                            @if (!empty($eleve->annee_academique))
                                @if($periode_modification)
                                    <span style="position:absolute; bottom:0; left:0;" class="rounded-2">
                                        @if($eleve->annee_academique !== $currentAcademicYear)
                                            <form action="{{ route('eleves.update_statut', $eleve->id) }}" method="POST" class="d-flex mb-0">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="eleve_id" value="{{ $eleve->id }}">

                                                <div class="d-flex mb-0" style="padding: 10px 16px 0px; border: solid 2px lightblue;">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input radio-input-s1" type="radio" name="isreussit" id="reussit" value="1" style="border: 1px solid lightblue;" checked />
                                                        <label class="form-check-label" for="reussit">Réussit</label>
                                                    </div>

                                                    <div class="form-check me-3">
                                                        <input class="form-check-input radio-input-s1" type="radio" name="isreussit" id="redoublant" value="0" style="border: 1px solid lightblue;" />
                                                        <label class="form-check-label" for="redoublant">Redoublant</label>
                                                    </div>
                                                </div>

                                                <button type="submit" class="shadow-sm" style="border:0; outline:0; padding: 0 20px; background-color:lightblue; font-size: large; margin-left:-5px">
                                                    <i class="fas fa-save text-white"></i>
                                                </button>
                                            </form>
                                        @else
                                            <div class="edit-button" id="edit-button" style="position: absolute; bottom: 0; left: 0;">
                                                <button type="button" class="shadow-sm" style="padding: 12px 18px; color:#333; background-color:white; border: none; outline: none; border-bottom:solid 2px #333" onclick="toggleForm()">
                                                    <span>
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                </button>

                                                <span style="padding: 10px 30px; background-color: #f8f9fa; color:#333; border-bottom:solid 2px #333">
                                                    @if ($eleve->isreussit)
                                                        <span style="padding: 14px 14px; color:#333; font-weight:600;">
                                                            réussit
                                                        </span>
                                                    @else
                                                        <span style="padding: 14px 14px; color:#333; font-weight:600;">
                                                            redoublant
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>

                                            <form id="edit-form" action="{{ route('eleves.revert_statut', $eleve->id) }}" method="POST" class="d-flex mb-0" style="visibility: hidden;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="eleve_id" value="{{ $eleve->id }}">

                                                <div class="d-flex mb-0" style="padding: 10px 16px 0px; border: solid 2px  #F9B948;">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input radio-input-s2" type="radio" name="isreussit" id="reussit-correct" value="1" style="border: 1px solid #F9B948;" checked />
                                                        <label class="form-check-label" for="reussit-correct">Réussit</label>
                                                    </div>

                                                    <div class="form-check me-3">
                                                        <input class="form-check-input radio-input-s2" type="radio" name="isreussit" id="redoublant-correct" value="0" style="border: 1px solid #F9B948;" />
                                                        <label class="form-check-label" for="redoublant-correct">Redoublant</label>
                                                    </div>
                                                </div>

                                                <button type="submit" class="shadow-sm" style="border:0; padding: 0 20px; outline:0; background-color: #F9B948; font-size: medium; margin-left:-5px">
                                                    <i class="fas fa-edit text-white"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </span>
                                @else
                                    <!-- Display Current Status (Passed or Failed) -->
                                    <div style="position:absolute; bottom:0; left:0; background-color: #f8f9fa;">
                                        @if ($eleve->isreussit)
                                            <i class="fas fa-medal" style="padding: 16px 18px; color: lightblue; border-right: 3px solid white;"></i>
                                            <span style="padding: 13px 14px; color:lightblue; font-weight:500; margin-left: -4px; border:1px solid #f8f9fa;">
                                                L'élève a réussi son année
                                            </span>
                                        @else
                                            <i class="fas fa-exclamation-circle" style="padding: 16px 18px; color: #6c757d; border-right: 3px solid white;""></i>
                                            <span style="padding: 13px 14px; color: #6c757d; font-weight:500; margin-left: -4px; border:1px solid #f8f9fa;">
                                                L'élève est redoublant
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- Historique des paiements -->
                        <div class="card shadow-sm rounded-0 p-3 mt-5 position-relative">
                            <div class="d-flex justify-content-between">
                                <h4 class="f-w-500" style="font-size: 15px; color: lightgray; border-bottom: 2px solid lightgray; padding-bottom: 1px;">Historique des paiements</h4>
                                <h4 class="f-w-500" style="font-size: 14px; color: lightgray; ">
                                    {{ now()->month >= 9 ? now()->year . ' - ' . (now()->year + 1) : (now()->year - 1) . ' - ' . now()->year }}
                                </h4>
                            </div>

                            <!-- Inscription -->
                            <div class="mt-4">
                                <h4 class="f-w-500 my-3 text-secondary" style="font-size: 15px;">Inscription</h4>
                                <div class="row ms-4">
                                    @php
                                        $frenchMonths = [
                                            'January' => 'janvier',
                                            'February' => 'février',
                                            'March' => 'mars',
                                            'April' => 'avril',
                                            'May' => 'mai',
                                            'June' => 'juin',
                                            'July' => 'juillet',
                                            'August' => 'août',
                                            'September' => 'septembre',
                                            'October' => 'octobre',
                                            'November' => 'novembre',
                                            'December' => 'décembre',
                                        ];
                                    @endphp
                                    <!-- If fully paid -->
                                    @if($etatInscription === 'payé')
                                        <div style="width:17%; cursor:default;">
                                            <div class="card shadow-sm text-center position-relative card-custom">
                                                {{ number_format($montant_inscription, 2, '.', '') }} DH
                                                <span class="badge ps-2 pe-3 badge-hover rounded-0 f-w-600"
                                                    style="width:100%; position:absolute; top:0; right:0; padding:7px; border-radius: .3rem .3rem 0 0 !important; background-color: lightblue; color: white; font-size:13px;"
                                                    data-label="Payé"
                                                    data-date="{{ $paiementInscription?->date_paiement?->format('d') . ' ' . ($frenchMonths[$paiementInscription?->date_paiement?->format('F')] ?? '') }}">
                                                    Payé
                                                </span>
                                            </div>
                                        </div>
                                    <!-- If not paid yet -->
                                    @elseif($etatInscription === 'non payé')
                                        <div style="width:19.5%; cursor:default;">
                                            <div class="card shadow-sm text-center position-relative card-custom">
                                                {{ number_format($montant_inscription, 2, '.', '') }} DH
                                                <span class="badge text-white ps-2 pe-3 rounded-0 f-w-600" style="width:100%; position:absolute; top:0; right:0; padding:7px; border-radius: .3rem .3rem 0 0 !important; background-color: tomato; font-size:13px;">
                                                    Non payé
                                                </span>
                                            </div>
                                        </div>
                                    <!-- If partially paid -->
                                    @elseif($etatInscription === 'partiel')
                                        <div class="d-flex flex-wrap">
                                            @php $trancheNumber = 1; @endphp
                                            @foreach($fraisInscPartiels as $frais)
                                                @php
                                                    $day = $frais->date_paiement?->format('d');
                                                    $month = $frais->date_paiement?->format('F');
                                                    $dateFormatted = $day . ' ' . ($frenchMonths[$month] ?? '');
                                                @endphp
                                                <div style="width:17%; cursor:default;" class="me-4">
                                                    <div class="card shadow-sm text-center position-relative card-custom">
                                                        {{ number_format($frais->montant, 2, '.', '') }} DH
                                                        <span class="badge badge-hover ps-2 pe-3 rounded-0 f-w-600" style="width:100%; position:absolute; top:0; right:0; padding:7px; border-radius: .3rem .3rem 0 0 !important; background-color: #F9B948; color: white; font-size:13px;"
                                                            data-label="tranche {{ $trancheNumber }}"
                                                            data-date="{{ $dateFormatted }}">
                                                            tranche {{ $trancheNumber }}
                                                        </span>
                                                    </div>
                                                </div>
                                                @php $trancheNumber++; @endphp
                                            @endforeach
                                        </div>

                                        <!-- Display Remaining Amount -->
                                        @php
                                            $totalPaid = $fraisInscPartiels->sum('montant');
                                            $remainingAmount = $montant_inscription - $totalPaid;
                                        @endphp

                                        <div style="margin-top:-20px; color: #F9B948;">
                                            <h6 class="fw-semibold pt-2">Restant à payer : {{ $remainingAmount }} DH</h6>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="my-4">
                                <h4 class="f-w-500 my-3 text-secondary" style="font-size: 15px;">Scolarité</h4>
                                <div class="row ms-5">
                                    @if($etatScolarite === 'partiel')
                                        <div class="d-flex flex-wrap">
                                            @foreach($fraisScocPartiels as $frais)
                                                @php
                                                    $day = $frais->date_paiement?->format('d');
                                                    $month = $frais->date_paiement?->format('F');
                                                    $dateFormatted = $day . ' ' . ($frenchMonths[$month] ?? '');
                                                @endphp
                                                <div style="width:18%; cursor:default;" class="me-4">
                                                    <div class="card shadow-sm text-center position-relative card-custom">
                                                        {{ number_format($frais->montant, 2, '.', '') }} DH
                                                        <span class="badge badge-hover ps-2 pe-3 rounded-0 f-w-600" style="width:100%; position:absolute; top:0; right:0; padding:7px; border-radius: .3rem .3rem 0 0 !important; background-color: #F9B948; color: white; font-size:13px;"
                                                            data-label="{{$frais->periode}}"
                                                            data-date="{{ $dateFormatted }}">
                                                            {{$frais->periode}}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @php
                                            $totalPaid = $fraisScocPartiels->sum('montant');
                                            $remainingAmount = $total_scolarite - $totalPaid;
                                        @endphp

                                        <div style="margin-top:-20px; color: #F9B948;">
                                            <h6 class="fw-semibold pt-2">Restant à payer : {{ $remainingAmount }} DH</h6>
                                        </div>

                                    @elseif($etatScolarite === 'non payé')
                                        <div style="width:19.5%; cursor:default;">
                                            <div class="card shadow-sm text-center position-relative card-custom">
                                                {{ number_format($total_scolarite, 2, '.', '') }} DH
                                                <span class="badge text-white ps-2 pe-3 rounded-0 f-w-600" style="width:100%; position:absolute; top:0; right:0; padding:7px; border-radius: .3rem .3rem 0 0 !important; background-color: tomato; font-size:13px;">
                                                    Non payé
                                                </span>
                                            </div>
                                        </div>

                                    @elseif($etatScolarite === 'payé')
                                        <div class="d-flex flex-wrap">
                                            @foreach($fraisScocPayed as $frais)
                                                @php
                                                    $day = $frais->date_paiement?->format('d');
                                                    $month = $frais->date_paiement?->format('F');
                                                    $dateFormatted = $day . ' ' . ($frenchMonths[$month] ?? '');
                                                @endphp
                                                <div style="width:18%; cursor:default;" class="me-4">
                                                    <div class="card shadow-sm text-center position-relative card-custom">
                                                        {{ number_format($frais->montant, 2, '.', '') }} DH
                                                        <span class="badge badge-hover ps-2 pe-3 rounded-0 f-w-600" style="width:100%; position:absolute; top:0; right:0; padding:7px; border-radius: .3rem .3rem 0 0 !important; background-color: lightblue; color: white; font-size:13px;"
                                                            data-label="{{$frais->periode}}"
                                                            data-date="{{ $dateFormatted }}">
                                                            {{$frais->periode}}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if ($eleve->a_transport)
                                <div class="mb-5">
                                    <h4 class="f-w-500 my-3 text-secondary" style="font-size: 15px;">Transport</h4>
                                    <div class="row ms-5">
                                        @if($etatTransport === 'partiel')
                                            <div class="d-flex flex-wrap">
                                                @foreach($fraisTransPartiels as $frais)
                                                    @php
                                                        $day = $frais->date_paiement?->format('d');
                                                        $month = $frais->date_paiement?->format('F');
                                                        $dateFormatted = $day . ' ' . ($frenchMonths[$month] ?? '');
                                                    @endphp
                                                    <div style="width:18%; cursor:default;" class="me-4">
                                                        <div class="card shadow-sm text-center position-relative card-custom">
                                                            {{ number_format($frais->montant, 2, '.', '') }} DH
                                                            <span class="badge badge-hover ps-2 pe-3 rounded-0 f-w-600" style="width:100%; position:absolute; top:0; right:0; padding:7px; border-radius: .3rem .3rem 0 0 !important; background-color: #F9B948; color: white; font-size:13px;"
                                                                data-label="{{$frais->periode}}"
                                                                data-date="{{ $dateFormatted }}">
                                                                {{$frais->periode}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @php
                                                $totalPaid = $fraisTransPartiels->sum('montant');
                                                $remainingAmount = $total_transport - $totalPaid;
                                            @endphp

                                            <div style="margin-top:-20px; color: #F9B948;">
                                                <h6 class="fw-semibold pt-2">Restant à payer : {{ $remainingAmount }} DH</h6>
                                            </div>

                                        @elseif($etatTransport === 'non payé')
                                            <div style="width:19.5%; cursor:default;">
                                                <div class="card shadow-sm text-center position-relative card-custom">
                                                    {{ number_format($total_transport, 2, '.', '') }} DH
                                                    <span class="badge text-white ps-2 pe-3 rounded-0 f-w-600" style="width:100%; position:absolute; top:0; right:0; padding:7px; border-radius: .3rem .3rem 0 0 !important; background-color: tomato; font-size:13px;">
                                                        Non payé
                                                    </span>
                                                </div>
                                            </div>

                                        @elseif($etatTransport === 'payé')
                                            <div class="d-flex flex-wrap">
                                                @foreach($fraisTransPayed as $frais)
                                                    @php
                                                        $day = $frais->date_paiement?->format('d');
                                                        $month = $frais->date_paiement?->format('F');
                                                        $dateFormatted = $day . ' ' . ($frenchMonths[$month] ?? '');
                                                    @endphp
                                                    <div style="width:18%; cursor:default;" class="me-4">
                                                        <div class="card shadow-sm text-center position-relative card-custom">
                                                            {{ number_format($frais->montant, 2, '.', '') }} DH
                                                            <span class="badge badge-hover ps-2 pe-3 rounded-0 f-w-600" style="width:100%; position:absolute; top:0; right:0; padding:7px; border-radius: .3rem .3rem 0 0 !important; background-color: lightblue; color: white; font-size:13px;"
                                                                data-label="{{$frais->periode}}"
                                                                data-date="{{ $dateFormatted }}">
                                                                {{$frais->periode}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <a href="{{ route('paiements.traiter', $eleve->id) }}" class="text-black tooltip-icon" data-tooltip="Traiter paiement" style="position:absolute; bottom:0; left:0; padding: 15px 20px; background-color:#f8f9fa;">
                                <i class="fas fa-credit-card"></i>
                            </a>
                            <a href="{{ route('paiements.liste', $eleve->id) }}" class="text-black tooltip-icon" data-tooltip="Liste des paiements" style="position:absolute; bottom:0; right:0; padding: 15px 20px; background-color:#f8f9fa;">
                                <i class="fas fa-list"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleForm() {
            var editButton = document.getElementById('edit-button');
            var editForm = document.getElementById('edit-form');

            if (editForm.style.visibility === "hidden") {
                editForm.style.visibility = "visible";
                editButton.style.visibility = "hidden";
            } else {
                editForm.style.visibility = "hidden";
                editButton.style.visibility = "visible";
            }
        }

        document.getElementById('edit-form').addEventListener('submit', function() {
            var editButton = document.getElementById('edit-button');
            var editForm = document.getElementById('edit-form');

            editForm.style.visibility = "hidden";
            editButton.style.visibility = "visible";
        });
    </script>

    <script>
        document.querySelectorAll('.badge-hover').forEach(badge => {
            const originalText = badge.getAttribute('data-label');
            const paymentDate = badge.getAttribute('data-date');

            badge.closest('.card').addEventListener('mouseenter', () => {
                if (paymentDate) badge.textContent = 'Le ' + paymentDate;
            });

            badge.closest('.card').addEventListener('mouseleave', () => {
                badge.textContent = originalText;
            });
        });
    </script>
@endsection
