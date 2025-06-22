<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // création d'un utilisateur de type directrice

        User::create([
            'nom'=>'el rhazzali',
            'prenom'=>'yassine',
            'email'=>'devyassine55@gmail.com',
            'cin'=>'F34567',
            'role'=>'directrice',
            'genre'=>'male',
            'password'=>Hash::make('yassine01')
        ]);
        // User::create([
        //     'nom'=>'marzouk',
        //     'prenom'=>'fatima',
        //     'email'=>'fatima02@gmail.com',
        //     'cin'=>'EE123456',
        //     'role'=>'directrice',
        //     'genre'=>'male',
        //     'password'=>Hash::make('fatima02')
        // ]);

        // // création d'un utilisateur de type secretaire
        // User::create([
        //     'nom'=>'atmani',
        //     'prenom'=>'zienb',
        //     'email'=>'zienb123@gmail.com',
        //     'cin'=>'F455781',
        //     'role'=>'secretaire',
        //     'genre'=>'male',
        //     'password'=>Hash::make('zienb123')
        // ]);
    }
}
