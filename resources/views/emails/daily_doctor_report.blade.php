<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Hola Dr. {{ $doctor->user->name }},</h2>
    <p>Esta es su lista de pacientes para hoy ({{ now()->format('d/m/Y') }}):</p>
    
    <table>
        <thead>
            <tr>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Motivo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->start_time }}</td>
                    <td>{{ $appointment->patient->user->name }}</td>
                    <td>{{ $appointment->reason }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No tiene citas agendadas para hoy.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <p>¡Tenga un excelente día de trabajo!</p>
</body>
</html>
