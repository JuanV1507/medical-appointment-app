<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { background-color: #3498db; color: white; padding: 10px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nueva Cita Agendada</h2>
        </div>
        <div class="content">
            <p>Hola,</p>
            <p>Se ha registrado una nueva cita médica con los siguientes detalles:</p>
            <ul>
                <li><strong>Paciente:</strong> {{ $appointment->patient->user->name }}</li>
                <li><strong>Doctor:</strong> {{ $appointment->doctor->user->name }}</li>
                <li><strong>Fecha:</strong> {{ $appointment->date }}</li>
                <li><strong>Hora:</strong> {{ $appointment->start_time }}</li>
            </ul>
            <p>Se adjunta el comprobante en formato PDF.</p>
            <p>Saludos,<br>Equipo de Healthify</p>
        </div>
    </div>
</body>
</html>
