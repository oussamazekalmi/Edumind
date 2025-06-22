@extends('layout.master')

@section('title')
    Frais Archivés
@endsection

<style>
    /* Personnalisation de la scrollbar */
    .table-responsive {
        overflow-x: auto;
        scrollbar-width: thin; /* Firefox */
        scrollbar-color: #ccc transparent;
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
        padding: 26px 20px !important;
    }

    .small-popup {
        width: 400px !important;
        padding: 15px !important;
        transform: translateX(75px) translateY(10px);
        transition: transform 2s linear;
    }

    .small-popup .swal2-title {
        font-size: 20px !important;
        font-weight: 500 !important;
    }

    .small-popup .swal2-html-container {
        font-size: 16px !important;
        font-weight: 500 !important;
        margin: 10px auto !important;
    }

    .small-popup .swal2-confirm,
    .small-popup .swal2-cancel {
        font-size: 14px !important;
        padding: 8px 26px !important;
    }

    .small-popup .swal2-actions {
        gap: 50px !important;
    }

    .small-icon {
        font-size: 8px !important;
    }

    #searchInput:focus {
        background-color: #fff !important;
    }
</style>

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6">
                        <a href="{{ route('eleves.index') }}" style="padding: 12px 14px 12px 18px; color:lightblue; background-color:#f8f8f8; border-bottom:solid 2px lightblue">
                            <span>
                                <i class="fas fa-home"></i>
                            </span>
                        </a>
                        <span class="shadow-sm" style="padding: 12px 30px; color:lightblue; border-bottom:solid 2px white">
                            <span>
                                <i class="fas fa-archive"></i>
                                <span class="ms-2">Archive</span>
                            </span>
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <span class="shadow-sm" style="padding: 10px 30px; color:tomato; border-bottom:solid 2px white">
                                <span>
                                    <span class="ms-2">Vider</span>
                                </span>
                            </span>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#confirmViderModal"
                            style="padding: 15px 22px; color:tomato; background-color:#f8f8f8; border-bottom:solid 2px tomato">
                                <i class="fas fa-trash"></i>
                            </a>
                        </ol>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="card shadow-sm px-3 py-2 rounded-0 position-relative">
                        <form method="GET" action="{{ route('archived.frais') }}" class="row align-items-center">
                            <div class="col-md-3 me-5">
                                <div class="col-md-3" style="width: 240px;">
                                    <div class="custom-dropdown text-secondary" id="yearDropdown">
                                        <div class="custom-dropdown-selected d-flex justify-content-between align-items-center shadow-sm round-degree a-color ps-4" id="yearDropdownSelected">
                                            <span id="yearDropdownSelectedText" class="{{ request('academic_year') ? '' : 'text-muted' }}">
                                                @if(request('academic_year') && request('academic_year') != 'all')
                                                    {{ request('academic_year') }} - {{ request('academic_year') + 1 }}
                                                @else
                                                    Tous
                                                @endif
                                            </span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="custom-dropdown-options round-degree a-color mt-2 shadow-sm" id="yearDropdownOptions">
                                            <div class="custom-dropdown-option" data-value="all">Tous</div>
                                            @foreach($academicYears as $year)
                                                <div class="custom-dropdown-option" data-value="{{ $year }}">{{ $year }} - {{ $year + 1 }}</div>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="academic_year" id="yearDropdownValue" value="{{ request('academic_year', 'all') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 d-flex align-items-center gap-3 mt-2">
                                <div class="position-relative flex-grow-1">
                                    <input type="text" name="search" class="form-control border-0 shadow-sm ps-5 py-4"
                                        placeholder="Rechercher par le nom d'élève"
                                        value="{{ request('search') }}"
                                        style="height: 44px; width: 100%; border-radius: 20px; background-color: #f8f9fa;
                                                transition: background 0.3s, box-shadow 0.3s;"
                                        autocomplete="off"
                                        id="searchInput"
                                        onfocus="showTooltip()"
                                        onblur="hideTooltip()"
                                    />
                                    <div id="tooltip" style="display:none; position:absolute; top: 50px; left: 38px; padding: 10px; border-radius: 5px; font-size: 13px; color:#F9B948;">
                                        Entrez d'abord le prénom, puis le nom.
                                    </div>
                                    <i class="fas fa-search position-absolute text-muted"
                                    style="left: 20px; top: 50%; transform: translateY(-50%);"></i>
                                </div>

                                <button type="submit" class="shadow-sm round-degree a-color"
                                        style="background-color:#f8f9fa; outline: none; border:none; padding:16px 24px;">
                                    <i class="fas fa-search"></i>
                                </button>

                                <a href="{{ route('archived.frais') }}" class="shadow-sm round-degree a-color"
                                style="background-color:#f8f9fa; border:none; outline: none; padding:16px 24px;">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </form>
                        <div class="table-responsive mt-4">
                            <table class="table table-borderless text-start">
                                <thead class="table-white">
                                    <tr>
                                        <th>Élève</th>
                                        <th>Type</th>
                                        <th>Montant</th>
                                        <th>Date paiement</th>
                                        <th>Période</th>
                                        <th>Année</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($fraisArchives as $frais)
                                        <tr class="shadow-sm">
                                            <td>{{ $frais->eleve->nom }} {{ $frais->eleve->prenom }}</td>
                                            <td>{{ ucfirst($frais->type) === 'Scolaire' ? 'Scolarité' : ucfirst($frais->type) }}</td>
                                            <td>{{ number_format($frais->montant, 2) }} MAD</td>
                                            <td>{{ date('d-m-Y', strtotime($frais->date_paiement)) }}</td>
                                            <td>{{ $frais->periode }}</td>
                                            <td>{{ $frais->academicYear }}</td>
                                        </tr>
                                        <tr style="height: 16px;"></tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Aucun frais archivé trouvé.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal for Vider Archives -->
    <div class="modal fade" id="confirmViderModal" tabindex="-1" aria-labelledby="confirmViderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 0;">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmViderModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir <strong>vider toutes les archives</strong> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn py-2 px-4" style="background-color: #dcdcdc; color: #0A0A23;" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <form action="{{ route('vider.archives') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn py-2 px-4" style="background-color:tomato; color:white;">
                            Confirmer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dropdown = document.getElementById("yearDropdown");
            const selected = document.getElementById("yearDropdownSelected");
            const selectedText = document.getElementById("yearDropdownSelectedText");
            const options = document.getElementById("yearDropdownOptions");
            const hiddenInput = document.getElementById("yearDropdownValue");

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
                    dropdown.closest('form').submit(); // auto-submit the form
                });
            });

            document.addEventListener("click", function (e) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove("open");
                }
            });
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
