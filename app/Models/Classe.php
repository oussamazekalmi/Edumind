<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = ['nom', 'id_niveau'];
    
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'id_niveau');
    }

    public function eleves()
    {
        return $this->hasMany(Eleve::class, 'id_classe');
    }

}