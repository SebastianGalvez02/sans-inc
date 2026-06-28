<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Agendas — Sans Inc.</title>
</head>
<body>
    <h1>Mis agendas</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('agenda.create') }}">Nueva agenda</a>

    @if ($agendas->isEmpty())
        <p>No tienes agendas registradas.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Razón</th>
                    <th>Teléfono</th>
                    <th>Fecha agendada</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agendas as $agenda)
                    <tr>
                        <td>{{ $agenda->reason }}</td>
                        <td>{{ $agenda->phone }}</td>
                        <td>{{ $agenda->scheduled_date->format('d/m/Y H:i') }}</td>
                        <td>
                            <form method="POST" action="{{ route('agenda.destroy', $agenda->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Cancelar esta agenda?')">
                                    Cancelar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>