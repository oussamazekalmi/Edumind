<?php

namespace App\Http\Controllers;

use App\Models\Frais;
use Illuminate\Http\Request;

class CaisseController extends Controller {
    
    public function index(Request $request)
    {
        $month = $request->mois;
        $day = $request->day;

        $query = Frais::selectRaw('type, SUM(montant) as total_montant')
            ->groupBy('type');

        if ($month && !$day) {
            $query->whereRaw('DATE_FORMAT(date_paiement, "%Y-%m") = ?', [$month]);
        }
        if ($day) {
            $query->whereDate('date_paiement', $day);
        }
        $caisses = $query->get();

        if ($day) {
            $filteredTotal = Frais::whereDate('date_paiement', $day)->sum('montant');
        } elseif ($month) {
            $filteredTotal = Frais::whereRaw('DATE_FORMAT(date_paiement, "%Y-%m") = ?', [$month])->sum('montant');
        } else {
            $filteredTotal = Frais::sum('montant');
        }
        return view('admin.caisse', compact('caisses', 'filteredTotal', 'month', 'day'));
    }


    public function inscription(Request $request)
    {
        $month = $request->mois;
        $day = $request->day;

        $query = Frais::selectRaw('date_paiement, SUM(montant) as total_montant')
            ->where('type', 'inscription')
            ->groupBy('date_paiement')
            ->orderBy('date_paiement', 'desc');

        if ($month) {
            $query->whereRaw('DATE_FORMAT(date_paiement, "%Y-%m") = ?', [$month]);
        }
        if ($day) {
            $query->whereDate('date_paiement', $day);
        }
        $caisses = $query->get();
        if ($day) {
            $totalFiltered = Frais::where('type', 'inscription')
                ->whereDate('date_paiement', $day)
                ->sum('montant');
        } elseif ($month) {
            $totalFiltered = Frais::where('type', 'inscription')
                ->whereRaw('DATE_FORMAT(date_paiement, "%Y-%m") = ?', [$month])
                ->sum('montant');
        } else {
            $totalFiltered = Frais::where('type', 'inscription')->sum('montant');
        }

        return view('admin.inscription', compact('caisses', 'totalFiltered', 'month', 'day'));
    }

    public function scolaire(Request $request)
    {
        $month = $request->mois;
        $day = $request->day;
    
        $query = Frais::selectRaw('date_paiement, SUM(montant) as total_montant')
            ->where('type', 'scolaire')
            ->groupBy('date_paiement')
            ->orderBy('date_paiement', 'desc');
    
        if ($month) {
            $query->whereRaw('DATE_FORMAT(date_paiement, "%Y-%m") = ?', [$month]);
        }
        if ($day) {
            $query->whereRaw('DATE_FORMAT(date_paiement, "%Y-%m-%d") = ?', [$day]);
        }
        $caisses = $query->get();
    
        $dailyTotal = null;
        $monthlyTotals = null;
        if ($day) {
            $dailyTotal = Frais::where('type', 'scolaire')
                ->whereDate('date_paiement', $day)
                ->selectRaw('SUM(montant) as total_montant')
                ->first();
        } elseif ($month) {
            $monthlyTotals = Frais::where('type', 'scolaire')
                ->whereRaw('DATE_FORMAT(date_paiement, "%Y-%m") = ?', [$month])
                ->selectRaw('SUM(montant) as total_montant')
                ->get();
        }
        $totalGeneral = Frais::where('type', 'scolaire')->sum('montant');
        return view('admin.scolaire', compact('caisses', 'totalGeneral', 'month', 'day', 'dailyTotal', 'monthlyTotals'));
    }

    public function transport(Request $request)
    {
        $month = $request->mois;
        $day = $request->day;

        $query = Frais::selectRaw('date_paiement, SUM(montant) as total_montant')
            ->where('type', 'transport')
            ->groupBy('date_paiement')
            ->orderBy('date_paiement', 'desc');

        if ($month) {
            $query->whereRaw('DATE_FORMAT(date_paiement, "%Y-%m") = ?', [$month]);
        }
        if ($day) {
            $query->whereRaw('DATE_FORMAT(date_paiement, "%Y-%m-%d") = ?', [$day]);
        }
        $caisses = $query->get();
        $dailyTotal = null;
        $monthlyTotals = null;

        if ($day) {
            $dailyTotal = Frais::where('type', 'transport')
                ->whereDate('date_paiement', $day)
                ->selectRaw('SUM(montant) as total_montant')
                ->first();
        } elseif ($month) {
            $monthlyTotals = Frais::where('type', 'transport')
                ->whereRaw('DATE_FORMAT(date_paiement, "%Y-%m") = ?', [$month])
                ->selectRaw('SUM(montant) as total_montant')
                ->get();
        }
        $totalGeneral = Frais::where('type', 'transport')->sum('montant');
        return view('admin.transport', compact('caisses', 'totalGeneral', 'month', 'day', 'dailyTotal', 'monthlyTotals'));
    }
}