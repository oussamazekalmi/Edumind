@extends('layout.master')

@section('title')
    Ajouter niveau
@endsection

<style>
    .footer {
        display:none;
        visibility:hidden;
    }
</style>

@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="edit-profile">
        <div class="row d-flex justify-content-center">
          <div class="col-12">
            <form class="card rounded-0 shadow-sm" action="{{route('niveau.store')}}" method="POST">
                @csrf
                <div class="card-header pt-0 position-relative">
                    <a class="btn px-3 rounded-0 text-secondary" href="{{ route('niveau.liste') }}" style="position:absolute; bottom:0; left:0; background-color: #F1F1FC;">
                        <i class="fas fa-rotate-left"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="position-relative">
                                    <label class="form-label f-w-500">Cycle</label>
                                    <div class="custom-dropdown text-secondary" id="cycleDropdown">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" id="cycleDropdownSelected">
                                            <span id="cycleDropdownSelectedText" class="text-muted">Choisir un cycle</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options" id="cycleDropdownOptions">
                                            @foreach ($cycles as $cycle)
                                                <div class="custom-dropdown-option" data-value="{{$cycle->id}}">{{$cycle->nom}}</div>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="cycle" id="cycleDropdownValue" value="">
                                    </div>
                                    @error('cycle')
                                        <small class="text-danger ms-1" style="position:absolute; top: 110%; left:3%;">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label f-w-500">Niveau</label>
                                <input class="form-control forms-administartion rounded-0 my-2 text-secondary f-w-500" type="text" name='niveau' value="{{old('niveau')}}" autocomplete="off">
                                @error('niveau')
                                    <small class="text-danger ms-1" id="danger-message">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="montant_scolarite" class="form-label">Montant scolarite</label>
                                <input type="number" id="montant_scolarite" name="montant_scolarite" value="{{ old('montant_scolarite') }}"
                                    class="form-control forms-administartion rounded-0 my-2 f-w-500 text-secondary mb-2" autocomplete="off">
                                @error('montant_scolarite')
                                    <div class="text-danger ms-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer position-relative pt-5">
                    <div style="position:absolute; bottom:20%; right:2%;">
                        <button class="btn me-5 py-2 px-4 rounded-1 text-white" type="submit" style="background-color: #ace1af;">Créer</button>
                        <a class="btn py-2 px-4 rounded-1 text-white" href="{{ route('niveau.liste') }}" style="background-color: #FA8072;">Annuler</a>
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
        const dropdown = document.getElementById("cycleDropdown");
        const selected = document.getElementById("cycleDropdownSelected");
        const selectedText = document.getElementById("cycleDropdownSelectedText");
        const options = document.getElementById("cycleDropdownOptions");
        const hiddenInput = document.getElementById("cycleDropdownValue");

        selected.addEventListener("click", function (e) {
            e.stopPropagation();
            dropdown.classList.toggle("open");
        });

        document.querySelectorAll("#cycleDropdown .custom-dropdown-option").forEach(option => {
            option.addEventListener("click", function () {
                const value = this.getAttribute("data-value");
                const text = this.textContent;
                hiddenInput.value = value;
                selectedText.textContent = text;
                selectedText.classList.remove("text-muted");
                dropdown.classList.remove("open");
            });
        });

        document.addEventListener("click", function (e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove("open");
            }
        });
    });
  </script>

@endsection
