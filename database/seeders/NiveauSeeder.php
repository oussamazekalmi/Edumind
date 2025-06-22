<?php

namespace Database\Seeders;

use App\Models\Niveau;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1;$i<=12;$i++) {
            if($i<=6) {
                Niveau::create([
                    "nom" => "CP".$i,
                    "id_cycle" => 1
                ]);
            }

            if($i > 6 && $i <= 9) {
                Niveau::create([
                    "nom" =>"CC".$i - 6,
                    "id_cycle" => 2
                ]);
            }

            if($i > 9) {
                Niveau::create([
                    "nom" => "CL".$i - 9,
                    "id_cycle" => 3
                ]);
            }
        }
    }
}
