<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EleveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('eleves')->insert([
            [
                'nom' => 'Ahmed',
                'prenom' => 'Ali',
                'age' => 18,
                'genre' => 'male',
                'cne' => Str::random(10),
                'cin' => Str::random(8),
                'filiere' => 'Informatique',
                'branche' => 'Développement',
                'date_inscription' => now(),
                'date_abandon' => null,
                'date_naissance' => '2006-05-12',
                'lieu_naissance' => 'Casablanca',
                'adresse' => '123 Rue des Ecoles',
                'tel' => '0601020304',
                'statut' => 'en_cours',
                'nom_responsable' => 'Mohamed Ali',
                'statut_responsable' => 'Père',
                'tel_responsable' => '0605060708',
                'profession_responsable' => 'Ingénieur',
                'a_transport' => true,
                'id_classe' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nom' => 'Fatima',
                'prenom' => 'Zahra',
                'age' => 17,
                'genre' => 'female',
                'cne' => Str::random(10),
                'cin' => Str::random(8),
                'filiere' => 'Sciences',
                'branche' => 'Physique',
                'date_inscription' => now(),
                'date_abandon' => null,
                'date_naissance' => '2007-03-22',
                'lieu_naissance' => 'Rabat',
                'adresse' => '456 Avenue des Lumières',
                'tel' => '0611121314',
                'statut' => 'en_cours',
                'nom_responsable' => 'Amina Zahra',
                'statut_responsable' => 'Mère',
                'tel_responsable' => '0622232425',
                'profession_responsable' => 'Médecin',
                'a_transport' => false,
                'id_classe' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
