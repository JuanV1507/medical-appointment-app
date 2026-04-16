<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void

    {

    // Llamar al seeder de roles
        $this->call(RoleSeeder::class);
    // Llamar al seeder de usuarios
        $this->call(UserSeeder::class);

    // Llamar al seeder de tipos de sangre
        $this->call(BloodTypeSeeder::class);
        
        // Crea usuario de prueba cada que se ejecuten las migraciones
    }
}
