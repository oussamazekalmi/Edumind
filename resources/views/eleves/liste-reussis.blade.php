@extends('layout.master')

@section('title')
    Passation Élèves
@endsection

<style>
    /* Personnalisation de la scrollbar */
    .table-responsive {
        overflow-x: auto;
        scrollbar-width: thin; /* Firefox */
        scrollbar-color: #f8f9fa transparent;
    }

    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: transparent;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: #bbb;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background-color: #999;
    }

    /* Optimized td styles */
    .table {
        font-size: small;
    }

    .table th {
        white-space: nowrap;
    }

    .table td {
        white-space: nowrap;
        padding: 16px 16px !important;
    }

    #searchInput:focus {
        background-color: #fff !important;
    }
</style>

<style>
    .nav-btns {
        position: relative;
        background-color: #f8f9fa !important;
        font-weight: 400 !important;
        font-size: 14px !important;
        border: none;
        padding: 12px 20px !important;
        border-radius: 10px;
        color: #333 !important;
        transition: all 1s ease;
    }

    .nav-btns:focus {
        outline: none;
    }

    .nav-btns:hover {
        box-shadow: none;
        border: 1px solid #333;
        background-color: white !important;
        color: #F9B948 !important;
    }

    h5 {
        font-weight: 500 !important;
        font-size: 13px !important;
        color: #F9B948 !important;
        padding-left: 4px;
    }

    .radio-input-s1:checked {
        background-color: #F9B948 !important;
        box-shadow: 0 0 0 3px rgba(249, 185, 72, 0.5) !important;
    }
</style>

<style>
    .custom-dropdown {
        position: relative;
        width: 100%;
        font-weight: 500;
    }

    .custom-dropdown-selected {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background-color: white;
        cursor: pointer;
        width: 100%;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .custom-dropdown-options {
        display: none;
        position: absolute;
        top: 105%;
        left: 0;
        width: 100%;
        background-color: white;
        border: 1px solid #e9ecef;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        z-index: 100;
        max-height: 200px;
        overflow-y: auto;
    }

    .custom-dropdown.open .custom-dropdown-options {
        display: block;
    }

    .custom-dropdown-option {
        padding: 10px 16px;
        cursor: pointer;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .custom-dropdown-option:hover {
        background-color: #f1f1f1;
    }

    .custom-dropdown i {
        margin-left: 8px;
        font-size: 14px;
    }
</style>

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <span style="padding: 14px 20px; background-color:#f8f9fa; color:gray;">
                                <span>
                                    <span class="ms-2">année scolaire &nbsp; &nbsp; &nbsp; <span style="color: #F9B948;">{{$currentAcademicYear}}</span></span>
                                </span>
                            </span>
                        </ol>
                    </div>
                </div>
                <div>
                    <div class="card shadow-sm px-3 py-5 rounded-0 position-relative">
                        <div class="normal-table">
                            <form method="GET" action="{{ route('liste.reussis') }}" class="row align-items-center">
                                <div class="col-md-7 d-flex align-items-center gap-3">
                                    <div class="position-relative flex-grow-1">
                                        <input type="text" name="search" class="form-control border-0 shadow-sm ps-5"
                                            placeholder="Rechercher par le nom d'élève"
                                            value="{{ request('search') }}"
                                            style="height: 44px; width: 98%; border-radius: 20px; background-color: #f8f9fa;
                                                    transition: background 0.3s, box-shadow 0.3s;"
                                            autocomplete="off"
                                            id="searchInput"
                                            onfocus="showTooltip()"
                                            onblur="hideTooltip()"
                                        />
                                        <div id="tooltip" style="display:none; position:absolute; top: 50px; left: 38px; padding: 10px; border-radius: 5px; font-size: 13px; color:#F9B948;">
                                            Entrez d'abord le prénom, puis le nom.
                                        </div>
                                        <i  class="fas fa-search position-absolute text-muted"
                                            style="left: 20px; top: 50%; transform: translateY(-50%);"></i>
                                    </div>

                                    <input type="hidden" name="step" id="active-step" value="{{ request('step', 0) }}">

                                    <button type="submit" class="shadow-sm round-degree a-color "
                                            style="background-color:#f8f9fa; outline: none; border:none; padding:16px 24px;">
                                        <i class="fas fa-search"></i>
                                    </button>

                                    <a href="{{ route('liste.reussis') }}" class="shadow-sm round-degree a-color "
                                    style="background-color:#f8f9fa; border:none; outline: none; padding:16px 24px;">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-navigation d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn shadow-sm border-0 nav-btns nav-btn" data-step="0" style="display: none;">
                                            réussis
                                        </button>
                                        <button type="button" class="btn shadow-sm border-0 nav-btns nav-btn" data-step="1" style="display: none;">
                                            redoublants
                                        </button>
                                        <button type="button" class="btn shadow-sm border-0 nav-btns nav-btn" data-step="2" style="display: none;">
                                            lauréats
                                        </button>
                                        <button type="button" class="btn shadow-sm border-0 nav-btns nav-btn" data-step="3" style="display: none;">
                                            quittés
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <form method="GET" action="{{ route('liste.reussis') }}" style="font-size: 13px;" class="d-flex gap-3 align-items-center mt-4 ms-1">
                            <div class="custom-dropdown" style="max-width: 210px;">
                                <div class="custom-dropdown-selected round-degree a-color">
                                    <span class="selected-text">
                                        {{ $niveaux->pluck('cycle')->unique('id')->firstWhere('id', request('cycle_id'))?->nom ?? 'Cycle' }}
                                    </span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="custom-dropdown-options">
                                    <div class="custom-dropdown-option" data-value="">Tous</div>
                                    @foreach($niveaux->pluck('cycle')->unique('id') as $cycle)
                                        <div class="custom-dropdown-option" data-value="{{ $cycle->id }}">
                                            {{ $cycle->nom }}
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="cycle_id" value="{{ request('cycle_id') }}">
                            </div>

                            <div class="custom-dropdown" style="max-width: 225px;">
                                <div class="custom-dropdown-selected round-degree a-color">
                                    <span class="selected-text">
                                        {{ $niveaux->firstWhere('id', request('niveau_id'))?->nom ?? 'Niveau' }}
                                    </span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="custom-dropdown-options">
                                    <div class="custom-dropdown-option" data-value="">Tous</div>
                                    @foreach($niveaux as $niveau)
                                        <div class="custom-dropdown-option" data-value="{{ $niveau->id }}">
                                            {{ $niveau->nom }}
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="niveau_id" value="{{ request('niveau_id') }}">
                            </div>

                            <div class="custom-dropdown" style="max-width: 200px;">
                                <div class="custom-dropdown-selected round-degree a-color>
                                    <span class="selected-text">
                                        {{ $classes->flatten()->firstWhere('id', request('classe_id'))?->nom ?? 'Groupe' }}
                                    </span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="custom-dropdown-options">
                                    <div class="custom-dropdown-option" data-value="">Tous</div>
                                    @foreach($classes->flatten() as $classe)
                                        <div class="custom-dropdown-option" data-value="{{ $classe->id }}">
                                            {{ $classe->nom }}
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="classe_id" value="{{ request('classe_id') }}">
                            </div>

                            <input type="hidden" name="step" id="active-step" value="{{ request('step', 0) }}">

                            <button type="submit" class="round-degree a-color shadow-sm ms-4 mt-2"
                                style="color: gray; background-color:transparent; outline: none; border:none; padding:18px 24px;">
                                <i class="fas fa-search"></i>
                            </button>

                            <a href="{{ route('liste.reussis') }}" class="round-degree a-color shadow-sm ms-2 mt-2"
                            style="color: gray; background-color:transparent; border:none; outline: none; padding:18px 24px;">
                                <i class="fas fa-times"></i>
                            </a>
                        </form>

                        <form method="POST" action="{{ route('update.statut.batch') }}">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="submit_type" id="submit_type" value="">

                            <div class="table-responsive mt-4" id="special-period-table">
                                <table class="table table-borderless text-start">
                                    <thead class="table-white">
                                        <tr>
                                            <th>Numéro Inscription</th>
                                            <th>Nom Complet</th>
                                            <th>Cycle</th>
                                            <th>Niveau</th>
                                            <th>Groupe</th>
                                            <th>Passation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($eleves as $eleve)
                                            <tr style="background-color: #f8f9fa;">
                                                <td>{{ $eleve->num_inscription }}</td>
                                                <td>{{ $eleve->prenom.' '.$eleve->nom }}</td>
                                                <td>{{ $eleve->classe->niveau->cycle->nom }}</td>
                                                <td>{{ $eleve->classe->niveau->nom }}</td>
                                                @php
                                                    $studentId = $eleve->id;
                                                    $currentClasse = $eleve->classe;
                                                    $currentNiveau = $currentClasse->niveau ?? null;
                                                    $currentNiveauId = $currentNiveau->id ?? null;

                                                    $nextNiveau = $niveaux->firstWhere('id', '>', $currentNiveauId);
                                                    $nextNiveauId = $nextNiveau->id ?? null;
                                                @endphp

                                                <td style="min-width: 160px; padding: 0px !important; background-color: white;"
                                                    data-student-id="{{ $studentId }}"
                                                    data-current-niveau="{{ $currentNiveauId }}"
                                                    data-next-niveau="{{ $nextNiveauId }}">

                                                    <div class="custom-dropdown" id="dropdown_{{ $studentId }}">
                                                        <div class="custom-dropdown-selected mx-3">
                                                            <span class="selected-text">
                                                                {{ $currentClasse->nom ?? 'Choisir une classe' }}
                                                            </span>
                                                            <i class="fas fa-chevron-down"></i>
                                                        </div>
                                                        <div class="custom-dropdown-options mx-3 mt-1">
                                                            @foreach (($classes[$currentNiveauId] ?? []) as $classe)
                                                                <div class="custom-dropdown-option"
                                                                    data-value="{{ $classe->id }}">
                                                                    {{ $classe->nom }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <input type="hidden" name="classes[{{ $studentId }}]" id="selected_class_{{ $studentId }}" value="{{ $currentClasse->id ?? '' }}">
                                                    </div>
                                                </td>

                                                <td style="padding:0 !important; background-color: white;">
                                                    @php
                                                        $currentYear = now()->year;
                                                        $currentAcademicYear = now()->month >= 9
                                                            ? $currentYear . ' - ' . ($currentYear + 1)
                                                            : ($currentYear - 1) . ' - ' . $currentYear;
                                                    @endphp

                                                    @if($eleve->annee_academique !== $currentAcademicYear)
                                                        <div class="d-flex mb-0" style="padding: 16px 26px 0px; background-color: white;">
                                                            <div class="form-check me-3">
                                                                <input class="form-check-input radio-input-s1" type="radio" name="passation[{{ $eleve->id }}]" value="1" id="reussit-{{ $eleve->id }}" style="border: 1px solid #F9B948;" checked />
                                                                <label class="form-check-label" for="reussit-{{ $eleve->id }}">réussit</label>
                                                            </div>

                                                            <div class="form-check me-3">
                                                                <input class="form-check-input radio-input-s1" type="radio" name="passation[{{ $eleve->id }}]" value="0" id="redoublant-{{ $eleve->id }}" style="border: 1px solid #F9B948;" />
                                                                <label class="form-check-label" for="redoublant-{{ $eleve->id }}">redoublant</label>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span style="padding: 16px; background-color: white; color:#333;">
                                                            @if ($eleve->isreussit)
                                                                <span class="shadow-sm mt-1" style="padding: 14px 14px; color: gray; font-weight: 500; line-height: 20px; display: inline-block; width: 200px;">
                                                                    réussit
                                                                    <a href="{{ route('eleves.show', $eleve->id) }}" class="text-black" style="float: right;">
                                                                        <i class="fas fa-edit py-1"></i>
                                                                    </a>
                                                                </span>
                                                            @else
                                                                <span class="shadow-sm mt-1" style="padding: 14px 14px; color: gray; font-weight: 500; line-height: 20px; display: inline-block; width: 200px;">
                                                                    redoublant
                                                                    <a href="{{ route('eleves.show', $eleve->id) }}" class="text-black" style="float: right;">
                                                                        <i class="fas fa-edit py-1"></i>
                                                                    </a>
                                                                </span>
                                                            @endif
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr style="height: 12px;"></tr>
                                        @empty
                                            <tr><td colspan="6" class="text-center">Aucun élève trouvé.</td></tr>
                                        @endforelse
                                        <tr style="height: 75px;"></tr>
                                    </tbody>
                                </table>
                                <div style="position: absolute; top: 2%; right: 1%;" class="d-flex pb-3">
                                    <button type="submit" class="btn border-0 nav-btns rounded-0 show-confirm-modal" onclick="setSubmitType('classe')">
                                        Groupes
                                    </button>

                                    @if($eleves[0]->annee_academique !== $currentAcademicYear)
                                        <button type="submit" class="btn border-0 nav-btns rounded-0 ms-2 show-confirm-modal" onclick="setSubmitType('passation')">
                                            Passation
                                        </button>
                                    @endif
                                </div>

                                <div style="position: absolute; bottom: 0%; right: 0%;" class="d-flex pt-2">
                                    <button type="submit" class="btn border-0 nav-btns rounded-0 px-4 me-4 show-confirm-modal" onclick="setSubmitType('classe')">
                                        Groupes
                                    </button>

                                    @if($eleves[0]->annee_academique !== $currentAcademicYear)
                                        <button type="submit" class="btn border-0 nav-btns rounded-0 px-4 py-2 show-confirm-modal" onclick="setSubmitType('passation')">
                                            Passation
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>

                        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="border-radius: 0;">
                                    <div class="modal-header">
                                        <h6 style="color: #0A0A23; font-size: 16px;" class="modal-title" id="confirmModalLabel">Confirmation</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir confirmer les résultats sélectionnés ? Cette action est irréversible.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn me-5 rounded-1 py-2" style="background-color: #dcdcdc; color: #0A0A23;" data-bs-dismiss="modal">Annuler</button>
                                        <button type="button" class="btn rounded-1 py-2" id="confirmSubmitBtn" style="background-color: #0A0A23; color: white;">
                                            Confirmer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive normal-table">
                            <!-- Step 1: Eleves Réussis -->
                            <div class="form-section">
                                <h5 class="ms-2">Élèves Réussis</h5>
                                <table class="table table-borderless text-start">
                                    <thead class="table-white">
                                        <tr>
                                            <th>Numéro Inscription</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            @if($eleve->classe->niveau->cycle)
                                                <th>Cycle</th>
                                            @endif
                                            @if($eleve->classe->niveau)
                                                <th>Niveau</th>
                                            @endif
                                            @if($eleve->classe)
                                                <th>Groupe</th>
                                            @endif
                                            <th>Année académique</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($eleves_reussis as $eleve)
                                            <tr style="background-color: #f8f9fa;">
                                                <td>{{ $eleve->num_inscription }}</td>
                                                <td>{{ $eleve->nom }}</td>
                                                <td>{{ $eleve->prenom }}</td>
                                               @if($eleve->classe->niveau->cycle)
                                                    <td>{{ $eleve->classe->niveau->cycle->nom }}</td>
                                                @endif
                                                @if($eleve->classe->niveau)
                                                    <td>{{ $eleve->classe->niveau->nom }}</td>
                                                @endif
                                                @if($eleve->classe)
                                                    <td>{{ $eleve->classe->nom }}</td>
                                                @endif
                                                <td>{{ $eleve->annee_academique }}</td>
                                            </tr>
                                            <tr style="height: 12px;"></tr>
                                        @empty
                                            <tr><td colspan="7" class="text-center">Aucun élève trouvé.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Step 2: Eleves Redoublants -->
                            <div class="form-section" style="display: none;">
                                <h5 class="ms-2">Élèves Redoublants</h5>
                                <table class="table table-borderless text-start">
                                    <thead class="table-white">
                                        <tr>
                                            <th>Numéro Inscription</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            @if($eleve->classe->niveau->cycle)
                                                <th>Cycle</th>
                                            @endif
                                            @if($eleve->classe->niveau)
                                                <th>Niveau</th>
                                            @endif
                                            @if($eleve->classe)
                                                <th>Groupe</th>
                                            @endif
                                            <th>Année académique</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($eleves_redoublants as $eleve)
                                            <tr style="background-color: #f8f9fa;">
                                                <td>{{ $eleve->num_inscription }}</td>
                                                <td>{{ $eleve->nom }}</td>
                                                <td>{{ $eleve->prenom }}</td>
                                                @if($eleve->classe->niveau->cycle)
                                                    <td>{{ $eleve->classe->niveau->cycle->nom }}</td>
                                                @endif
                                                @if($eleve->classe->niveau)
                                                    <td>{{ $eleve->classe->niveau->nom }}</td>
                                                @endif
                                                @if($eleve->classe)
                                                    <td>{{ $eleve->classe->nom }}</td>
                                                @endif
                                                <td>{{ $eleve->annee_academique }}</td>
                                            </tr>
                                            <tr style="height: 12px;"></tr>
                                        @empty
                                            <tr><td colspan="7" class="text-center">Aucun élève trouvé.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Step 3: Eleves Lauréats -->
                            <div class="form-section" style="display: none;">
                                <h5 class="ms-2">Lauréats</h5>
                                <table class="table table-borderless text-start">
                                    <thead class="table-white">
                                        <tr>
                                            <th>Numéro Inscription</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            @if($eleves_laureats->contains(function($eleve) { return $eleve->classe; }))
                                                <th>Groupe</th>
                                            @endif
                                            <th>Année d'obtention du bac</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($eleves_laureats as $eleve)
                                            <tr style="background-color: #f8f9fa;">
                                                <td>{{ $eleve->num_inscription }}</td>
                                                <td>{{ $eleve->nom }}</td>
                                                <td>{{ $eleve->prenom }}</td>
                                                @if($eleve->classe)
                                                    <td>{{ $eleve->classe->nom }}</td>
                                                @endif
                                                <td>
                                                    Session Juin <span style="color:#F9B948;">/</span> Juillet
                                                    <span style="color:#F9B948;">{{ $eleve->annee_obtention_bac ?? '-' }}</span>
                                                </td>
                                            </tr>
                                            <tr style="height: 12px;"></tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center">Aucun élève trouvé.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Step 4: Eleves Quittés -->
                            <div class="form-section" style="display: none;">
                                <h5 class="ms-2">Élèves Quittés</h5>
                                <table class="table table-borderless text-start">
                                    <thead class="table-white">
                                        <tr>
                                            <th>Numéro Inscription</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>

                                            @php
                                                $showClasse = $eleves_quittes->contains(function($eleve) {
                                                    return optional($eleve->classe)->nom;
                                                });
                                            @endphp

                                            @if($showClasse)
                                                <th>Groupe</th>
                                            @endif

                                            <th>Année d'abandon</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($eleves_quittes as $eleve)
                                            <tr style="background-color: #f8f9fa;">
                                                <td>{{ $eleve->num_inscription }}</td>
                                                <td>{{ $eleve->nom }}</td>
                                                <td>{{ $eleve->prenom }}</td>

                                                @if($showClasse)
                                                    <td>{{ $eleve->classe->nom ?? '-' }}</td>
                                                @endif

                                                <td>
                                                    @php
                                                        \Carbon\Carbon::setLocale('fr');
                                                        $annee_abandon = \Carbon\Carbon::parse($eleve->date_abandon);
                                                    @endphp
                                                    Le <span style="padding-bottom:2px; border-bottom:1px #F9B948 solid;">
                                                        {{ $annee_abandon->translatedFormat('d F Y') }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr style="height: 12px;"></tr>
                                        @empty
                                            <tr><td colspan="7" class="text-center">Aucun élève trouvé.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        const classesByNiveau = @json($classes);

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('tr[data-student-id]').forEach(row => {
                const studentId = row.dataset.studentId;
                const currentNiveauId = row.dataset.currentNiveau;
                const nextNiveauId = row.dataset.nextNiveau;

                const radios = document.querySelectorAll(`input[name="passation[${studentId}]"]`);
                const dropdown = document.querySelector(`#dropdown_${studentId}`);
                const optionsContainer = dropdown.querySelector('.custom-dropdown-options');
                const selectedText = dropdown.querySelector('.selected-text');
                const hiddenInput = document.querySelector(`#selected_class_${studentId}`);

                radios.forEach(radio => {
                    radio.addEventListener('change', () => {
                        const isReussit = radio.value === "1";
                        const niveauId = isReussit ? nextNiveauId : currentNiveauId;

                        const classes = classesByNiveau[niveauId] || [];

                        optionsContainer.innerHTML = '';

                        classes.forEach(classe => {
                            const option = document.createElement('div');
                            option.className = 'custom-dropdown-option';
                            option.dataset.value = classe.id;
                            option.textContent = classe.nom;

                            option.addEventListener('click', () => {
                                selectedText.textContent = classe.nom;
                                hiddenInput.value = classe.id;
                            });

                            optionsContainer.appendChild(option);
                        });

                        if (classes.length) {
                            selectedText.textContent = classes[0].nom;
                            hiddenInput.value = classes[0].id;
                        } else {
                            selectedText.textContent = 'Aucune classe';
                            hiddenInput.value = '';
                        }
                    });
                });
            });
        });
    </script>

    <script>

        function setSubmitType(type) {
            document.getElementById('submit_type').value = type;
        }

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".custom-dropdown").forEach(function (dropdown) {
                const selected = dropdown.querySelector(".custom-dropdown-selected");
                const selectedText = selected.querySelector(".selected-text");
                const options = dropdown.querySelectorAll(".custom-dropdown-option");
                const hiddenInput = dropdown.querySelector("input[type='hidden']");

                selected.addEventListener("click", function () {
                    dropdown.classList.toggle("open");
                });

                options.forEach(function (option) {
                    option.addEventListener("click", function () {
                        selectedText.innerText = option.innerText;
                        hiddenInput.value = option.getAttribute("data-value");
                        dropdown.classList.remove("open");
                    });
                });

                document.addEventListener("click", function (e) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove("open");
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            const form = document.querySelector('form[action="{{ route('update.statut.batch') }}"]');
            const confirmBtn = document.getElementById('confirmSubmitBtn');
            let shouldSubmit = false;

            document.querySelectorAll('.show-confirm-modal').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    shouldSubmit = true;
                    confirmModal.show();
                });
            });

            confirmBtn.addEventListener('click', function () {
                if (shouldSubmit) {
                    form.submit();
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let currentDate = new Date();
            let startOfPeriod = new Date(currentDate.getFullYear(), 6, 1);
            let endOfPeriod = new Date(currentDate.getFullYear(), 8, 1);

            let normalTables = document.getElementsByClassName('normal-table');

            if (currentDate >= startOfPeriod && currentDate <= endOfPeriod) {
                document.getElementById('special-period-table').style.display = 'block';
                Array.from(normalTables).forEach(table => {
                    table.style.display = 'none';
                });
            } else {
                document.getElementById('special-period-table').style.display = 'none';
                Array.from(normalTables).forEach(table => {
                    table.style.display = 'block';
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sections = document.querySelectorAll(".form-section");
            const navButtons = document.querySelectorAll(".nav-btn");
            const allStepInputs = document.querySelectorAll("input[name='step']");

            const urlParams = new URLSearchParams(window.location.search);
            let currentStep = parseInt(urlParams.get('step')) || 0;

            function showStep(index) {
                currentStep = index;

                sections.forEach((section, i) => {
                    section.style.display = i === index ? "block" : "none";
                });

                navButtons.forEach(btn => {
                    const step = parseInt(btn.getAttribute('data-step'));
                    btn.style.display = step === currentStep ? "none" : "inline-block";
                });

                // Update all step inputs on the page
                allStepInputs.forEach(input => input.value = currentStep);
            }

            navButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    const targetStep = parseInt(btn.getAttribute("data-step"));
                    showStep(targetStep);
                });
            });

            showStep(currentStep);
        });
    </script>

    <script>
        function showTooltip() {
            document.getElementById('tooltip').style.display = 'block';
        }

        function hideTooltip() {
            document.getElementById('tooltip').style.display = 'none';
        }
    </script>
@endsection
