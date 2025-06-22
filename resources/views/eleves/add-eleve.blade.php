@extends('layout.master')

@section('title')
    Ajouter Élève
@endsection

<style>
    .footer {
        display:none;
        visibility:hidden;
    }
</style>
<style>
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
        border-radius: 0;
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
        border-radius: 0;
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

    .custom-dropdown-option.disabled {
        pointer-events: none;
        color: #F9B948;
        font-weight: bold;
    }

    .form-control {
        background-color: #f8f9fa !important;
        color: #6c757d !important;
        padding: 14px !important;
        font-weight: 500 !important;
        border: none !important;
        border-radius: 0 !important;
    }

    .radio-input-male:checked {
        background-color: lightblue !important;
        box-shadow: 0 0 0 1px lightblue !important;
        cursor: pointer !important;
    }

    .radio-input-female:checked {
        background-color: lightpink !important;
        box-shadow: 0 0 0 1px lightpink !important;
        cursor: pointer !important;
    }

    .radio-input-male:hover,
    .radio-input-female:hover {
        cursor: pointer;
    }
</style>

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 position-relative">
            <div class="card rounded-0 shadow-sm">
                <div class="card-header pt-3 ps-5">
                    <a class="btn rounded-0 text-dark tooltip-icon" data-tooltip="Liste d'élèves" href="{{ route('eleves.index') }}" style="position:absolute; top:0; left:0; background-color: #f8f9fa !important; color: #6c757d !important; padding: 12px 14px; font-size: 16px;">
                        <i class="fas fa-home"></i>
                    </a>
                    <h4 class="ms-3 mt-1" style="font-size: 16px; font-weight: 500; color: #6c757d;">Créer un nouveau Élève</h4>
                </div>
                <div class="card-body pt-4">
                    <form class="form-wizard text-secondary" id="regForm" action="{{route('eleve.store')}}" method="POST">
                        @csrf
                        <div class="tab">
                            <div class="row mb-5">
                                <div class="col-md-5 mx-5">
                                    <label for="nom">Nom</label>
                                    <input class="form-control mb-2 rounded-0" id="nom" name='nom' type="text" value='{{old('nom')}}' autocomplete="off">
                                    @error('nom')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="prenom">Prénom</label>
                                    <input class="form-control mb-2 rounded-0" id="prenom" name='prenom' type="text" value='{{old('prenom')}}' autocomplete="off">
                                    @error('prenom')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mx-5">
                                    <label for="date_naissance">Date de naissance</label>
                                    <input class="form-control mb-2 rounded-0" type="date" id='date_naissance' name='date_naissance' onchange="getNaissance(this.value)" value='{{old('date_naissance')}}'>
                                    @error('date_naissance')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="lieu_naissance">Lieu de naissance</label>
                                    <input class="form-control mb-2 rounded-0" type="text" id='lieu_naissance' name='lieu_naissance' value="{{old('lieu_naissance', 'Oujda')}}" autocomplete="off">
                                    @error('lieu_naissance')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="tab">
                            <div class="row mb-5">
                                <div class="col-md-5 mx-5">
                                    <label for="cne">CNE</label>
                                    <input class="form-control mb-2 rounded-0" type="text" maxlength="10" id='cne' name='cne' value="{{old('cne')}}" autocomplete="off">
                                    @error('cne')
                                        <small class="text-muted">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="col-md-5" id="cinForm">
                                    <label for="cin">CIN</label>
                                    <input class="form-control mb-2 rounded-0" type="text" maxlength="7" id='cin' name='cin' value="{{old('cin')}}" autocomplete="off">
                                    @error('cin')
                                        <small class="text-muted">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mx-5">
                                    <div class="mb-3">
                                        <label for="adresse">Adresse</label>
                                        <input class="form-control rounded-0" type="text" id="adresse" name='adresse' value="{{old('adresse')}}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label for="exampleFormControlInput1" class="mb-4">Genre</label>
                                    <div>
                                        <label style="cursor:pointer; color: lightblue; font-size: 20px;">
                                            <input class="form-check-input radio-input-male me-2" type="radio" name="genre" value="male" style="border: 1px solid #F5F5F5;" checked />
                                            <i class="fas fa-mars" style="font-size: x-large;"></i>
                                        </label>
                                        <label class="ms-5" style="cursor:pointer; color: lightpink; font-size: 20px;">
                                            <input class="form-check-input radio-input-female me-2" type="radio" name="genre" value="female" style="border: 1px solid #F5F5F5;" />
                                            <i class="fas fa-venus" style="font-size: x-large;"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab pb-4">
                            <div class="row">
                                <!-- Responsable Dropdown -->
                                <div class="col-md-5 mx-5">
                                    <label for="responsable">Responsable</label>
                                    <div class="custom-dropdown" id="dropdown-responsable">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" onclick="toggleDropdown('dropdown-responsable')">
                                            <span id="selected-responsable">Choisir un statut</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options">
                                            <div class="custom-dropdown-option" onclick="selectOption('responsable', 'père')">Père</div>
                                            <div class="custom-dropdown-option" onclick="selectOption('responsable', 'mère')">Mère</div>
                                            <div class="custom-dropdown-option" onclick="selectOption('responsable', 'autre')">Autre</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="statut_responsable" id="responsable">
                                </div>

                                <!-- Situation Familiale Dropdown -->
                                <div class="col-md-5">
                                    <label for="familiale">Situation Familiale</label>
                                    <div class="custom-dropdown" id="dropdown-familiale">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" onclick="toggleDropdown('dropdown-familiale')">
                                            <span id="selected-familiale">Choisir une situation</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options">
                                            <div class="custom-dropdown-option" onclick="selectOption('familiale', 'ensemble')">Mariés</div>
                                            <div class="custom-dropdown-option" onclick="selectOption('familiale', 'divorcé')">Divorcés</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="statut_familial" id="familiale">
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-12 ms-5">
                                    <label for="statut">Statut élève</label>
                                    <div class="mt-4 d-flex">
                                        <label style="cursor:pointer;">
                                            <input class="radio_animated" type="radio" name="statut" value="en_cours" checked> en cours d'étude
                                        </label>
                                        <label class="ms-5" style="cursor:pointer;">
                                            <input class="radio_animated" type="radio" name="statut" value="quitté"> quitte l'école
                                        </label>
                                        <label class="ms-5" style="cursor:pointer;">
                                            <input class="radio_animated" type="radio" name="statut" value="lauréat"> lauréat
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="responsableForm"></div>

                        <div class="tab mb-5">
                            <div class="row mb-5">
                                <!-- Cycle -->
                                <div class="col-md-4 ms-5">
                                    <label for="cycle">Cycle</label>
                                    <div class="custom-dropdown" id="dropdown-cycle">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" onclick="toggleDropdown('dropdown-cycle')">
                                            <span id="selected-cycle">Choisir un cycle</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options" id="cycle-options">
                                            @foreach ($cycles as $cycle)
                                                <div class="custom-dropdown-option" onclick="selectCycle('{{ $cycle->id }}', '{{ $cycle->nom }}')">
                                                    {{ $cycle->nom }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <input type="hidden" name="cycle" id="cycle">
                                </div>

                                <!-- Niveau -->
                                <div class="col-md-4">
                                    <label for="niveau">Niveau</label>
                                    <div class="custom-dropdown" id="dropdown-niveau">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" onclick="toggleDropdown('dropdown-niveau')">
                                            <span id="selected-niveau">Choisir un niveau</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options" id="niveau-options">
                                            <!-- Loaded dynamically -->
                                        </div>
                                    </div>
                                    <input type="hidden" name="niveau" id="niveau">
                                </div>

                                <!-- Groupe -->
                                <div class="col-md-3">
                                    <label for="id_classe">Groupe</label>
                                    <div class="custom-dropdown mb-2" id="dropdown-classe">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" onclick="toggleDropdown('dropdown-classe')">
                                            <span id="selected-id_classe">Choisir un Groupe</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options" id="classe-options">
                                            <!-- Loaded dynamically -->
                                        </div>
                                    </div>
                                    <input type="hidden" name="id_classe" id="id_classe">
                                    @error('id_classe')
                                        <small class="text-danger ms-1">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="tab mb-5">
                            <div class="row">
                                <div class="col-md-5 mx-5">
                                    <label for="discount">Réduction Scolarité (%)</label>
                                    <div class="custom-dropdown" id="dropdown-discount">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" onclick="toggleDropdown('dropdown-discount')">
                                            <span id="selected-discount">Aucune</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options">
                                            <div class="custom-dropdown-option" onclick="selectOption('discount', '0', 'Aucune')">Aucune</div>
                                            <div class="custom-dropdown-option" onclick="selectOption('discount', '5', '5%')">5%</div>
                                            <div class="custom-dropdown-option" onclick="selectOption('discount', '10', '10%')">10%</div>
                                            <div class="custom-dropdown-option" onclick="selectOption('discount', '15', '15%')">15%</div>
                                            <div class="custom-dropdown-option" onclick="selectOption('discount', '20', '20%')">20%</div>
                                            <div class="custom-dropdown-option" onclick="selectOption('discount', '25', '25%')">25%</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="discount" id="discount" value="0">
                                </div>
                                <div class="col-md-5">
                                    <label for="transport_discount">Réduction Transport (%)</label>
                                    <div class="custom-dropdown" id="dropdown-transport_discount">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" onclick="toggleDropdown('dropdown-transport_discount')">
                                            <span id="selected-transport_discount">Aucune</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options">
                                            <div class="custom-dropdown-option" onclick="selectOption('transport_discount', '0', 'Aucune')">usage complet</div>
                                            <div class="custom-dropdown-option" onclick="selectOption('transport_discount', '25', '25%')">usage fréquent</div>
                                            <div class="custom-dropdown-option" onclick="selectOption('transport_discount', '50', '50%')">usage régulier</div>
                                            <div class="custom-dropdown-option" onclick="selectOption('transport_discount', '75', '75%')">usage occasionnel</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="transport_discount" id="transport_discount" value="0">
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-12 ms-5">
                                    <label for="a_transport">Frais de transport</label>
                                    <div class="mt-2 d-flex">
                                        <label class="me-5" style="cursor:pointer;">
                                            <input class="radio_animated" type="radio" name="a_transport" value="1" @checked(true)> Bénéficie du transport
                                        </label>
                                        <label style="cursor:pointer;">
                                            <input class="radio_animated" type="radio" name="a_transport" value="0"> Ne bénéficie pas de transport
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end btn-mb">
                            <button class="btn rounded-2 text-white fw-bold bg-dark ms-5 px-4" style="position:absolute; bottom: 3%; left: 3%; background-color:lightgray !important;" id="prevBtn" type="button" onclick="nextPrev(-1)">
                                Précédent
                            </button>
                            <button class="btn rounded-2 text-white fw-bold bg-dark me-5 px-4" style="position:absolute; bottom: 3%; right: 3%; background-color:#02021d !important;" id="nextBtn" type="button" onclick="nextPrev(1)">
                                Suivant
                            </button>
                        </div>
                        <div class="text-center"><span class="step"></span><span class="step" id="etap"></span><span class="step" id="stat"></span><span class="step"></span><span class="step"></span></div>
                    </form>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function toggleDropdown(id) {
        document.querySelectorAll('.custom-dropdown').forEach(d => {
            if (d.id !== id) d.classList.remove('open');
        });
        document.getElementById(id).classList.toggle('open');
    }

    function selectOption(fieldId, value) {
        displayText = value.charAt(0).toUpperCase() + value.slice(1);
        if (fieldId === 'discount' || fieldId === 'transport_discount') {
            displayText = value === '0' ? 'Aucune' : value + '%';
        }
        if (fieldId === 'familiale') {
            displayText = value === 'ensemble' ? 'Mariés' : 'Divorcés';
        }

        document.getElementById(fieldId).value = value.toLowerCase();
        document.getElementById(`selected-${fieldId}`).textContent = displayText;
        document.getElementById(`dropdown-${fieldId}`).classList.remove('open');

        if (fieldId === 'responsable') getResponsable(value.toLowerCase());
        if (fieldId === 'familiale') getStatus(value.toLowerCase());
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.custom-dropdown')) {
            document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('open'));
        }
    });
</script>

@push('cin')
    <script>
        function getNaissance(naissance) {
            let date = new Date(naissance);
            let today = new Date();
            let age = today.getFullYear() - date.getFullYear();

            if(age < 16) {
                document.getElementById('cinForm').style.display= 'none'
            }else{
                document.getElementById('cinForm').style.display= 'block';
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cneInput = document.getElementById('cne');
            const cinInput = document.getElementById('cin');

            const cnePattern = /^[A-Za-z]{1}[0-9]{9}$/;
            const cinPattern = /^[Ff][0-9]{6}$/;

            function validateInput(input, pattern, errorMessage) {
                let errorElement = input.nextElementSibling;

                if (!errorElement || !errorElement.classList.contains('text-muted')) {
                    errorElement = document.createElement('small');
                    errorElement.classList.add('text-muted');
                    input.parentNode.appendChild(errorElement);
                }

                if (input.value.trim() === '') {
                    errorElement.textContent = '';
                    return;
                }

                if (!pattern.test(input.value.trim())) {
                    errorElement.textContent = errorMessage;
                } else {
                    errorElement.textContent = '';
                }
            }

            cneInput.addEventListener('keyup', function () {
                validateInput(cneInput, cnePattern, 'Le CNE doit commencer par une lettre suivie de 9 chiffres.');
            });

            cinInput.addEventListener('keyup', function () {
                validateInput(cinInput, cinPattern, 'Le CIN doit commencer par "F" suivi de 6 chiffres.');
            });
        });
    </script>
@endpush

@push('responsable')
    <script>
        function getResponsable(responsable) {

            const ResponsableForm = document.getElementById('responsableForm');
            const span = document.getElementById('etap');
            const steps = document.getElementsByClassName('step');
            const spanParent = document.getElementsByClassName('parent');
            const spanAutre = document.getElementsByClassName('autre');

            ResponsableForm.innerHTML = '';

            if(responsable !== "père" && responsable !== "mère") {

                if(spanParent.length > 0) {
                    spanParent[0].remove();
                }

                ResponsableForm.innerHTML = `
                    <div class='tab pt-5'>
                        <div class="row">
                            <div class="col-md-3 ms-5">
                                <label for="statut_autre">Spécifier Le Statut</label>
                                <input class="form-control rounded-0" id="statut_autre" name='statut_autre' type="text" placeholder="ex. oncle" autocomplete="off">
                            </div>
                            <div class="col-md-3 mx-3">
                                <label for="nom_responsable">Nom Complet du Resonsable</label>
                                <input class="form-control rounded-0" id="nom_responsable" name='nom_responsable' type="text" placeholder="Nom Responsable" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label for="tel_responsable">Téléphone du Responsable</label>
                                <input class="form-control rounded-0" type="text" maxlength="10" id="tel_responsable" name='tel_responsable' placeholder="xx-xxxx-xxxx" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class='tab'>
                        <div class="row mb-5">
                            <div class="col-md-3 ms-5">
                                <label for="nom_pere">Nom Complet du Père</label>
                                <input class="form-control rounded-0" id="nom_pere" name='nom_pere' type="text" placeholder="Nom Père" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label for="tel_pere">Téléphone du Père</label>
                                <input class="form-control rounded-0" type="text" id="tel_pere" maxlength="10" name="tel_pere" placeholder="xx-xxxx-xxxx" autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <label for="profession_pere">Profession du Père</label>
                                <input class="form-control rounded-0" type="text" id="profession_pere" name="profession_pere" placeholder="Profession Père" autocomplete="off">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 ms-5">
                                <label for="nom_mere">Nom Complet du Mère</label>
                                <input class="form-control rounded-0" id="nom_mere" name='nom_mere' type="text" placeholder="Nom Mère" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label for="tel_mere">Téléphone du Mère</label>
                                <input class="form-control rounded-0" type="text" id="tel_mere" maxlength="10" name="tel_mere" placeholder="xx-xxxx-xxxx" autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <label for="profession_mere">Profession du Mère</label>
                                <input class="form-control rounded-0" type="text" id="profession_mere" name="profession_mere" placeholder="Profession Père" autocomplete="off">
                            </div>
                        </div>
                    </div>
                `;

                const step = document.createElement('span');
                step.classList.add('step','autre');
                span.insertAdjacentElement('afterend',step);

            }   else {

                if(spanAutre.length > 0) {
                    spanAutre[0].remove();
                }

                ResponsableForm.innerHTML = `
                    <div class='tab'>
                        <div class="row mb-5">
                            <div class="col-md-3 ms-5">
                                <label for="nom_pere">Nom Complet du Père</label>
                                <input class="form-control rounded-0" id="nom_pere" name='nom_pere' type="text" placeholder="Nom Père" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label for="tel_pere">Téléphone du Père</label>
                                <input class="form-control rounded-0" type="text" id="tel_pere" maxlength="10" name="tel_pere" placeholder="xx-xxxx-xxxx" autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <label for="profession_pere">Profession du Père</label>
                                <input class="form-control rounded-0" type="text" id="profession_pere" name="profession_pere" placeholder="Profession Père" autocomplete="off">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 ms-5">
                                <label for="nom_mere">Nom Complet du Mère</label>
                                <input class="form-control rounded-0" id="nom_mere" name='nom_mere' type="text" placeholder="Nom Mère" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label for="tel_mere">Téléphone du Mère</label>
                                <input class="form-control rounded-0" type="text" id="tel_mere" maxlength="10" name="tel_mere" placeholder="xx-xxxx-xxxx" autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <label for="profession_mere">Profession du Mère</label>
                                <input class="form-control rounded-0" type="text" id="profession_mere" name="profession_mere" placeholder="Profession Père" autocomplete="off">
                            </div>
                        </div>
                    </div>
                `;

                const step = document.createElement('span');
                step.classList.add('step','parent');
                span.insertAdjacentElement('afterend',step);
            }
        }
    </script>
@endpush

@push('niveau')
<script>
    function toggleDropdown(id) {
        document.querySelectorAll('.custom-dropdown').forEach(d => {
            if (d.id !== id) d.classList.remove('open');
        });
        document.getElementById(id).classList.toggle('open');
    }

    function selectCycle(id, name) {
        document.getElementById('cycle').value = id;
        document.getElementById('selected-cycle').textContent = name;
        document.getElementById('dropdown-cycle').classList.remove('open');

        fetch(`/eleve/filterNiveaux?cycle_id=${id}`)
            .then(response => response.json())
            .then(data => {
                const niveauOptions = document.getElementById('niveau-options');
                niveauOptions.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(niveau => {
                        let div = document.createElement('div');
                        div.className = 'custom-dropdown-option';
                        div.textContent = niveau.nom;
                        div.onclick = () => selectNiveau(niveau.id, niveau.nom);
                        niveauOptions.appendChild(div);
                    });
                } else {
                    niveauOptions.innerHTML = '<div class="custom-dropdown-option disabled" style="font-size: 12px;">Aucun niveau disponible</div>';
                }
                // Reset downstream selections
                document.getElementById('selected-niveau').textContent = 'Choisir un niveau';
                document.getElementById('niveau').value = '';
                document.getElementById('selected-id_classe').textContent = 'Choisir un Groupe';
                document.getElementById('id_classe').value = '';
                document.getElementById('classe-options').innerHTML = '';
            });
    }

    function selectNiveau(id, name) {
        document.getElementById('niveau').value = id;
        document.getElementById('selected-niveau').textContent = name;
        document.getElementById('dropdown-niveau').classList.remove('open');

        // Load classes
        fetch(`/eleve/filterClasses?niveau_id=${id}`)
            .then(response => response.json())
            .then(data => {
                const classeOptions = document.getElementById('classe-options');
                classeOptions.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(classe => {
                        let div = document.createElement('div');
                        div.className = 'custom-dropdown-option';
                        div.textContent = classe.nom;
                        div.onclick = () => selectClasse(classe.id, classe.nom);
                        classeOptions.appendChild(div);
                    });
                } else {
                    classeOptions.innerHTML = '<div class="custom-dropdown-option disabled" style="font-size: 12px;">Aucun groupe disponible</div>';
                }
                document.getElementById('selected-id_classe').textContent = 'Choisir un Groupe';
                document.getElementById('id_classe').value = '';
            });
    }

    function selectClasse(id, name) {
        document.getElementById('id_classe').value = id;
        document.getElementById('selected-id_classe').textContent = name;
        document.getElementById('dropdown-classe').classList.remove('open');
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.custom-dropdown')) {
            document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('open'));
        }
    });
</script>
@endpush

