<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    protected $fillable = [
        'num_inscription', 'nom', 'prenom', 'genre', 'cne', 'cin',
        'date_naissance', 'lieu_naissance', 'date_inscription', 'adresse', 'statut',
        'statut_familial', 'statut_responsable', 'statut_autre', 'nom_responsable', 'tel_responsable', 'nom_pere', 'nom_mere',
        'tel_pere', 'tel_mere', 'profession_pere', 'profession_mere', 'transport_discount', 'discount', 'annee_obtention_bac', 'annee_academique', 'id_classe', 'a_transport', 'isreussit'
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'id_classe');
    }

    public function frais()
    {
        return $this->hasMany(Frais::class, 'id_eleve');
    }
}