@extends('layout.master')

@section('title')
    Modifier une classe
@endsection

<style>
    .footer {
        display:none;
        visibility:hidden;
    }
</style>

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-12 col-lg-12">
                    <form class="card rounded-0 shadow-sm" action="{{ route('classes.update', $classe->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-header pt-0 position-relative">
                            <a class="btn px-3 rounded-0 text-secondary" href="{{ route('classes.index') }}" style="position:absolute; bottom:0; left:0; background-color: #F1F1FC;">
                                <i class="fas fa-rotate-left"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 me-5">
                                    <div>
                                        <label class="form-label f-w-500">Niveau</label>
                                        <div class="custom-dropdown text-secondary mb-2" id="niveauDropdown">
                                            <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" id="niveauDropdownSelected">
                                                <span id="niveauDropdownSelectedText">
                                                    {{ $niveaux->firstWhere('id', old('niveau', $classe->id_niveau))?->nom ?? 'Choisir un niveau' }}
                                                </span>
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                            <div class="custom-dropdown-options" id="niveauDropdownOptions">
                                                @foreach ($niveaux as $niveau)
                                                    <div class="custom-dropdown-option" data-value="{{ $niveau->id }}">
                                                        {{ $niveau->nom }}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="niveau" id="niveauDropdownValue" value="{{ old('niveau', $classe->id_niveau) }}">
                                        </div>
                                        @error('niveau')
                                            <small class="text-danger ms-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="my-2">
                                        <label class="form-label f-w-500">Classe</label>
                                        <input class="form-control forms-administartion rounded-0 mb-2 f-w-500 text-secondary" type="text" name="classe" value="{{ old('classe', $classe->nom) }}" autocomplete="off">
                                        @error('classe')
                                            <small class="text-danger ms-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer position-relative pt-5">
                            <div style="position:absolute; bottom:20%; right:2%;">
                                <button class="btn me-5 py-2 px-4 rounded-1 text-white" type="submit" style="background-color: lightblue;">Modifier</button>
                                <a class="btn py-2 px-4 rounded-1 text-white" href="{{ route('classes.index') }}" style="background-color: #FA8072;">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const niveauDropdown = document.getElementById("niveauDropdown");
        const niveauSelected = document.getElementById("niveauDropdownSelected");
        const niveauSelectedText = document.getElementById("niveauDropdownSelectedText");
        const niveauOptions = document.getElementById("niveauDropdownOptions");
        const niveauHiddenInput = document.getElementById("niveauDropdownValue");

        niveauSelected.addEventListener("click", function (e) {
            e.stopPropagation();
            niveauDropdown.classList.toggle("open");
        });

        document.querySelectorAll("#niveauDropdown .custom-dropdown-option").forEach(option => {
            option.addEventListener("click", function () {
                const value = this.getAttribute("data-value");
                const text = this.textContent.trim();
                niveauHiddenInput.value = value;
                niveauSelectedText.textContent = text;
                niveauSelectedText.classList.remove("text-muted");
                niveauDropdown.classList.remove("open");
            });
        });

        document.addEventListener("click", function (e) {
            if (!niveauDropdown.contains(e.target)) {
                niveauDropdown.classList.remove("open");
            }
        });
    });
</script>
@endsection
