@extends('layout.master')

@section('title')
    Caisse
@endsection

<style>
    .footer {
        display:none;
        visibility:hidden;
    }

    .input-container {
        position: relative;
        margin-top: 1rem;
    }

    .input-container input {
        width: 100%;
        padding-bottom: .7rem !important;
        padding-left: 24px !important;
        border: 1px solid lightgray;
        padding: 1rem 0.75rem 0.25rem 0.75rem;
        background: transparent;
        font-size: 14px !important;
    }

    .input-container label {
        position: absolute;
        top: -0.6rem;
        left: 3rem;
        background: white;
        padding: 0 0.25rem;
        font-size: 0.8rem;
        color: #333;
    }

    .input-container input:focus,
    .input-container input:not(:placeholder-shown) {
        padding-top: .7rem;
    }

    .input-container input:focus + label,
    .input-container input:not(:placeholder-shown) + label {
        top: -0.75rem;
        left: 2rem;
        font-size: 0.875rem;
        color: #B8B6B3;
    }

    .btn {
        padding: 12px 0 !important;
        background-color: white !important;
        color: #B8B6B3 !important;
        border: 1px lightgray solid !important;
    }

    th {
        font-weight: 400 !important;
    }
</style>

@section('content')
    <div class="page-body">
        <div class="row">
          <div class="col-md-12">
            <div class="card rounded-0 shadow-sm">
                <div class="card-header pt-4 position-relative">
                    <a class="rounded-0 text-dark py-2 shadow-sm" href="{{ route('inscription.frais') }}" style="position:absolute; top:0; left:0; background-color: #FBFBFA; padding: 12px 18px;">
                        <i style="color:#B8B6B3;" class="fas fa-user-plus me-3"></i> Frais Inscription
                    </a>
                    <a class="rounded-0 text-dark py-2 shadow-sm" href="{{ route('scolaire.frais') }}" style="position:absolute; top:0; left:40%; background-color: #FBFBFA; padding: 12px 18px;">
                        <i style="color:#6495ED;" class="fas fa-school me-3"></i> Frais Scolarité
                    </a>
                    <a class="rounded-0 text-dark py-2 shadow-sm" href="{{ route('transport.frais') }}" style="position:absolute; top:0; right:0; background-color: #FBFBFA; padding: 12px 18px;">
                        <i style="color:#6495ED;" class="fas fa-bus me-3"></i> Frais Transport
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mt-5 mb-3 position-relative">
                        <div class="col-md-4 mx-5">
                            <form action="{{ route('index.frais') }}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="input-container col-md-10">
                                        <input type="month" name="mois" id="mois" class="form-control rounded-5 text-secondary"
                                            value="{{ old('mois', request('mois') ?? now()->format('Y-m')) }}">
                                        <label for="mois">le mois</label>
                                    </div>
                                    <button type="submit" class="btn col-md-2 px-0 rounded-5">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 ms-5">
                            <form action="{{ route('index.frais') }}" method="GET">
                                @csrf

                                <div class="row">
                                    <div class="input-container col-md-10">
                                        <input type="date" name="day" id="day" class="form-control rounded-5 text-secondary"
                                            value="{{ request('day', now()->format('Y-m-d')) }}">
                                        <label for="day">le jour</label>
                                    </div>
                                    <button type="submit" class="btn col-md-2 px-0 rounded-5">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        @if(request()->has('mois') || request()->has('day'))
                            <a href="{{ route('index.frais') }}" style="position:absolute; top:0%; right:6%;" class="btn col-md-1 py-3 rounded-5">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>

                    <div class="table-responsive px-5">
                        <table class="table table-bordered" style="font-size: 14px !important;">
                            <thead>
                                <tr style="background-color:#F8F8F7; border:none;">
                                    <th class="text-secondary">type paiement</th>
                                    <th class="text-secondary">montant total</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if($caisses->isEmpty())
                                    <tr>
                                        <td colspan="2" class="text-center" style="font-size: 13px;">Aucun paiement trouvé.</td>
                                    </tr>
                                @else
                                    @foreach (['inscription', 'scolaire', 'transport'] as $type)
                                        @php
                                            $total = $caisses->firstWhere('type', $type);
                                        @endphp
                                        <tr>
                                            <td style="color:#B8B6B3">{{ ucfirst($type) === 'Scolaire' ? 'Scolarité' : ucfirst($type) }}</td>
                                            <td>{{ number_format(optional($total)->total_montant ?? 0, 2) }} DH</td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    <div>
                    <label class="mt-4 mb-2 text-secondary">Montant total de caisse : </label>
                    <input  type="text" class="form-control text-center fw-bold shadow-sm"
                        style="background-color:#F8F8F7; color: silver; border:none; font-weight:500 !important;"
                        value="{{ number_format($filteredTotal, 2) }} DH" disabled />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
