<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Doctor;

class DoctorsManager extends Component
{
    public function render()
    {
        $doctors = Doctor::with('user')->paginate(10);
        return view('livewire.admin.doctors-manager', [
            'doctors' => $doctors
        ])->layout('layouts.admin');
    }
}
