<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Frais extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'type', 'montant', 'mode_paiement', 'date_paiement',
        'frequence_paiement', 'interval_debut', 'interval_fin', 'statut',
        'annee', 'id_eleve', 'id_user',
    ];

    protected $casts = [
        'date_paiement' => 'datetime', 
    ];

    protected $dates = ['deleted_at'];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'id_eleve');
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}