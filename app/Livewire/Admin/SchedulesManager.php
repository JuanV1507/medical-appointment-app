<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SchedulesManager extends Component
{
    public \App\Models\Doctor $doctor;
    public $days = ['LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES'];
    public $hours = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00'];
    
    // Array para almacenar los slots seleccionados
    public $selectedSlots = [];
    public $selectAll = [];

    public function mount(\App\Models\Doctor $doctor)
    {
        $this->doctor = $doctor;
        // Inicializar array
        foreach($this->days as $day) {
            foreach($this->hours as $hour) {
                $this->selectAll[$day][$hour] = false;
                for($i=0; $i<4; $i++) {
                    $start = \Carbon\Carbon::parse($hour)->addMinutes($i * 15)->format('H:i');
                    $this->selectedSlots[$day][$hour][$start] = false;
                }
            }
        }
    }

    public function toggleAll($day, $hour)
    {
        $isChecked = $this->selectAll[$day][$hour];
        for($i=0; $i<4; $i++) {
            $start = \Carbon\Carbon::parse($hour)->addMinutes($i * 15)->format('H:i');
            $this->selectedSlots[$day][$hour][$start] = $isChecked;
        }
    }

    public function save()
    {
        // Aquí iría la lógica de guardado en la base de datos
        // Por ahora simulamos que se guarda
        session()->flash('message', 'Horarios guardados correctamente para ' . ($this->doctor->user->name ?? 'el doctor') . '.');
        return redirect()->route('admin.doctors.index');
    }

    public function render()
    {
        return view('livewire.admin.schedules-manager')->layout('layouts.admin');
    }
}
