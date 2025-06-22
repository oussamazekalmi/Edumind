@extends('layout.master')

@section('title')
    Liste des Niveaux
@endsection

@section('content')
<div class="page-body">
    <div class="container-fluid">
        @if(session('status'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: "{{ session('status') }}",
                        text: "{{ session('message') }}",
                        icon: "success",
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        },
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonText: "OK"
                    });
                };
            </script>
        @endif
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid basic_table">
      <div class="row">
        <div class="col-sm-12">
            <div class="card rounded-0 shadow-sm">
                <div class="card-header">
                    <a href="{{ route('niveau.ajouter') }}" class="btn px-3 py-2 text-secondary rounded-0 tooltip-icon" data-tooltip="Ajouter niveau" style="position:absolute; top:0; left:0; background-color: #F1F1FC;"><i class="fas fa-plus"></i></a>
                    <div class="my-4 mx-4">
                        <form action="{{ route('niveau.filtre') }}" method="get" class="d-flex align-items-center">
                            @csrf
                            <div class="custom-dropdown text-secondary" id="cycleDropdownFilter" style="width: 240px;">
                                <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" id="cycleDropdownFilterSelected">
                                    <span id="cycleDropdownFilterText" class="{{ request('select') ? '' : 'text-muted' }}">
                                        {{ request('select') ? ($cycles->firstWhere('id', request('select'))?->nom ?? 'Choisir un cycle') : 'Choisir un cycle' }}
                                    </span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="custom-dropdown-options" id="cycleDropdownFilterOptions">
                                    <div class="custom-dropdown-option" data-value="">Tous</div>
                                    @foreach ($cycles as $cycle)
                                        <div class="custom-dropdown-option" data-value="{{ $cycle->id }}">{{ $cycle->nom }}</div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="select" id="cycleDropdownFilterValue" value="{{ request('select') }}">
                            </div>

                            <a href="{{ route('niveau.filtre') }}" class="btn text-secondary px-3 mt-2 rounded-2 ms-3" style="background-color: #F1F1FC;">
                                <i class="fas fa-sync-alt"></i>
                            </a>
                        </form>
                    </div>
                    <div class="table-responsive theme-scrollbar mx-4 mb-4">
                        <table class="table table-borderless text-center">
                            <thead class="thead-info" >
                                <tr style="background-color: rgb(241, 241, 252)">
                                    <th>Cycle</th>
                                    <th>Niveau</th>
                                    <th>Montant scolarité</th>
                                    <th>Date modification</th>
                                    <th><i class="fas fa-sliders-h" style="font-size:20px; font-weight: 800;"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($niveaux as $niveau)
                                    <tr>
                                        <td>
                                            {{$niveau->cycle->nom}}
                                        </td>
                                        <td>
                                            {{$niveau->nom}}
                                        </td>
                                        <td>
                                            {{$niveau->montant_scolarite}} DH
                                        </td>
                                        <td>
                                            {{date('d-m-Y',strToTime($niveau->updated_at))}}
                                        </td>
                                        <td>
                                            <a class="btn px-3 py-2 text-light me-2 tooltip-icon" data-tooltip="Modifier niveau" href="{{ route('niveau.modifier', $niveau->id) }}" style="background-color: lightblue;"><i class="fas fa-edit"></i></a>
                                            <button class="btn px-3 py-2 text-light delete-btn tooltip-icon" data-tooltip="Supprimer" data-id="{{ $niveau->id }}" style="background-color: #FA8072;"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 0;">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Confirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Êtes-vous sûr de vouloir supprimer ce niveau ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn me-5 rounded-1 py-2" style="background-color: #dcdcdc; color: #0A0A23;" data-bs-dismiss="modal">Annuler</button>
          <form id="deleteForm" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn rounded-1 py-2" style="background-color: #0A0A23; color: white;">Confirmer</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
        const dropdown = document.getElementById("cycleDropdownFilter");
        const selected = document.getElementById("cycleDropdownFilterSelected");
        const selectedText = document.getElementById("cycleDropdownFilterText");
        const options = document.getElementById("cycleDropdownFilterOptions");
        const hiddenInput = document.getElementById("cycleDropdownFilterValue");

        selected.addEventListener("click", function (e) {
            e.stopPropagation();
            dropdown.classList.toggle("open");
        });

        document.querySelectorAll("#cycleDropdownFilter .custom-dropdown-option").forEach(option => {
            option.addEventListener("click", function () {
                const value = this.getAttribute("data-value");
                const text = this.textContent.trim();
                hiddenInput.value = value;
                selectedText.textContent = text;
                selectedText.classList.remove("text-muted");
                dropdown.classList.remove("open");

                dropdown.closest("form").submit();
            });
        });

        document.addEventListener("click", function (e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove("open");
            }
        });
    });
  </script>

  <!-- JavaScript for Modal -->
  <script>
  document.addEventListener("DOMContentLoaded", function() {
      const deleteButtons = document.querySelectorAll('.delete-btn');
      const deleteForm = document.getElementById('deleteForm');
      const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

      deleteButtons.forEach(button => {
          button.addEventListener('click', function() {
              const niveauId = button.getAttribute('data-id');
              const deleteUrl = `/supprimer/niveau/${niveauId}`;
              deleteForm.action = deleteUrl;
              deleteModal.show();
          });
      });
  });
</script>

@endsection
