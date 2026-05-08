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
    <h2>Reporte General de Citas de Hoy ({{ now()->format('d/m/Y') }})</h2>
    <p>Hola Administrador, esta es la lista de citas programadas para el día de hoy:</p>
    
    <table>
        <thead>
            <tr>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Doctor</th>
                <th>Motivo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->start_time }}</td>
                    <td>{{ $appointment->patient->user->name }}</td>
                    <td>{{ $appointment->doctor->user->name }}</td>
                    <td>{{ $appointment->reason }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay citas agendadas para hoy.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
