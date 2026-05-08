<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected ?string $token;
    protected ?string $instanceId;

    public function __construct()
    {
        $this->token = config('services.whatsapp.token');
        $this->instanceId = config('services.whatsapp.instance_id');
    }

    /**
     * Envía un mensaje por WhatsApp utilizando UltraMsg.
     */
    public function sendTemplateMessage(string $to, string $templateName, array $components = [], string $language = 'es')
    {
        // Convertimos los componentes en un texto legible para UltraMsg (Modo Chat)
        $body = $this->buildMessageBody($templateName, $components);

        if (empty($this->token) || empty($this->instanceId) || str_contains($this->token, 'token')) {
            Log::info("SIMULACIÓN WHATSAPP (UltraMsg): Enviando a {$to}. Mensaje: {$body}");
            return ['simulated' => true];
        }

        $url = "https://api.ultramsg.com/{$this->instanceId}/messages/chat";

        try {
            $response = Http::withoutVerifying()->asForm()->post($url, [
                'token' => $this->token,
                'to'    => $to, // Usamos el número tal cual viene (con + si lo tiene)
                'body'  => $body,
            ]);

            Log::info("UltraMsg Response: " . $response->body());

            if ($response->failed()) {
                Log::error("UltraMsg API Error: " . $response->body());
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error("UltraMsg Exception: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Construye un cuerpo de mensaje amigable basado en la "plantilla" solicitada.
     */
    protected function buildMessageBody(string $templateName, array $components): string
    {
        $params = $components[0]['parameters'] ?? [];
        $values = array_column($params, 'text');

        if ($templateName === 'confirmacion_cita') {
            return "✅ *Confirmación de Cita*\n\nHola " . ($values[0] ?? 'Paciente') . ",\nSu cita ha sido agendada para el día *" . ($values[1] ?? '') . "* a las *" . ($values[2] ?? '') . "* con el Dr. " . ($values[3] ?? '') . ".\n\n¡Gracias por confiar en Healthify!";
        }

        if ($templateName === 'recordatorio_cita') {
            return "⏰ *Recordatorio de Cita*\n\nHola " . ($values[0] ?? 'Paciente') . ",\nLe recordamos que tiene una cita mañana *" . ($values[1] ?? '') . "* a las *" . ($values[2] ?? '') . "*.\n\nPor favor, llegue 10 minutos antes.";
        }

        return "Notificación de Healthify: " . implode(', ', $values);
    }

    /**
     * Asegura que el número tenga el formato internacional sin + ni espacios.
     */
    protected function formatPhoneNumber(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }
}
