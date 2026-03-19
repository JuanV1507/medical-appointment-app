<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Crear usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('12341234'),
            'id_number' => '123456789',
            'phone' => '999999999',
            'address' => 'Test Address',
            
        ])->assignRole('Administrador'); // Asignar el rol de Admin al usuario creado
    }
}
