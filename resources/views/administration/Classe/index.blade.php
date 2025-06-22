@extends('layout.master')

@section('title')
    Liste des classes
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
                            confirmButtonText: "OK"
                        });
                    };
                </script>
            @endif

            <div class="card rounded-0 shadow-sm">
                <div class="card-header position-relative">
                    <a href="{{ route('classes.create') }}" class="btn px-3 py-2 text-secondary rounded-0 tooltip-icon" data-tooltip="Ajouter groupe" style="position:absolute; top:0; left:0; background-color: #F1F1FC;"><i class="fas fa-plus"></i></a>
                    <form class="row g-3 align-items-center mt-2 ms-2" style="width: 70%" method="GET" action="{{ route('classes.filter') }}">
                        <div class="col-auto" style="width: 240px;">
                            <div class="custom-dropdown text-secondary mb-2" id="cycleDropdown">
                                <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" id="cycleDropdownSelected">
                                    <span id="cycleDropdownSelectedText" class="{{ request('cycle') ? '' : 'text-muted' }}">
                                        {{ request('cycle') ? ($cycles->firstWhere('id', request('cycle'))?->nom ?? 'Choisir un cycle') : 'Choisir un cycle' }}
                                    </span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="custom-dropdown-options" id="cycleDropdownOptions">
                                    <div class="custom-dropdown-option" data-value="">Tous</div>
                                    @foreach ($cycles as $cycle)
                                        <div class="custom-dropdown-option" data-value="{{ $cycle->id }}">{{ $cycle->nom }}</div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="cycle" id="cycleDropdownValue" value="{{ request('cycle') }}">
                            </div>
                        </div>

                        @if (request('cycle'))
                            <div class="col-auto ms-4" style="width: 240px;">
                                <div class="custom-dropdown text-secondary mb-2" id="niveauDropdown">
                                    <div class="custom-dropdown-selected d-flex justify-content-between align-items-center" id="niveauDropdownSelected">
                                        <span id="niveauDropdownSelectedText" class="{{ request('niveau') ? '' : 'text-muted' }}">
                                            {{ request('niveau') ? ($niveaux->firstWhere('id', request('niveau'))?->nom ?? 'Choisir un niveau') : 'Choisir un niveau' }}
                                        </span>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                    <div class="custom-dropdown-options" id="niveauDropdownOptions">
                                        <div class="custom-dropdown-option" data-value="">Tous</div>
                                        @foreach ($niveaux as $niveau)
                                            @if ($niveau->id_cycle == request('cycle'))
                                                <div class="custom-dropdown-option" data-value="{{ $niveau->id }}">{{ $niveau->nom }}</div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="niveau" id="niveauDropdownValue" value="{{ request('niveau') }}">
                                </div>
                            </div>
                        @endif
                        <a href="{{ route('classes.index') }}" class="btn text-secondary col-auto px-3 rounded-2 ms-4" style="background-color: #F1F1FC;"><i class="fas fa-sync-alt"></i></a>
                    </form>
                </div>
                <div class="table-responsive theme-scrollbar mx-4 px-4 mb-4">
                    <table class="table table-borderless text-center">
                        <thead>
                            <tr style="background-color: rgb(241, 241, 252)">
                                <th>Cycle</th>
                                <th>Classe</th>
                                <th>Nombre élèves</th>
                                <th>Date modification</th>
                                <th><i class="fas fa-sliders-h" style="font-size:20px; font-weight: 800;"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $classe)
                                <tr>
                                    <td>{{ $classe->niveau->cycle->nom }}</td>
                                    <td>{{ $classe->nom }}</td>
                                    <td>{{ $classe->eleves->count() ?? 0}}</td>
                                    <td>{{ $classe->updated_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a class="btn px-3 py-2 text-light me-2 tooltip-icon" data-tooltip="Modifier groupe" href="{{ route('classes.edit', $classe->id) }}" style="background-color: lightblue;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn px-3 py-2 text-light delete-btn tooltip-icon" data-tooltip="Supprimer" data-id="{{ $classe->id }}" style="background-color: #FA8072;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                    Êtes-vous sûr de vouloir supprimer cette classe ?
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
            ['cycle', 'niveau'].forEach(prefix => {
                const dropdown = document.getElementById(`${prefix}Dropdown`);
                const selected = document.getElementById(`${prefix}DropdownSelected`);
                const selectedText = document.getElementById(`${prefix}DropdownSelectedText`);
                const options = document.getElementById(`${prefix}DropdownOptions`);
                const hiddenInput = document.getElementById(`${prefix}DropdownValue`);

                if (!dropdown) return;

                selected.addEventListener("click", function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle("open");
                });

                dropdown.querySelectorAll(".custom-dropdown-option").forEach(option => {
                    option.addEventListener("click", function () {
                        const value = this.getAttribute("data-value");
                        const text = this.textContent.trim();
                        hiddenInput.value = value;
                        selectedText.textContent = text;
                        selectedText.classList.remove("text-muted");
                        dropdown.classList.remove("open");
                        dropdown.closest('form').submit(); // auto-submit form
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

    <!-- JavaScript for Modal -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteForm = document.getElementById('deleteForm');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const classeId = button.getAttribute('data-id');
                    const deleteUrl = `/classes/${classeId}/delete`;
                    deleteForm.action = deleteUrl;
                    deleteModal.show();
                });
            });
        });
    </script>

@endsection
