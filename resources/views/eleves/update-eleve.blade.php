@extends('layout.master')

@section('title')
    Modifier l' élève n° {{$eleve->id}}
@endsection

<style>
    .footer {
        display:none;
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
    <div class="container-fluid ">
        <div class="row ">
          <div class="col-md-12 position-relative">
            <div class="card rounded-0 shadow-sm">
                <div class="card-header pt-3 ps-5">
                    <a class="btn rounded-0 tooltip-icon" data-tooltip="Liste d'élèves" href="{{ route('eleves.index') }}" style="position:absolute; top:0; left:0; background-color: #f8f9fa; color:#6c757d;; padding: 12px 14px; font-size: 16px;">
                        <i class="fas fa-home"></i>
                    </a>
                    <a class="btn rounded-0 text-white tooltip-icon" data-tooltip="Détails d'élève" href="{{ route('eleves.show', $eleve->id) }}" style="position:absolute; top:0; right:0; background-color: #6c757d; padding: 12px 18px;">
                        <i class="fas fa-user"></i>
                    </a>
                    <h5 class="mt-1 ms-4" style="font-size: 16px; font-weight: 500; color:#6c757d;">{{$eleve->nom.' '.$eleve->prenom}}</h5>
                </div>
                <div class="card-body pb-4">
                    <form class="form-wizard text-secondary" id="regForm" action="{{route('eleve.update',$eleve->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="tab">
                            <div class="row mb-5">
                                <div class="col-md-5 mx-5">
                                    <label for="nom">Nom</label>
                                    <input class="form-control mb-2 rounded-0" id="nom" name='nom' type="text" value='{{old('nom', $eleve->nom)}}' autocomplete="off">
                                    @error('nom')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="prenom">Prénom</label>
                                    <input class="form-control mb-2 rounded-0" id="prenom" name='prenom' type="text" value='{{old('prenom', $eleve->prenom)}}' autocomplete="off">
                                    @error('prenom')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mx-5">
                                    <label for="date_naissance">Date de naissance</label>
                                    <input class="form-control mb-2 rounded-0" type="date" id='date_naissance' name='date_naissance' onchange="getNaissance(this.value)" value='{{old('date_naissance', $eleve->date_naissance)}}'>
                                    @error('date_naissance')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="lieu_naissance">Lieu de naissance</label>
                                    <input class="form-control mb-2 rounded-0" type="text" id='lieu_naissance' name='lieu_naissance' value="{{old('lieu_naissance', $eleve->lieu_naissance)}}" autocomplete="off">
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
                                    <input class="form-control mb-2 rounded-0" type="text" maxlength="10" id='cne' name='cne' value="{{old('cne', $eleve->cne)}}" autocomplete="off">
                                    @error('cne')
                                        <small class="text-muted">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="col-md-5" id="cinForm">
                                    <label for="cin">CIN</label>
                                    <input class="form-control mb-2 rounded-0" type="text" maxlength="7" id='cin' name='cin' value="{{old('cin', $eleve->cin)}}" autocomplete="off">
                                    @error('cin')
                                        <small class="text-muted">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mx-5">
                                    <div class="mb-3">
                                        <label for="adresse">Adresse</label>
                                        <input class="form-control rounded-0" type="text" id="adresse" name='adresse' value="{{old('adresse', $eleve->adresse)}}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="mb-4">Genre</label>
                                    <div>
                                        <label style="cursor:pointer; color: lightblue; font-size: 20px;">
                                            <input class="form-check-input radio-input-male me-2" type="radio" name="genre" value="male" style="border: 1px solid #F5F5F5;" @checked(old('genre', $eleve->genre) === 'male') />
                                            <i class="fas fa-mars" style="font-size: x-large;"></i>
                                        </label>
                                        <label class="ms-5" style="cursor:pointer; color: lightpink; font-size: 20px;">
                                            <input class="form-check-input radio-input-female me-2" type="radio" name="genre" value="female" style="border: 1px solid #F5F5F5;" @checked(old('genre', $eleve->genre) === 'female') />
                                            <i class="fas fa-venus" style="font-size: x-large;"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab">
                            <div class="row mb-5">
                                <!-- Responsable -->
                                <div class="col-md-5 ms-5">
                                    <label for="statut_responsable">Responsable</label>
                                    <div class="custom-dropdown" id="dropdown-responsable">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" onclick="toggleDropdown('dropdown-responsable')">
                                            <span id="selected-responsable">{{ old('statut_responsable', $eleve->statut_responsable) ?? 'Choisir' }}</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options">
                                            @php $responsable = old('statut_responsable', $eleve->statut_responsable); @endphp
                                            <div class="custom-dropdown-option" onclick="selectCustomOption('responsable', 'père')">Père</div>
                                            <div class="custom-dropdown-option" onclick="selectCustomOption('responsable', 'mère')">Mère</div>
                                            <div class="custom-dropdown-option" onclick="selectCustomOption('responsable', 'autre')">Autre</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="statut_responsable" id="responsable" value="{{ $responsable }}">
                                </div>

                                <!-- Situation Familiale -->
                                <div class="col-md-5 ms-5">
                                    <label for="statut_familial">Situation Familiale</label>
                                    <div class="custom-dropdown" id="dropdown-familial">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" onclick="toggleDropdown('dropdown-familial')">
                                            @php
                                                $familialValue = old('statut_familial', $eleve->statut_familial);
                                                $familialLabel = $familialValue === 'ensemble' ? 'Mariés' : ($familialValue === 'divorcé' ? 'Divorcés' : 'Choisir');
                                            @endphp
                                            <span id="selected-familial">{{ $familialLabel }}</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options">
                                            @php $familial = old('statut_familial', $eleve->statut_familial); @endphp
                                            <div class="custom-dropdown-option" onclick="selectCustomOption('familial', 'ensemble')">Mariés</div>
                                            <div class="custom-dropdown-option" onclick="selectCustomOption('familial', 'divorcé')">Divorcés</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="statut_familial" id="familial" value="{{ $familial }}">
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-5 ms-5">
                                    <label for="statut">Statut élève</label>
                                    <div class="mt-4 d-flex">
                                        <label class="me-4" style="cursor:pointer;">
                                            <input class="radio_animated" type="radio" name="statut" value="en_cours"
                                                @checked(old('statut', $eleve->statut) == 'en_cours')> en cours d'étude
                                        </label>
                                        <label class="ms-4" style="cursor:pointer;">
                                            <input class="radio_animated" type="radio" name="statut" value="quitté"
                                                @checked(old('statut', $eleve->statut) == 'quitté')> quitte l'école
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="responsableForm"></div>

                        @if (!empty($eleve->statut_responsable) && $eleve->statut_responsable !== 'père' && $eleve->statut_responsable !== 'mère')
                            <div class='tab pt-5'>
                                <div class="row">
                                    <div class="col-md-3 ms-5">
                                        <label for="statut_autre">Spécifier Le Statut</label>
                                        <input  class="form-control rounded-0" id="statut_autre" name='statut_autre' type="text"
                                                value="{{old('statut_autre', $eleve->statut_autre)}}" placeholder="ex. oncle" autocomplete="off">
                                    </div>
                                    <div class="col-md-3 mx-3">
                                        <label for="nom_responsable">Nom Complet du Resonsable</label>
                                        <input  class="form-control rounded-0" id="nom_responsable" name='nom_responsable' type="text"
                                                value="{{old('nom_responsable', $eleve->nom_responsable)}}" placeholder="Nom Responsable" autocomplete="off">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tel_responsable">Téléphone du Responsable</label>
                                        <input  class="form-control rounded-0" type="text" id="tel_responsable" name='tel_responsable' maxlength="10"
                                                value="{{old('tel_responsable', $eleve->tel_responsable)}}" placeholder="xx-xxxx-xxxx" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class='tab'>
                                <div class="row mb-5">
                                    <div class="col-md-3 ms-5">
                                        <label for="nom_pere">Nom Complet du Père</label>
                                        <input  class="form-control rounded-0" id="nom_pere" name='nom_pere' type="text"
                                                value="{{old('nom_pere', $eleve->nom_pere)}}" placeholder="Nom Père" autocomplete="off">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tel_pere">Téléphone du Père</label>
                                        <input  class="form-control rounded-0" type="text" id="tel_pere" name="tel_pere" maxlength="10"
                                                value="{{old('tel_pere', $eleve->tel_pere)}}" placeholder="xx-xxxx-xxxx" autocomplete="off">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="profession_pere">Profession du Père</label>
                                        <input  class="form-control rounded-0" type="text" id="profession_pere" name="profession_pere"
                                                value="{{old('profession_pere', $eleve->profession_pere)}}" placeholder="Profession Père" autocomplete="off">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 ms-5">
                                        <label for="nom_mere">Nom Complet du Mère</label>
                                        <input  class="form-control rounded-0" id="nom_mere" name='nom_mere' type="text"
                                                value="{{old('nom_mere', $eleve->nom_mere)}}" placeholder="Nom Mère" autocomplete="off">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tel_mere">Téléphone du Mère</label>
                                        <input  class="form-control rounded-0" type="text" id="tel_mere" name="tel_mere" maxlength="10"
                                                value="{{old('tel_mere', $eleve->tel_mere)}}" placeholder="xx-xxxx-xxxx" autocomplete="off">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="profession_mere">Profession du Mère</label>
                                        <input  class="form-control rounded-0" type="text" id="profession_mere" name="profession_mere"
                                                value="{{old('profession_mere', $eleve->profession_mere)}}" placeholder="Profession Père" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class='tab'>
                                <div class="row mb-5">
                                    <div class="col-md-3 ms-5">
                                        <label for="nom_pere">Nom Complet du Père</label>
                                        <input  class="form-control rounded-0" id="nom_pere" name='nom_pere' type="text"
                                                value="{{old('nom_pere', $eleve->nom_pere)}}" placeholder="Nom Père" autocomplete="off">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tel_pere">Téléphone du Père</label>
                                        <input  class="form-control rounded-0" type="text" id="tel_pere" name="tel_pere"
                                                value="{{old('tel_pere', $eleve->tel_pere)}}" maxlength="10" placeholder="xx-xxxx-xxxx" autocomplete="off">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="profession_pere">Profession du Père</label>
                                        <input  class="form-control rounded-0" type="text" id="profession_pere" name="profession_pere"
                                                value="{{old('profession_pere', $eleve->profession_pere)}}" placeholder="Profession Père" autocomplete="off">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 ms-5">
                                        <label for="nom_mere">Nom Complet du Mère</label>
                                        <input  class="form-control rounded-0" id="nom_mere" name='nom_mere' type="text"
                                                value="{{old('nom_mere', $eleve->nom_mere)}}" placeholder="Nom Mère" autocomplete="off">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tel_mere">Téléphone du Mère</label>
                                        <input  class="form-control rounded-0" type="text" id="tel_mere" name="tel_mere"
                                                value="{{old('tel_mere', $eleve->tel_mere)}}" maxlength="10" placeholder="xx-xxxx-xxxx" autocomplete="off">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="profession_mere">Profession du Mère</label>
                                        <input  class="form-control rounded-0" type="text" id="profession_mere" name="profession_mere"
                                                value="{{old('profession_mere', $eleve->profession_mere)}}" placeholder="Profession Père" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="tab">
                            <div class="row mb-5">
                                <!-- Cycle -->
                                <div class="col-md-4 ms-5">
                                    <label for="cycle">Cycle</label>
                                    <div class="custom-dropdown" id="dropdown-cycle">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" onclick="toggleDropdown('dropdown-cycle')">
                                            <span id="selected-cycle">
                                                {{ $eleve->classe->niveau->cycle->nom ?? 'Choisir un cycle' }}
                                            </span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options">
                                            @foreach ($cycles as $cycle)
                                                <div class="custom-dropdown-option" onclick="selectCustomCycle('{{ $cycle->id }}', '{{ $cycle->nom }}')">{{ $cycle->nom }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <input type="hidden" name="cycle" id="cycle" value="{{ $eleve->classe->niveau->cycle->id ?? '' }}">
                                </div>

                                <!-- Niveau -->
                                <div class="col-md-4">
                                    <label for="niveau">Niveau</label>
                                    <div class="custom-dropdown" id="dropdown-niveau">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" onclick="toggleDropdown('dropdown-niveau')">
                                            <span id="selected-niveau">
                                                {{ $eleve->classe->niveau->nom ?? 'Choisir un niveau' }}
                                            </span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options" id="niveau-options">
                                            <!-- Dynamically populated -->
                                        </div>
                                    </div>
                                    <input type="hidden" name="niveau" id="niveau" value="{{ $eleve->classe->niveau->id ?? '' }}">
                                </div>

                                <!-- Classe -->
                                <div class="col-md-3">
                                    <label for="classe">Groupe</label>
                                    <div class="custom-dropdown mb-2" id="dropdown-classe">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" onclick="toggleDropdown('dropdown-classe')">
                                            <span id="selected-classe">
                                                {{ $eleve->classe->nom ?? 'Choisir un groupe' }}
                                            </span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options" id="classe-options">
                                            <!-- Dynamically populated -->
                                        </div>
                                    </div>
                                    <input type="hidden" name="id_classe" id="id_classe" value="{{ $eleve->classe->id }}">
                                    @error('id_classe')
                                        <small class="text-danger ms-1">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="tab mb-5">
                            <div class="row">
                                @php
                                    $discountValue = old('discount', $eleve->discount);
                                    $discountText = $discountValue == 0 ? 'Aucune' : $discountValue . '%';

                                    $discountTransportValue = old('transport_discount', $eleve->transport_discount);
                                    $discountTransportText = $discountTransportValue == 0 ? 'Aucune' : $discountTransportValue . '%';
                                @endphp

                                <div class="col-md-5 mx-5">
                                    <label for="discount">Réduction Scolarité (%)</label>
                                    <div class="custom-dropdown" id="dropdown-discount">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center"
                                            onclick="toggleDropdown('dropdown-discount')">
                                            <span id="selected-discount">{{ $discountText }}</span>
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
                                    <input type="hidden" name="discount" id="discount" value="{{ $discountValue }}">
                                </div>
                                <div class="col-md-5">
                                    <label for="transport_discount">Réduction Transport (%)</label>
                                    <div class="custom-dropdown" id="dropdown-transport_discount">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" onclick="toggleDropdown('dropdown-transport_discount')">
                                            <span id="selected-transport_discount">{{ $discountTransportText }}</span>
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
                                            <input class="radio_animated" type="radio" name="a_transport" value="1"
                                                @checked(old('a_transport', $eleve->a_transport) == 1)> Bénéficie du transport
                                        </label>
                                        <label style="cursor:pointer;">
                                            <input class="radio_animated" type="radio" name="a_transport" value="0"
                                                @checked(old('a_transport', $eleve->a_transport) == 0)> Ne bénéficie pas de transport
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

    <script>
        function toggleDropdown(id) {
            document.querySelectorAll('.custom-dropdown').forEach(d => {
                if (d.id !== id) d.classList.remove('open');
            });
            document.getElementById(id).classList.toggle('open');
        }

        function selectOption(fieldId, value, label = null) {
            let displayText = label || value;

            if (fieldId === 'discount') {
                displayText = value === '0' ? 'Aucune' : value + '%';
            } else if (fieldId === 'familiale') {
                displayText = value === 'ensemble' ? 'Mariés' : 'Divorcés';
            }

            document.getElementById(fieldId).value = value;
            document.getElementById(`selected-${fieldId}`).textContent = displayText;
            document.getElementById(`dropdown-${fieldId}`).classList.remove('open');

            if (fieldId === 'responsable') getResponsable(value);
            if (fieldId === 'familiale') getStatus(value);
        }

        document.addEventListener('click', function (e) {
            if (!e.target.closest('.custom-dropdown')) {
                document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('open'));
            }
        });

        function selectCustomOption(target, value) {
            document.getElementById(target).value = value;

            let label = value;
            if (target === 'familial') {
                label = value === 'ensemble' ? 'Mariés' : 'Divorcés';
            } else {
                label = value.charAt(0).toUpperCase() + value.slice(1);
            }

            document.getElementById(`selected-${target}`).textContent = label;
            document.getElementById(`dropdown-${target}`).classList.remove('open');

            if (target === 'responsable') {
                getResponsable(value);
            } else if (target === 'familial') {
                getStatus(value);
            }
        }
    </script>

    @push('cin')
        <script>
            function getNaissance(naissance) {
                let date = new Date(naissance);
                let today = new Date();

                let new_age = today.getFullYear() - date.getFullYear();

                if (new_age < 15) {
                    document.getElementById('cinForm').style.display = 'none';
                } else {
                    document.getElementById('cinForm').style.display = 'block';
                }
            }

            window.addEventListener('DOMContentLoaded', function () {
                const input = document.getElementById('date_naissance');
                if (input && input.value) {
                    getNaissance(input.value);
                }
            });
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

                if(responsable !== "père" && responsable !== "mère" && ({{$eleve->statut_responsable === 'père' || $eleve->statut_responsable === 'mère'}})) {

                    if(spanParent.length > 0) {
                        spanParent[0].remove();
                    }

                    ResponsableForm.innerHTML = `
                        <div class='tab pt-5'>
                            <div class="row">
                                <div class="col-md-3 ms-5">
                                    <label for="statut_autre">Spécifier Le Statut</label>
                                    <input  class="form-control rounded-0" id="statut_autre" name='statut_autre' type="text"
                                            value="{{old('statut_autre', $eleve->statut_autre)}}" placeholder="ex. oncle" autocomplete="off">
                                </div>
                                <div class="col-md-3 mx-3">
                                    <label for="nom_responsable">Nom Complet du Resonsable</label>
                                    <input  class="form-control rounded-0" id="nom_responsable" name='nom_responsable' type="text"
                                            value="{{old('nom_responsable', $eleve->nom_responsable)}}" placeholder="Nom Responsable" autocomplete="off">
                                </div>
                                <div class="col-md-4">
                                    <label for="tel_responsable">Téléphone du Responsable</label>
                                    <input  class="form-control rounded-0" type="text" id="tel_responsable" name='tel_responsable'
                                            value="{{old('tel_responsable', $eleve->tel_responsable)}}" maxlength="10" placeholder="xx-xxxx-xxxx" autocomplete="off">
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

            function selectCustomCycle(id, label) {
                document.getElementById('cycle').value = id;
                document.getElementById('selected-cycle').textContent = label;
                document.getElementById('dropdown-cycle').classList.remove('open');

                // Reset niveau and classe
                document.getElementById('niveau').value = '';
                document.getElementById('selected-niveau').textContent = 'Choisir un niveau';
                document.getElementById('niveau-options').innerHTML = '<div class="custom-dropdown-option">...</div>';

                document.getElementById('id_classe').value = '';
                document.getElementById('selected-classe').textContent = 'Choisir un groupe';
                document.getElementById('classe-options').innerHTML = '';

                fetch(`/eleve/filterNiveaux?cycle_id=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        const niveauOptions = document.getElementById('niveau-options');
                        niveauOptions.innerHTML = '';
                        data.forEach(niveau => {
                            const div = document.createElement('div');
                            div.className = 'custom-dropdown-option';
                            div.textContent = niveau.nom;
                            div.onclick = () => selectCustomNiveau(niveau.id, niveau.nom);
                            niveauOptions.appendChild(div);
                        });
                    }).catch(err => console.error('Erreur niveau:', err));
            }

            function selectCustomNiveau(id, label) {
                document.getElementById('niveau').value = id;
                document.getElementById('selected-niveau').textContent = label;
                document.getElementById('dropdown-niveau').classList.remove('open');

                // Reset classe
                document.getElementById('id_classe').value = '';
                document.getElementById('selected-classe').textContent = 'Choisir un groupe';
                document.getElementById('classe-options').innerHTML = '<div class="custom-dropdown-option">...</div>';

                fetch(`/eleve/filterClasses?niveau_id=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        const classeOptions = document.getElementById('classe-options');
                        classeOptions.innerHTML = '';
                        data.forEach(classe => {
                            const div = document.createElement('div');
                            div.className = 'custom-dropdown-option';
                            div.textContent = classe.nom;
                            div.onclick = () => selectCustomClasse(classe.id, classe.nom);
                            classeOptions.appendChild(div);
                        });
                    }).catch(err => console.error('Erreur classe:', err));
            }

            function selectCustomClasse(id, label) {
                document.getElementById('id_classe').value = id;
                document.getElementById('selected-classe').textContent = label;
                document.getElementById('dropdown-classe').classList.remove('open');
            }

            document.addEventListener('click', e => {
                if (!e.target.closest('.custom-dropdown')) {
                    document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('open'));
                }
            });
        </script>
    @endpush

@endsection
