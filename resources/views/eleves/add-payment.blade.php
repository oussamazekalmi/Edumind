@extends('layout.master')

@section('title')
    Traiter paiement
@endsection

<style>
    .form-control, .form-label {
        font-weight:500 !important;
    }
    .custom {
        background-color: #f8f9fa !important;
        color: #575758 !important;
    }
    .custom:focus {
        color: #02021d !important;
        border-color: transparent !important;
        box-shadow: none !important;
        outline: none !important;
        transition: all 1s ease !important;
    }

    /* Custom Dropdown */
    .custom-dropdown {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .custom-dropdown-selected {
        background-color: #f8f9fa;
        margin-top: 8px;
        padding: 14px;
        cursor: pointer;
        font-weight: 500;
    }

    .custom-dropdown-selected:hover {
        background-color: #f5f6f7;
        transition: background-color .5s linear;
    }

    .custom-dropdown-options {
        display: none;
        position: absolute;
        top: 100%;
        left: 0.5%;
        width: 99%;
        background-color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 100;
        max-height: 150px;
        overflow-y: auto;
    }

    .custom-dropdown.open .custom-dropdown-options {
        display: block;
    }

    .custom-dropdown-option {
        padding: 8px 20px;
        cursor: pointer;
    }

    .custom-dropdown-option:hover {
        background-color: #f8f9fa;
    }

    /* Disabled option style */
    .custom-dropdown-option.disabled {
        pointer-events: none;
        color: #D7CAC9 !important;
        font-weight:bold;
    }

    .form-section {
        display: none;
    }

    .footer {
        display:none;
        visibility:hidden;
    }
</style>

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="container">
                    <div class="card mb-0 border-0 rounded-1 shadow-sm bg-white position-relative">
                        <div class="ps-2">
                            <h5 class="m-3" style="font-weight:500 !important;">Paiement pour {{ $eleve->nom }} {{ $eleve->prenom }}</h5>
                            <a href="{{ route('eleves.show', $eleve->id) }}" class="tooltip-icon" data-tooltip="Détails d'élève" style="position:absolute; top:0; right:0; padding: 16px 22px; background-color:#f8f9fa; color:#020227;">
                                <i class="fas fa-user"></i>
                            </a>
                        </div>
                        <div class="row my-3">
                            <div>
                                <div class="progressbar justify-content-evenly">
                                    <div class="progress" id="progress"></div>
                                    <div class="progress-step progress-step-active p-4 step1 f-w-600"></div>
                                    <div class="progress-step p-4 step2 f-w-600" style="background-color:#F1F1FC; color:#02021d"></div>
                                </div>
                                <form action="{{ route('paiements.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id_eleve" value="{{ $eleve->id }}">

                                    <!-- Step 0 -->
                                    <div class="form-section">
                                        <div class="row ms-3" style="width:96%;">
                                            <div class="col-md-6 position-relative">
                                                <label for="type" class="form-label m-1">Type Frais</label>
                                                <div class="custom-dropdown" id="customDropdown">
                                                    <div class="custom-dropdown-selected d-flex justify-content-between" id="customDropdownSelected">
                                                        <span>Choisir un type</span> <!-- Default Text -->
                                                        <i class="fas fa-chevron-down mt-1"></i> <!-- Dropdown icon -->
                                                    </div>
                                                    <div class="custom-dropdown-options" id="customDropdownOptions">
                                                        @php
                                                            $inscriptionDisabled = $restant_inscription <= 0;

                                                            $scolariteDisabled =  $restant_scolarite <= 0;

                                                            $transportDisabled = $restant_transport <= 0;
                                                        @endphp

                                                        {{-- INSCRIPTION --}}
                                                        @if($inscriptionDisabled)
                                                            <div class="custom-dropdown-option disabled d-flex justify-content-between" data-value="inscription" id="inscriptionOption" style="color: #B8B6B3 !important;">
                                                                Inscription
                                                                <span><i class="fas fa-check-circle"></i></span>
                                                            </div>
                                                        @else
                                                            <div class="custom-dropdown-option" data-value="inscription" id="inscriptionOption">
                                                                Inscription
                                                            </div>
                                                        @endif

                                                        {{-- SCOLARITÉ --}}
                                                        @if($scolariteDisabled)
                                                            <div class="custom-dropdown-option disabled d-flex justify-content-between" data-value="scolaire" id="scolariteOption">
                                                                Scolarité
                                                                <span><i class="fas fa-check-circle"></i></span>
                                                            </div>
                                                        @else
                                                            <div class="custom-dropdown-option" data-value="scolaire" id="scolariteOption">
                                                                Scolarité
                                                            </div>
                                                        @endif

                                                        {{-- TRANSPORT --}}
                                                        @if($eleve->a_transport)
                                                            @if($transportDisabled)
                                                                <div class="custom-dropdown-option disabled d-flex justify-content-between" data-value="transport" id="transportOption">
                                                                    Transport
                                                                    <span><i class="fas fa-check-circle"></i></span>
                                                                </div>
                                                            @else
                                                                <div class="custom-dropdown-option" data-value="transport" id="transportOption">
                                                                    Transport
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>

                                                    <input type="hidden" name="type" id="customDropdownValue" value="">
                                                    @error('type')
                                                        <div class="text-danger" style="position:absolute; top: 110%; left:3%;">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 position-relative">
                                                <label for="frequence_paiement" class="form-label m-1">Fréquence Paiement</label>
                                                <div class="custom-dropdown" id="frequenceDropdown">
                                                    <div class="custom-dropdown-selected d-flex justify-content-between" id="frequenceDropdownSelected">
                                                        <span>Choisir la fréquence</span>
                                                        <i class="fas fa-chevron-down mt-1"></i> <!-- Dropdown icon -->
                                                    </div>
                                                    <div class="custom-dropdown-options" id="frequenceDropdownOptions">
                                                        <div class="custom-dropdown-option" data-value="annuel">Annuel</div>
                                                        <div class="custom-dropdown-option" data-value="semestriel">Semestriel</div>
                                                        <div class="custom-dropdown-option" data-value="trimestriel">Trimestriel</div>
                                                        <div class="custom-dropdown-option" data-value="mensuel">Mensuel</div>
                                                    </div>
                                                    <input type="hidden" name="frequence_paiement" id="frequenceDropdownValue" value="">
                                                </div>
                                                @error('frequence_paiement')
                                                    <div class="text-danger" style="position:absolute; top: 110%; left:3%;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 1 -->
                                    <div class="form-section">
                                        <div class="row ms-3" style="width:96%;">
                                            <div class="col-md-6 position-relative">
                                                <label for="mode_paiement" class="form-label m-1">Mode Paiement</label>
                                                <div class="custom-dropdown" id="modePaiementDropdown">
                                                    <div class="custom-dropdown-selected d-flex justify-content-between" id="modePaiementDropdownSelected">
                                                        <span>Choisir le mode</span>
                                                        <i class="fas fa-chevron-down mt-1"></i> <!-- Dropdown icon -->
                                                    </div>
                                                    <div class="custom-dropdown-options" id="modePaiementDropdownOptions">
                                                        <div class="custom-dropdown-option" data-value="espèces">Espèces</div>
                                                        <div class="custom-dropdown-option" data-value="chèque">Chèque</div>
                                                        <div class="custom-dropdown-option" data-value="virement bancaire">Virement bancaire</div>
                                                        <div class="custom-dropdown-option" data-value="non spécifié">Autre</div>
                                                    </div>
                                                    <input type="hidden" name="mode_paiement" id="modePaiementDropdownValue" value="">
                                                </div>
                                                @error('mode_paiement')
                                                    <div class="text-danger" style="position:absolute; top: 110%; left:3%;">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 position-relative">
                                                <label for="montant" class="form-label m-1">Montant</label>
                                                <input type="number" id="montant" name="montant" value="{{ old('montant') }}"
                                                    class="custom form-control rounded-0 border-0 border-bottom mt-2">
                                                @error('montant')
                                                    <div class="text-danger" style="position:absolute; top: 110%; left:3%;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row ms-3 mt-5 mb-4" id="intervalSection" style="width:96%;">
                                            <div class="col-md-6 position-relative">
                                                <label for="interval_debut" class="form-label">Interval début</label>
                                                <input type="month" id="interval_debut" name="interval_debut" value="{{ old('interval_debut', request('interval_debut') ?? now()->format('Y-m')) }}"
                                                    class="custom form-control rounded-0 border-0 border-bottom mt-2">
                                                @error('interval_debut')
                                                    <div class="text-danger" style="position:absolute; top: 110%; left:3%;">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 position-relative">
                                                <label for="interval_fin" class="form-label">Interval fin</label>
                                                <input type="month" id="interval_fin" name="interval_fin" value="{{ old('interval_fin') }}"
                                                    class="custom form-control rounded-0 border-0 border-bottom mt-2">
                                                @error('interval_fin')
                                                    <div class="text-danger" style="position:absolute; top: 110%; left:3%;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="id_eleve" value="{{ $eleve->id }}">
                                    <input type="hidden" name="année" value="{{ date('Y') }}">

                                    <!-- Navigation Buttons -->
                                    <div class="form-navigation" style="width:96%;">
                                        <button type="button" class="previous btn text-white fw-bold bg-dark ms-5 my-4" style="float:left; display:none; background-color:#02021d !important;">
                                            <i class="fas fa-chevron-circle-left me-2"></i> Précédent
                                        </button>
                                        <button type="button" class="next btn text-white fw-bold bg-dark my-4" style="float:right; background-color:#02021d !important;">
                                            Suivant <i class="fas fa-chevron-circle-right ms-2"></i>
                                        </button>
                                        <button type="submit" name="task" class="btn text-white fw-bold bg-dark my-4" style="float:right; display:none; background-color:#02021d !important;">
                                            Confirmer
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const inscriptionOption = document.querySelector("#inscriptionOption:not(.disabled)");
            const montantInput = document.getElementById("montant");

            if (inscriptionOption) {
                inscriptionOption.addEventListener("click", () => {
                    const montantInscription = {{ $eleve->classe->niveau->cycle->montant_inscription ?? 0 }};
                    montantInput.value = {{ $restant_inscription }};
                    montantInput.max = {{ $restant_inscription }};
                });
            }
            montantInput.addEventListener('input', function() {
                if (parseFloat(montantInput.value) > parseFloat(montantInput.max)) {
                    montantInput.value = montantInput.max;
                }
            });

            montantInput.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
                    return;
                }

                if (parseFloat(montantInput.value) > parseFloat(montantInput.max)) {
                    e.preventDefault();
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const intervalDebut = document.getElementById("interval_debut");
            const intervalFin = document.getElementById("interval_fin");
            const montantInput = document.getElementById("montant");
            const typeInput = document.getElementById("customDropdownValue");

            const baseScolarite = {{ $eleve->classe->niveau->montant_scolarite }};
            const discount = {{ $eleve->discount ?? 0 }};
            const baseTransport = {{ $eleve->classe->niveau->cycle->montant_transport }};
            const transport_discount = {{ $eleve->transport_discount ?? 0 }};
            const monthlyScolarite = baseScolarite - (baseScolarite * discount / 100);
            const monthlyTransport = baseTransport - (baseTransport * transport_discount / 100);
            const restantInscription = {{ $restant_inscription ?? 0 }};

            const now = new Date();
            const currentMonth = now.getMonth() + 1;
            const currentYear = now.getFullYear();
            const startYear = currentMonth >= 9 ? currentYear : currentYear - 1;
            const endYear = startYear + 1;

            const minMonth = `${startYear}-09`;
            const maxMonth = `${endYear}-07`;

            intervalDebut.setAttribute("min", minMonth);
            intervalDebut.setAttribute("max", maxMonth);
            intervalFin.setAttribute("min", minMonth);
            intervalFin.setAttribute("max", maxMonth);

            function calculateMonthlyTotal() {
                const type = typeInput.value;
                const debut = intervalDebut.value;
                const fin = intervalFin.value;

                if (!debut || !fin || !type) return;

                const start = new Date(debut);
                const end = new Date(fin);

                let months = (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start.getMonth()) + 1;

                if (months < 1) {
                    montantInput.value = "";
                    montantInput.removeAttribute("max");
                    return;
                }

                let calculated = 0;
                let maxGlobal = 0;

                switch (type) {
                    case 'scolaire':
                        calculated = months * monthlyScolarite;
                        maxGlobal = {{ $restant_scolarite }};
                        break;
                    case 'transport':
                        calculated = months * monthlyTransport;
                        maxGlobal = {{ $restant_transport }};
                        break;
                    default:
                        calculated = 0;
                        maxGlobal = 0;
                }

                const finalMax = Math.min(calculated, maxGlobal);
                montantInput.value = finalMax;
                montantInput.max = finalMax;
            }

            intervalDebut.addEventListener("change", calculateMonthlyTotal);
            intervalFin.addEventListener("change", calculateMonthlyTotal);
            typeInput.addEventListener("change", calculateMonthlyTotal);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let currentStep = 0;
            const formSections = document.querySelectorAll(".form-section");
            const nextBtn = document.querySelector(".next");
            const prevBtn = document.querySelector(".previous");
            const submitBtn = document.querySelector("button[type='submit']");

            function showStep(index) {
                formSections.forEach((section, i) => {
                    section.style.display = i === index ? "block" : "none";
                });
                prevBtn.style.display = index === 0 ? "none" : "inline-block";
                nextBtn.style.display = index === formSections.length - 1 ? "none" : "inline-block";
                submitBtn.style.display = index === formSections.length - 1 ? "inline-block" : "none";
            }

            showStep(currentStep);

            nextBtn.addEventListener("click", () => {
                if (currentStep < formSections.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            prevBtn.addEventListener("click", () => {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            const intervalSection = document.getElementById('intervalSection');
            const typeInput = document.getElementById('customDropdownValue');
            const montantInput = document.getElementById("montant");

            function handleIntervalVisibility() {
                if (typeInput.value === 'inscription') {
                    intervalSection.style.display = 'none';
                    montantInput.readOnly = false;
                } else {
                    intervalSection.style.display = 'flex';
                    montantInput.readOnly = true;
                }
            }

            function toggleDropdown(dropdownId) {
                const dropdown = document.getElementById(dropdownId);
                const selectedElement = dropdown.querySelector(".custom-dropdown-selected");
                const optionsElement = dropdown.querySelector(".custom-dropdown-options");
                const options = dropdown.querySelectorAll(".custom-dropdown-option");

                selectedElement.addEventListener("click", () => {
                    dropdown.classList.toggle("open");
                });

                options.forEach(option => {
                    option.addEventListener("click", () => {
                        const value = option.getAttribute("data-value");
                        selectedElement.innerHTML = option.innerHTML;
                        dropdown.querySelector("input").value = value;
                        dropdown.classList.remove("open");

                        if (dropdownId === 'customDropdown') {
                            handleIntervalVisibility();
                        }
                    });
                });
            }

            toggleDropdown('customDropdown');
            toggleDropdown('frequenceDropdown');
            toggleDropdown('modePaiementDropdown');

            handleIntervalVisibility();
        });
    </script>

@endsection
