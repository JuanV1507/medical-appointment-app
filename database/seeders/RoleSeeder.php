<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Definir los roles
        $roles = [
            'Paciente',
            'Doctor', 
            'Recepcionista',
            'Administrador',
            'Super administrador'
        ];
        //Insertar los roles en la base de datos
        foreach ($roles as $role) {
            Role::create
            (['name' => $role]);
    }
}
}