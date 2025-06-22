@extends('layout.master')

@section('title')
    La liste d'élèves
@endsection

<style>
  .table tbody tr td{
    padding: 8px;
  }

  tr:hover {
    background-color: #f8f9fa !important;
    transition: background-color 0.3s ease-out !important;
  }

  .btn:focus,
  .btn:active,
  .btn-group:focus-within,
  .btn:focus-visible {
    outline: none !important;
    box-shadow: none !important;
    border: none !important;
  }

  .table-responsive {
    overflow-x: auto;
    scrollbar-width: thin;
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
  }

  .table-responsive::-webkit-scrollbar-thumb:hover {
    background-color: #999;
  }

  .table {
    font-size: 14px;

  }

  .table th {
    white-space: nowrap;
    font-weight: 500 !important;
  }

  .table td {
    white-space: nowrap;
  }

  #searchInput:focus {
    background-color: #fff !important;
  }

  .tooltip-icon {
    position: relative;
  }

  .td-color {
    position: absolute;
    top:16%;
    left: 20%;
  }

  .payment-box {
    width: 30px;
    height: 30px;
    margin-right: 10px;
    border-radius: 50%;
  }

  .payment-box2 {
    width: 25px;
    height: 25px;
  }
</style>

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-title">
        <div class="container position-relative">
          <div class="row">
            <div class="col-sm-9">
                <form method="GET" action="{{ route('eleves.index') }}" style="display: flex; align-items: center; gap: 60px;">
                    <a href="{{ route('eleve.ajoute') }}" class="shadow-sm round-degree a-color py-3 tooltip-icon"
                    style="background-color:#f8f9fa; border:none; outline: none; padding:12px 24px;" data-tooltip="Ajout élève">
                        <i class="fas fa-plus"></i>
                    </a>

                    <div style="display: flex; align-items: center; gap: 8px; flex-grow: 1;">
                        <div class="position-relative" style="flex-grow: 1;">
                            <input
                                type="text"
                                name="search"
                                class="form-control border-0 shadow-sm py-4 ps-5"
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
                                style="left: 20px; top: 50%; transform: translateY(-50%);">
                            </i>
                        </div>

                        <!-- Search Button -->
                        <button type="submit" class="shadow-sm round-degree a-color py-3 px-4 ms-2"
                            style="background-color:#f8f9fa; border:none;">
                            <i class="fas fa-search"></i>
                        </button>

                        <!-- Reset Button -->
                        @if(request()->has('search'))
                            <a href="{{ route('eleves.index') }}" class="shadow-sm round-degree a-color py-3 px-4"
                                style="background-color:#f8f9fa; border:none;">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
          </div>
          <div style="position: absolute; top:22%; left:-2%">
            <div class="payment-box2 tooltip-icon" data-tooltip="non payé" style="background-color: tomato;"></div>
            <div class="payment-box2 my-4 tooltip-icon" data-tooltip="partiellement  payé" style="background-color: #F9B948"></div>
            <div class="payment-box2 tooltip-icon" data-tooltip="totalement payé" style="background-color: lightblue;"></div>
            </div>
          <div class="row">
            <div class="table-responsive mt-5">
                <table class="table table-borderless rounded-0 text-center shadow-sm">
                  <thead style="cursor:default;">
                    <tr class="table-light">
                        <th class="text-secondary">Numéro inscription</th>
                        <th class="text-secondary">Nom</th>
                        <th class="text-secondary">Niveau</th>
                        <th class="text-secondary">Progression paiements</th>
                        <th class="text-center text-secondary"><i class="fas fa-cogs" style="font-size:x-large;"></i></th>
                    </tr>
                </thead>
                <tbody class="bg-white" style="cursor:default;">
                    @forelse ($eleves as $eleve)
                      @if ($eleve->statut === 'en_cours')
                        <tr>
                            <td>{{ $eleve->num_inscription }}</td>
                            <td>{{ $eleve->prenom.' '.$eleve->nom }}</td>
                            <td>{{ $eleve->classe->niveau->nom ?? 'N/A' }}</td>
                            <td class="position-relative">
                               <div class="td-color d-flex text-center" style="width:100%;">
                                    <div class="payment-box tooltip-icon" data-tooltip="Inscription" style="background-color: {{ $eleve->statut_paiement['inscription'] === 'paye' ? 'lightblue' : ($eleve->statut_paiement['inscription'] === 'partiel' ? '#F9B948' : 'tomato') }};"></div>
                                    <div class="payment-box tooltip-icon" data-tooltip="Scolarité" style="background-color: {{ $eleve->statut_paiement['scolarite'] === 'paye' ? 'lightblue' : ($eleve->statut_paiement['scolarite'] === 'partiel' ? '#F9B948' : 'tomato') }};"></div>
                                    @if ($eleve->a_transport)
                                        <div class="payment-box tooltip-icon" data-tooltip="Transport" style="background-color: {{ $eleve->statut_paiement['transport'] === 'paye' ? 'lightblue' : ($eleve->statut_paiement['transport'] === 'partiel' ? '#F9B948' : 'tomato') }};"></div>
                                    @endif
                                </div>
                            </td>
                            <td>
                              <div class="btn-group me-2" style="cursor:pointer;">
                                <a href="{{ route('eleves.show', $eleve->id) }}" class="btn bg-light px-3 text-black tooltip-icon" data-tooltip="Voir Les Détails">
                                  <i class="fas fa-eye py-1"></i>
                                </a>
                                <a href="{{ route('eleve.modifier', $eleve->id) }}" class="btn bg-light px-3 text-black tooltip-icon" data-tooltip="Modifier L'élève">
                                  <i class="fas fa-edit py-1"></i>
                                </a>
                                <a href="{{ route('paiements.traiter', $eleve->id) }}" class="btn bg-light px-3 text-black tooltip-icon" data-tooltip="Traiter Paiement">
                                  <i class="fas fa-credit-card py-1"></i>
                                </a>
                              </div>
                            </td>
                        </tr>
                      @endif
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucun élève trouvé.</td>
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

<script>
    function showTooltip() {
        const tooltip = document.getElementById('tooltip');
        if (tooltip) tooltip.style.display = 'block';
    }

    function hideTooltip() {
        const tooltip = document.getElementById('tooltip');
        if (tooltip) tooltip.style.display = 'none';
    }
</script>

@endsection
