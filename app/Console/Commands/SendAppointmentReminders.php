<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios de WhatsApp a los pacientes con citas para mañana';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $whatsapp)
    {
        $tomorrow = Carbon::tomorrow()->toDateString();
        
        $appointments = Appointment::with('patient.user')
            ->where('date', $tomorrow)
            ->where('status', 1) // Asumiendo 1 es Confirmada
            ->get();

        $this->info("Encontradas " . $appointments->count() . " citas para mañana.");

        foreach ($appointments as $appointment) {
            if ($appointment->patient->user->phone) {
                $whatsapp->sendTemplateMessage(
                    $appointment->patient->user->phone,
                    'recordatorio_cita', // Nombre de la plantilla en Meta
                    [
                        [
                            'type' => 'body',
                            'parameters' => [
                                ['type' => 'text', 'text' => $appointment->patient->user->name],
                                ['type' => 'text', 'text' => $appointment->date],
                                ['type' => 'text', 'text' => $appointment->start_time],
                            ]
                        ]
                    ]
                );
                $this->info("Recordatorio enviado a: " . $appointment->patient->user->name);
            }
        }

        $this->info("Proceso de recordatorios finalizado.");
    }
}
