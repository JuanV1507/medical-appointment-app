<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SchedulesManager extends Component
{
    public function render()
    {
        return view('livewire.admin.schedules-manager')->layout('layouts.admin');
    }
}
