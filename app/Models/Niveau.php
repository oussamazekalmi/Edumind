<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    protected $fillable = ['nom', 'id_cycle', 'montant_scolarite'];

    public function cycle()
    {
        return $this->belongsTo(Cycle::class, 'id_cycle');
    }

    public function classes()
    {
        return $this->hasMany(Classe::class, 'id_niveau');
    }

}
