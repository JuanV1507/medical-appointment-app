<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Mail\AppointmentCreatedMail;
use App\Services\WhatsAppService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AppointmentObserver
{
    public function __construct(protected WhatsAppService $whatsapp) {}

    /**
     * Se ejecuta después de que una cita es creada.
     */
    public function created(Appointment $appointment)
    {
        // 1. Generar PDF (Independiente)
        $pdfContent = null;
        try {
            $pdf = Pdf::loadView('pdf.appointment_voucher', compact('appointment'));
            $pdfContent = $pdf->output();
        } catch (\Exception $e) {
            Log::error("Error generando PDF: " . $e->getMessage());
        }

        // 2. Enviar Correo al Paciente (Independiente)
        try {
            if ($appointment->patient->user->email && $pdfContent) {
                Mail::to($appointment->patient->user->email)->send(new AppointmentCreatedMail($appointment, $pdfContent));
            }
        } catch (\Exception $e) {
            Log::error("Error correo paciente: " . $e->getMessage());
        }

        // 3. Enviar Correo al Doctor (Independiente)
        try {
            if ($appointment->doctor->user->email && $pdfContent) {
                Mail::to($appointment->doctor->user->email)->send(new AppointmentCreatedMail($appointment, $pdfContent));
            }
        } catch (\Exception $e) {
            Log::error("Error correo doctor: " . $e->getMessage());
        }

        // 4. Enviar WhatsApp al Paciente (Independiente)
        try {
            if ($appointment->patient->user->phone) {
                $this->whatsapp->sendTemplateMessage(
                    $appointment->patient->user->phone,
                    'confirmacion_cita',
                    [
                        [
                            'type' => 'body',
                            'parameters' => [
                                ['type' => 'text', 'text' => $appointment->patient->user->name],
                                ['type' => 'text', 'text' => $appointment->date],
                                ['type' => 'text', 'text' => $appointment->start_time],
                                ['type' => 'text', 'text' => $appointment->doctor->user->name],
                            ]
                        ]
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error("Error WhatsApp: " . $e->getMessage());
        }
    }
}
