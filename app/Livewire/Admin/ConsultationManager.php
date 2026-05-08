<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Appointment;

class ConsultationManager extends Component
{
    public Appointment $appointment;
    public $activeTab = 'consulta'; // 'consulta' or 'receta'
    public $showHistoryModal = false;
    public $showPastConsultationsModal = false;

    // Consulta fields
    public $diagnosis = '';
    public $treatment = '';
    public $notes = '';

    // Receta fields
    public $medications = [];
    public $newMedication = ['name' => '', 'dose' => '', 'frequency' => ''];

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->appointment->load('patient.user', 'doctor.user');
        
        // Cargar historia si ya existe (podríamos guardarla en reason o en tablas aparte,
        // pero por simplicidad el prompt no pide tablas de Consultation y Prescription,
        // aunque lo lógico sería crearlas. Vamos a simularlo o guardarlo en la cita).
        // Como no se pide crear tablas, guardaremos un JSON en notes/reason o asumiremos
        // que se guardan en alguna parte.
        // Wait! The prompt says "diseña una interfaz...". Let's just create properties for now.
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function addMedication()
    {
        $this->validate([
            'newMedication.name' => 'required|string',
            'newMedication.dose' => 'required|string',
            'newMedication.frequency' => 'required|string',
        ]);

        $this->medications[] = $this->newMedication;
        $this->newMedication = ['name' => '', 'dose' => '', 'frequency' => ''];
    }

    public function removeMedication($index)
    {
        unset($this->medications[$index]);
        $this->medications = array_values($this->medications);
    }

    public function saveConsultation()
    {
        $this->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'required|string',
        ]);

        // Aquí iría la lógica para guardar en base de datos.
        $this->appointment->status = 2; // Atendida
        $this->appointment->diagnosis = $this->diagnosis;
        $this->appointment->treatment = $this->treatment;
        $this->appointment->notes = $this->notes;
        
        $this->appointment->save();

        session()->flash('message', 'Consulta guardada correctamente.');
        return redirect()->route('admin.appointments');
    }

    public function render()
    {
        // Simular historial clínico (consultas anteriores del paciente)
        $pastConsultations = Appointment::where('patient_id', $this->appointment->patient_id)
            ->where('id', '!=', $this->appointment->id)
            ->where('status', 2)
            ->orderBy('date', 'desc')
            ->get();

        return view('livewire.admin.consultation-manager', [
            'pastConsultations' => $pastConsultations
        ])->layout('layouts.admin');
    }
}
