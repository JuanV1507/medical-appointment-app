<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class AppointmentsManager extends Component
{
    public $isCreating = false;

    // Search fields
    public $searchDate;
    public $searchStartTime = '08:00';
    public $searchEndTime = '18:00';
    public $searchSpecialty;
    public $availableDoctors = [];
    public $specialties = [];

    // Selected Appointment Info
    public $selectedDoctorId;
    public $selectedDoctorName;
    public $selectedDate;
    public $selectedStartTime;
    public $selectedEndTime;

    // Form fields
    public $patient_id;
    public $reason;

    protected $rules = [
        'patient_id' => 'required|exists:patients,id',
        'selectedDoctorId' => 'required|exists:doctors,id',
        'selectedDate' => 'required|date|after_or_equal:today',
        'selectedStartTime' => 'required|date_format:H:i',
        'selectedEndTime' => 'required|date_format:H:i|after:selectedStartTime',
        'reason' => 'required|string',
    ];

    public function mount()
    {
        $this->searchDate = now()->addDay()->format('Y-m-d');
        $this->specialties = Doctor::select('specialty')->distinct()->pluck('specialty')->filter()->toArray();
    }

    public function create()
    {
        $this->resetFields();
        $this->isCreating = true;
    }

    public function cancel()
    {
        $this->isCreating = false;
        $this->availableDoctors = [];
    }

    public function searchAvailability()
    {
        $this->validate([
            'searchDate' => 'required|date|after_or_equal:today',
            'searchStartTime' => 'required|date_format:H:i',
            'searchEndTime' => 'required|date_format:H:i|after:searchStartTime',
        ]);

        $query = Doctor::with('user');
        
        if ($this->searchSpecialty) {
            $query->where('specialty', $this->searchSpecialty);
        }

        $doctors = $query->get();

        // Para simular disponibilidad en el demo, simplemente mostramos a los doctores con slots generados.
        // En un caso real, aquí cruzaríamos con las citas existentes.
        
        $results = [];
        foreach ($doctors as $doctor) {
            $results[] = [
                'doctor' => $doctor,
                'slots' => [
                    $this->searchStartTime,
                    \Carbon\Carbon::parse($this->searchStartTime)->addHours(1)->format('H:i'),
                    \Carbon\Carbon::parse($this->searchStartTime)->addHours(2)->format('H:i'),
                ]
            ];
        }

        $this->availableDoctors = collect($results);
    }

    public function selectTimeSlot($doctorId, $doctorName, $time)
    {
        $this->selectedDoctorId = $doctorId;
        $this->selectedDoctorName = $doctorName;
        $this->selectedDate = $this->searchDate;
        $this->selectedStartTime = $time;
        $this->selectedEndTime = \Carbon\Carbon::parse($time)->addMinutes(15)->format('H:i');
    }

    public function save()
    {
        $this->validate();

        Appointment::create([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->selectedDoctorId,
            'date' => $this->selectedDate,
            'start_time' => $this->selectedStartTime,
            'end_time' => $this->selectedEndTime,
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
        $this->selectedDoctorId = null;
        $this->selectedDoctorName = null;
        $this->selectedDate = null;
        $this->selectedStartTime = null;
        $this->selectedEndTime = null;
        $this->reason = '';
        $this->availableDoctors = [];
    }

    public function render()
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])->orderBy('date')->orderBy('start_time')->get();
        $patients = Patient::with('user')->get();

        return view('livewire.admin.appointments-manager', [
            'appointments' => $appointments,
            'patients' => $patients,
        ])->layout('layouts.admin');
    }
}
