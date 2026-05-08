<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Mail\DailyAdminReportMail;
use App\Mail\DailyDoctorReportMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDailyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía reportes diarios de citas al administrador y a cada doctor';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();
        $adminEmail = 'chanvazquezjuanmanuel@gmail.com';

        // 1. Reporte para el Administrador
        $allAppointments = Appointment::with(['patient.user', 'doctor.user'])
            ->where('date', $today)
            ->get();

        Mail::to($adminEmail)->send(new DailyAdminReportMail($allAppointments));
        $this->info("Reporte general enviado al administrador.");

        // 2. Reportes para cada Doctor
        $doctors = Doctor::whereHas('appointments', function($query) use ($today) {
            $query->where('date', $today);
        })->with('user')->get();

        foreach ($doctors as $doctor) {
            if ($doctor->user->email) {
                $doctorAppointments = Appointment::with('patient.user')
                    ->where('doctor_id', $doctor->id)
                    ->where('date', $today)
                    ->get();

                Mail::to($doctor->user->email)->send(new DailyDoctorReportMail($doctor, $doctorAppointments));
                $this->info("Reporte enviado al doctor: " . $doctor->user->name);
            }
        }

        $this->info("Proceso de reportes finalizado.");
    }
}
