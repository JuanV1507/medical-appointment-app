<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;

class DoctorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::role('Doctor')->get();
        
        foreach ($users as $user) {
            Doctor::firstOrCreate(
                ['user_id' => $user->id],
                ['specialty' => 'Medicina General']
            );
        }
    }
}
