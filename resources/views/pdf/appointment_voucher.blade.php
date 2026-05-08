<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Cita Médica</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .content { margin-top: 20px; }
        .details { width: 100%; border-collapse: collapse; }
        .details th, .details td { text-align: left; padding: 8px; border-bottom: 1px solid #eee; }
        .footer { margin-top: 30px; font-size: 12px; text-align: center; color: #777; }
        .badge { background-color: #3498db; color: white; padding: 5px 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Healthify</h1>
        <h3>Comprobante de Cita Médica</h3>
    </div>

    <div class="content">
        <p>Estimado/a <strong>{{ $appointment->patient->user->name }}</strong>,</p>
        <p>A continuación se detallan los datos de su cita programada:</p>

        <table class="details">
            <tr>
                <th>Médico:</th>
                <td>{{ $appointment->doctor->user->name }} ({{ $appointment->doctor->specialty }})</td>
            </tr>
            <tr>
                <th>Fecha:</th>
                <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Hora:</th>
                <td>{{ $appointment->start_time }} - {{ $appointment->end_time }}</td>
            </tr>
            <tr>
                <th>Motivo:</th>
                <td>{{ $appointment->reason }}</td>
            </tr>
            <tr>
                <th>Estado:</th>
                <td><span class="badge">Confirmada</span></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Gracias por confiar en Healthify. Por favor, llegue 10 minutos antes de su cita.</p>
    </div>
</body>
</html>
