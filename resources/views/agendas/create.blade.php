<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Agenda — Sans Inc.</title>
</head>
<body>
    <h1>Solicitud de contacto</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('agenda.store') }}">
        @csrf

        <div>
            <label for="phone">Teléfono</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
        </div>

        <div>
            <label for="reason">Razón de contacto</label>
            <textarea id="reason" name="reason" required>{{ old('reason') }}</textarea>
        </div>

        <div>
            <label for="scheduled_date">Fecha agendada</label>
            <input type="datetime-local" id="scheduled_date" name="scheduled_date" value="{{ old('scheduled_date') }}" required>
        </div>

        <button type="submit">Registrar agenda</button>
    </form>

    <a href="{{ route('agenda.index') }}">Ver mis agendas</a>
</body>
</html>