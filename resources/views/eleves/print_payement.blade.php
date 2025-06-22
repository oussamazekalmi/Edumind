@extends('layout.master')

@php
    $randomNumbers = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
    $prenomPL = strtoupper(substr($paiement->eleve->prenom, 0, 1));
    $nomPL = strtoupper(substr($paiement->eleve->nom, 0, 1));
    $docName = "N°{$randomNumbers}{$prenomPL}{$nomPL}";
@endphp

@section('title')
    Imprimer Paiement {{ $docName }}
@endsection

<style>
    table {
        width: auto;
        border-collapse: collapse;
        color: gray;
    }

    td {
        padding-left: 3.5rem;
    }

    tr {
        height: 2.4rem;
    }

    .footer {
        display: none;
        visibility: hidden;
    }
</style>

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-title">
        <div class="container">
            <div class="card shadow-sm rounded-0 px-5 py-4" style="background-color:white; width:60%; margin:0 auto; color:gray;">
                <p class="d-flex justify-content-between">
                    <span>
                        OUJDA, Le {{ Carbon\Carbon::now()->format('d-m-Y') }} </br>
                        À {{ Carbon\Carbon::now()->format('h:i') }}
                    </span>
                    <span>
                        @php
                            $start = Carbon\Carbon::parse($paiement->interval_debut);
                            $end = Carbon\Carbon::parse($paiement->interval_fin);

                            $months = [
                                'January' => 'Janvier', 'February' => 'Février', 'March' => 'Mars',
                                'April' => 'Avril', 'May' => 'Mai', 'June' => 'Juin',
                                'July' => 'Juillet', 'August' => 'Août', 'September' => 'Septembre',
                                'October' => 'Octobre', 'November' => 'Novembre', 'December' => 'Décembre'
                            ];

                            $startMonth = $months[$start->format('F')];
                            $endMonth = $months[$end->format('F')];

                            $startYear = $start->year;

                            $academicYear = $start->month >= 9 ?
                                $start->year . ' / ' . ($start->year + 1) :
                                ($start->year - 1) . ' / ' . $start->year;
                        @endphp
                        Année scolaire <span style="font-weight:600;">{{ $academicYear }}</span> <br/>
                        <span style="margin-right: 52px;">Groupe</span> <span style="font-weight:600;">{{ $paiement->eleve->classe->nom }}</span>
                    </span>
                </p>
                <h6 class="text-center mt-5" style="font-weight:500; font-size: 12px;">VERSEMENT EN ESPÈCES À L'ÉTABLISSEMENT</h6>
                <div class="mb-5 mt-5">
                    <table style="font-size: 12px;">
                        <tr>
                            <td>Numéro inscription:</td>
                            <td>{{ $paiement->eleve->num_inscription }}</td>
                        </tr>
                        <tr>
                            <td>Nom élève:</td>
                            <td>{{ $paiement->eleve->nom }} {{ $paiement->eleve->prenom }}</td>
                        </tr>
                        <tr>
                            <td>Type de Frais:</td>
                            <td>{{ ucfirst($paiement->type) === 'Scolaire' ? 'Scolarité' : ucfirst($paiement->type) }}</td>
                        </tr>
                        @if (!empty($paiement->frequence_paiement))
                            <tr>
                                <td>Fréquence de Paiement:</td>
                                <td>{{ $paiement->frequence_paiement }}</td>
                            </tr>
                        @endif
                        @if (!empty($paiement->mode_paiement))
                            <tr>
                                <td>Mode de Paiement:</td>
                                <td>{{ $paiement->mode_paiement }}</td>
                            </tr>
                        @endif

                        @php
                            $type = strtolower($paiement->type);
                            $isInscription = $type === 'inscription';
                            $isPartiel = $paiement->statut === 'partiel';
                        @endphp
                        <tr>
                            <td>Montant payé:</td>
                            <td>{{ number_format($montantPaiement, 2) }} DH</td>
                        </tr>
                        @if($from === 'update' && $isPartiel && $isInscription && $restantUpdate > 0)
                            <tr>
                                <td>Montant restant:</td>
                                <td>{{ number_format($restantUpdate, 2) }} DH</td>
                            </tr>
                        @endif
                        @if($from === 'add' && $isPartiel && $isInscription && $restantAdd > 0)
                            <tr>
                                <td>Montant restant:</td>
                                <td>{{ number_format($restantAdd, 2) }} DH</td>
                            </tr>
                        @endif

                        <tr>
                            <td>Date de Paiement:</td>
                            <td>{{ 'Le ' . \Carbon\Carbon::parse($paiement->date_paiement)->locale('fr')->isoFormat('D MMMM Y') }}</td>
                        </tr>
                        @if (!empty($start) && !empty($end))
                            <tr>
                                <td>Période de Paiement:</td>
                                <td>
                                    @if($start->year === $end->year)
                                        @if($start->month === $end->month)
                                            {{ $startMonth }} {{ $start->year }}
                                        @else
                                            {{ $startMonth }} -- {{ $endMonth }} {{ $start->year }}
                                        @endif
                                    @else
                                        {{ $startMonth }} {{ $start->year }} -- {{ $endMonth }} {{ $end->year }}
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="d-flex justify-content-between mt-5">
                    <button onclick="printPayment()" class="shadow-sm border-0"
                            style="padding: 10px 20px; background-color:#f8f9fa; color:#020227;">
                        Imprimer
                    </button>
                    <a href="{{ $from === 'add' ? route('paiements.traiter', $paiement->eleve->id) : route('paiements.liste', $paiement->eleve->id) }}"
                        class="shadow-sm border-0" style="padding: 10px 20px; background-color:#f4f5f6; color:#020227;">
                        Annuler
                    </a>
                </div>
                <iframe id="print-frame" style="display: none;"></iframe>
            </div>
        </div>
      </div>
    </div>
</div>

@php
    $randomDigits = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
    $prenomInitial = strtoupper(substr($paiement->eleve->prenom, 0, 1));
    $nomInitial = strtoupper(substr($paiement->eleve->nom, 0, 1));
    $serialNumber = "N°{$randomDigits}{$prenomInitial}{$nomInitial}";
@endphp

<script>
    function printPayment() {

        const logoBase64 = @json($logoBase64);
        const academicYear = @json($academicYear);
        const className = @json($paiement->eleve->classe->nom);
        const nowDate = "{{ \Carbon\Carbon::now()->format('d/m/Y') }}";
        const nowTime = "{{ \Carbon\Carbon::now()->format('H:i') }}";
        const serialNumber = @json($serialNumber);
        const thankMessageFr = "Merci pour votre confiance et votre fidélité envers notre établissement";
        const thankMessageAr = "شكرًا لثقتكم ووفائكم لمؤسستنا التعليمية";

        var content = `
            <html>
                <head>
                    <style>
                        @media print {
                            @page {
                                margin: 0;
                            }
                            body {
                                margin: 1.5cm;
                            }
                        }

                        body {
                            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
                            font-size: small;
                            font-weight: 500;
                        }

                        .card {
                            margin: 0 auto;
                            margin-bottom: 6cm;
                            color: lightgray;
                            border-radius: 0;
                        }

                        .d-flex {
                            display: flex;
                        }

                        .justify-content-between {
                            justify-content: space-between;
                        }

                        .text-center {
                            text-align: center;
                        }

                        table {
                            width: 90%;
                            border-collapse: collapse;
                            margin: 0 4rem;
                        }

                        td {
                            font-weight: 600;
                            color: #A9A9A9;
                        }

                        .td {
                            padding-left: 6rem;
                            font-weight: 600;
                            color: lightgray;
                        }

                        tr {
                            height: 3rem;
                        }

                        .mt-3 {
                            margin-top: 1rem;
                        }

                        .my-3 {
                            margin: 1rem 0;
                        }

                        h6 {
                            font-size: 18px;
                            font-weight: 600;
                            margin: 3rem auto;
                        }

                        .text-signature {
                            margin-top: 1.5rem !important;
                            font-size: medium;
                            font-weight: 600;
                            color: lightgray;
                        }

                        footer {
                            position: fixed;
                            bottom: 6%;
                            left: 0;
                            right: 0;
                            height: 5cm;
                            padding: 1rem 2cm;
                            background: white;
                        }
                    </style>
                </head>
                <body style="position:relative;">
                    <div class="card shadow-sm rounded-0 px-0 pt-5 py-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <p>OUJDA, Le ${nowDate}</p>
                                <p>À ${nowTime}</p>
                            </div>
                            <div>
                                <img id="print-logo" src="${logoBase64}" alt="Logo" height="200">
                            </div>
                            <div>
                                <p>Année scolaire <strong>${academicYear}</strong></p>
                                <p><span style="margin-right: 52px;">Groupe</span> </strong>{{ $paiement->eleve->classe->nom }}</strong></p>
                            </div>
                        </div>
                        <h6 class="text-center mt-4">VERSEMENT EN ESPÈCES À L'ÉTABLISSEMENT</h6>
                        <table>
                            <tr>
                                <td>Numéro inscription</td>
                                <td class="td">{{ $paiement->eleve->num_inscription }}</td>
                            </tr>
                            <tr>
                                <td>Nom élève</td>
                                <td class="td">{{ $paiement->eleve->nom }} {{ $paiement->eleve->prenom }}</td>
                            </tr>
                            <tr>
                                <td>Type de Frais</td>
                                <td class="td">{{ ucfirst($paiement->type) === 'Scolaire' ? 'Scolarité' : ucfirst($paiement->type) }}</td>
                            </tr>
                            @if (!empty($paiement->frequence_paiement))
                                <tr>
                                    <td>Fréquence de Paiement</td>
                                    <td class="td">{{ $paiement->frequence_paiement }}</td>
                                </tr>
                            @endif
                            @if (!empty($paiement->mode_paiement))
                                <tr>
                                    <td>Mode de Paiement</td>
                                    <td class="td">{{ $paiement->mode_paiement }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Montant payé:</td>
                                <td class="td">{{ number_format($montantPaiement, 2) }} DH</td>
                            </tr>
                            @if($from === 'update' && $isPartiel && $isInscription && $restantUpdate > 0)
                                <tr>
                                    <td>Montant restant:</td>
                                    <td class="td">{{ number_format($restantUpdate, 2) }} DH</td>
                                </tr>
                            @endif
                            @if($from === 'add' && $isPartiel && $isInscription && $restantAdd > 0)
                                <tr>
                                    <td>Montant restant:</td>
                                    <td class="td">{{ number_format($restantAdd, 2) }} DH</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Date de Paiement</td>
                                <td class="td">{{ 'Le ' . \Carbon\Carbon::parse($paiement->date_paiement)->locale('fr')->isoFormat('D MMMM Y') }}</td>
                            </tr>
                            @if (!empty($start) && !empty($end))
                                <tr>
                                    <td>Période de Paiement</td>
                                    <td class="td">
                                        @if($start->year === $end->year)
                                            @if($start->month === $end->month)
                                                {{ $startMonth }} {{ $start->year }}
                                            @else
                                                {{ $startMonth }} -- {{ $endMonth }} {{ $start->year }}
                                            @endif
                                        @else
                                            {{ $startMonth }} {{ $start->year }} -- {{ $endMonth }} {{ $end->year }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <footer>
                        <div class="d-flex justify-content-between text-signature">
                            <p>Signature du Remettant</p>
                            <p style="margin-right: 12px; text-align: center;">Signature du Caissier <br/> Et Cachet de l'école</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div style="border:1px solid gray; height:5rem; width:11rem;"></div>
                            <div style="border:1px solid gray; height:5rem; width:11rem;"></div>
                        </div>
                        <div class="d-flex justify-content-between mb-3" style="margin-top: 1rem; font-size: 13px; color: gray;">
                            <p><span>${thankMessageFr}</span> <br/> ${thankMessageAr}</p>
                            <p><strong>${serialNumber}</strong></p>
                        </div>
                    </footer>
                </body>
            </html>
        `;

        const iframe = document.getElementById('print-frame');
        const doc = iframe.contentWindow.document;

        doc.open();
        doc.write(content);
        doc.close();

        iframe.onload = function () {
            const logo = doc.getElementById('print-logo');
            if (logo && !logo.complete) {
                logo.onload = () => {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                };
            } else {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            }

            iframe.contentWindow.onafterprint = function () {
                doc.body.innerHTML = '';
            };
        };
    }
</script>

@endsection
