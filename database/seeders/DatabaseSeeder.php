<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ClassSeeder;
use Database\Seeders\CycleSeeder;
use Database\Seeders\NiveauSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            CycleSeeder::class,
            NiveauSeeder::class,
            ClassSeeder::class
        ]);
    }
}
