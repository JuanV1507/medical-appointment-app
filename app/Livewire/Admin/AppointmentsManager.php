<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class AppointmentsManager extends Component
{
    public $isCreating = false;

    // Form fields
    public $patient_id;
    public $doctor_id;
    public $date;
    public $start_time;
    public $end_time;
    public $reason;

    protected $rules = [
        'patient_id' => 'required|exists:patients,id',
        'doctor_id' => 'required|exists:doctors,id',
        'date' => 'required|date|after_or_equal:today',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'reason' => 'nullable|string',
    ];

    public function create()
    {
        $this->resetFields();
        $this->isCreating = true;
    }

    public function cancel()
    {
        $this->isCreating = false;
    }

    public function save()
    {
        $this->validate();

        Appointment::create([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'duration' => 15,
            'reason' => $this->reason,
            'status' => 1,
        ]);

        session()->flash('message', 'Cita registrada con éxito.');

        $this->isCreating = false;
        $this->resetFields();
    }

    private function resetFields()
    {
        $this->patient_id = '';
        $this->doctor_id = '';
        $this->date = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->reason = '';
    }

    public function render()
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])->orderBy('date')->orderBy('start_time')->get();
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();

        return view('livewire.admin.appointments-manager', [
            'appointments' => $appointments,
            'patients' => $patients,
            'doctors' => $doctors,
        ])->layout('layouts.admin'); // Using the correct admin layout
    }
}
