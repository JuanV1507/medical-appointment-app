<?php

namespace App\Mail;

use App\Models\Doctor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DailyDoctorReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Doctor $doctor, public Collection $appointments) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu Lista de Pacientes de Hoy - ' . now()->format('d/m/Y'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.daily_doctor_report',
        );
    }
}
