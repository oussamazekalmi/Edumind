<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    protected $fillable = ['nom', 'montant_inscription', 'montant_transport'];

    public function niveaux()
    {
        return $this->hasMany(Niveau::class, 'id_cycle');
    }
}
