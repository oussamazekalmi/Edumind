<?php

namespace Database\Seeders;

use App\Models\Cycle;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cycle::create([
            "nom"=>"Primaire",
            "montant_inscription"=>1000.00
        ]);
        Cycle::create([
            "nom"=>"College",
            "montant_inscription"=>2000.00
        ]);
        Cycle::create([
            "nom"=>"Lycee",
            "montant_inscription"=>3000.00
        ]);
    }
}
