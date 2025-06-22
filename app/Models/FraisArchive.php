<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FraisArchive extends Model
{
    use HasFactory;

    protected $table = 'frais_archives';

    protected $fillable = [
        'type', 'montant', 'mode_paiement', 'date_paiement',
        'frequence_paiement', 'interval_debut', 'interval_fin',
        'statut', 'année', 'id_eleve', 'id_user'
    ];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'id_eleve');
    }

    public function scopeFilterByAcademicYear($query, $academicYear)
    {
        $startDate = "$academicYear-09-01";
        $endDate = ($academicYear + 1) . "-07-31";

        return $query->whereBetween('date_paiement', [$startDate, $endDate]);
    }

    public function scopeSearchByStudentName($query, $searchTerm)
    {
        return $query->whereHas('eleve', function ($q) use ($searchTerm) {
            $q->where('nom', 'LIKE', "%$searchTerm%")
              ->orWhere('prenom', 'LIKE', "%$searchTerm%");
        });
    }
}