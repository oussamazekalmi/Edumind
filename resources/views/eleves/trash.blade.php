@extends('layout.master')

@section('title', 'Corbeille')

<style>
    .recover {
        padding:12px 20px !important;
        color:#020227 !important;
        border-top:solid #020227 2px !important;
    }

    .recover:focus {
        color:lightgray !important;
        font-weight: 600 !important;
        border-top:none !important;
        box-shadow: none !important;
        transition: all 0.3s ease !important;
    }

    .vider {
        margin-top:12px !important;
        margin-right:-75px !important;
        padding:11px 24px !important;
        color:tomato !important;
        border-top:solid tomato 2px !important;
    }

    .vider:focus {
        color:lightgray !important;
        font-weight: 600 !important;
        border-top:none !important;
        box-shadow: none !important;
        transition: all 0.3s ease !important;
    }

    /* Personnalisation de la scrollbar */
    .table-responsive {
        overflow-x: auto;
        scrollbar-width: thin; /* Pour Firefox */
        scrollbar-color: #ccc transparent; /* Couleur du scroll pour Firefox */
    }

    /* Scrollbar pour Chrome, Edge et Safari */
    .table-responsive::-webkit-scrollbar {
        height: 6px; /* Taille du scrollbar */
    }

    .table-responsive::-webkit-scrollbar-track {
        background: transparent; /* Fond du scrollbar */
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: #bbb; /* Couleur de la barre */
        border-radius: 10px; /* Arrondi */
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background-color: #999; /* Couleur au survol */
    }

    /* Optimisation des styles des <td> */
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
</style>

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row d-flex justify-content-between align-items-center mt-4">
                    <div class="col-md-6 d-flex align-items-center">
                        <a href="{{ route('eleves.index') }}" style="padding: 14px 18px; color:#F9B948; background-color:#f8f8f8; border-bottom:solid 2px #F9B948">
                            <i class="fas fa-home"></i>
                        </a>
                        <span class="shadow-sm" style="padding: 12px 30px; color:#F9B948;">
                            <i class="fas fa-trash"></i>
                            <span class="ms-2">Corbeille</span>
                        </span>
                    </div>
                    <div class="col-md-3 text-end">
                        <form action="{{ route('frais.viderCorbeille') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="shadow-sm vider"
                                    style="border:none; outline:none; background-color:transparent;"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-action="{{ route('frais.viderCorbeille') }}">
                                <span>Vider la corbeille</span>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-3 text-end">
                        <a href="{{ route('frais.restoreAll') }}" class="shadow-sm recover">
                            <span>récupérer tout</span>
                        </a>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="card shadow-sm rounded-0 p-3">
                        <div class="table-responsive">
                            <table class="table table-borderless text-start">
                                <thead class="table-white">
                                    <tr>
                                        <th style="white-space: nowrap;">Type</th>
                                        <th style="white-space: nowrap;">Fréquence</th>
                                        <th style="white-space: nowrap;">Montant</th>
                                        <th style="white-space: nowrap;">Date de paiement</th>
                                        <th style="white-space: nowrap;">Période</th>
                                        <th style="white-space: nowrap;">Année Scolaire</th>
                                        <th class="text-center"><i class="fas fa-cogs" style="font-size:x-large; color:#020227"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($fraisSupprimes as $frais)
                                    <tr class="shadow-sm">
                                        <td style="white-space: nowrap; padding:20px;">{{ ucfirst($frais->type) === 'Scolaire' ? 'Scolarité' : ucfirst($frais->type) }}</td>
                                        <td style="white-space: nowrap; padding:20px;">{{ ucfirst($frais->frequence_paiement) }}</td>
                                        <td style="white-space: nowrap; padding:20px;">{{ number_format($frais->montant, 2) }} MAD</td>
                                        <td style="white-space: nowrap; padding:20px;">{{ date('d-m-Y', strtotime($frais->date_paiement)) }}</td>
                                        <td style="white-space: nowrap; padding:20px;">
                                            <span>{{ $frais->periode }}</span>
                                        </td>
                                        <td style="white-space: nowrap; padding:20px;">
                                            <span>{{ $frais->academicYear }}</span>
                                        </td>
                                        <td style="white-space: nowrap; padding:20px;" class="text-center">
                                            <a href="{{ route('frais.restore', $frais->id) }}" class="recover-one" style="color:#020227; border-bottom:solid #020227 1px;">
                                                <span>récupérer</span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr style="height: 20px;"></tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">La corbeille est vide.</td>
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
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 0;">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel" style="color:tomato;">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir <strong style="color:tomato;">vider la corbeille</strong> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-5 rounded-1 py-2" style="background-color: #F1F1FC; color: #0A0A23; font-weight: 400;" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteForm" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn rounded-1 py-2" style="background-color: tomato; color: white;">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const deleteForm = document.getElementById('deleteForm');
        const viderBtn = document.querySelector('.vider');

        viderBtn.addEventListener('click', function () {
            const action = this.getAttribute('data-action');
            deleteForm.action = action;
            deleteModal.show();
        });
    });
</script>

