@extends('layout.master')

@section('title', 'Liste des Paiements')

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

    /* Optimisation des styles des <td> */
        .table {
        font-size: small;
    }

    .table th {
        white-space: nowrap;
    }

    .table td {
        white-space: nowrap;
        padding: 10px !important;
    }

    .table td span {
        border-bottom: solid #020227 1px;
        padding-bottom: 1px;
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

    .link-corbeille:hover {
        box-shadow: none !important;
        background-color: tomato !important;
        color: white !important;
        border: white solid 1px !important;
        transition: ease .5s;
    }

    th {
        color: #6c757d !important;
    }
</style>

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-md-6">
                        <span class="shadow-sm f-w-500" style="padding: 16px 20px; color:#6c757d;">
                            <a href="{{ route('eleves.show', $eleve->id) }}" style="color:#6c757d; font-size: 15px;"><i class="fas fa-user"></i></a>
                            <span class="ms-3">{{ $eleve->prenom }} {{ $eleve->nom }}</span>
                        </span>
                        <a href="{{ route('paiements.traiter', $eleve->id) }}" class="text-black shadow-sm tooltip-icon" data-tooltip="Traiter paiement" style="padding: 16px 20px; background-color:#f8f9fa;">
                            <i class="fas fa-credit-card"></i>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <span style="padding: 16px 20px; background-color:#f8f9fa; color:#6c757d;">
                                <span>
                                    <span class="ms-2" style="font-weight: 500;">année scolaire &nbsp; &nbsp; &nbsp; <span style="color: #333;">{{$academicYear}}</span></span>
                                </span>
                            </span>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm rounded-0 p-4 mt-2 position-relative">
                <div class="table-responsive">
                    <table class="table table-borderless text-start">
                        <thead class="table-white">
                            <tr>
                                <th>Type</th>
                                <th>Fréquence</th>
                                <th>Montant</th>
                                <th>Date paiement</th>
                                <th>Période</th>
                                <th class="text-center"><i class="fas fa-cogs" style="font-size:22px;"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="height: 24px;"></tr>
                            @forelse($eleve->frais as $frais)
                                <tr class="shadow-sm">
                                    <td>{{ ucfirst($frais->type) === 'Scolaire' ? 'Scolarité' : ucfirst($frais->type) }}</td>
                                    <td>{{ ucfirst($frais->frequence_paiement) }}</td>
                                    <td>{{ number_format($frais->montant, 2) }} MAD</td>
                                    <td>{{ date('d-m-Y', strtotime($frais->date_paiement)) }}</td>
                                    <td><span>{{ $frais->periode }}</span></td>
                                    <td class="text-center">
                                        <a href="{{ route('paiements.edit', $frais->id) }}" class="shadow-sm round-degree a-color me-3 tooltip-icon" data-tooltip="Modifier le paiement" style="padding: 14px 14px; background-color:#f8f9fa;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('paiements.destroy', $frais->id) }}" method="POST" class="delete-form" data-id="{{ $frais->id }}" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="shadow-sm round-degree a-color text-center border-0 delete-btn tooltip-icon"
                                                data-tooltip="Supprimer"
                                                data-url="{{ route('paiements.destroy', $frais->id) }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                style="background-color:#f8f9fa; color:tomato; padding: 15px 17px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr style="height: 16px;"></tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Aucun paiement trouvé.</td>
                                    </tr>
                                @endforelse
                            <tr style="height: 36px;"></tr>
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('frais.corbeille.eleve', $eleve->id) }}" class="bg-white link-corbeille" style="position:absolute; bottom:0; right:0;padding: 8px 16px; color:tomato; border:1px solid tomato">
                    Corbeille
                </a>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 0;">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer ce paiement ?
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
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            deleteForm.setAttribute('action', url);
        });
    });
</script>

