<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro confirmado - Sans Inc</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #e5e5e5;
            color: #111827;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .confirmed-page {
            flex: 1;
            display: flex;
            justify-content: center;
            padding: 4rem 1rem;
        }

        .confirmed-card {
            width: min(100%, 420px);
            background: #ffffff;
            border-radius: 14px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
        }

        .confirmed-card h1 {
            margin: 0 0 0.75rem;
            font-size: 1.45rem;
            color: #111827;
        }

        .confirmed-card p {
            margin: 0 0 1.5rem;
            color: #6b7280;
        }

        .confirmed-card a {
            display: inline-flex;
            justify-content: center;
            width: 100%;
            background: #1a2332;
            color: #ffffff;
            padding: 0.95rem 1rem;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
        }
    </style>
</head>
<body>

<x-navbar />

<x-login-panel>
    <form data-login-form>
        <div class="panel-message" data-login-message></div>
        <input type="email" name="email" class="panel-input" placeholder="Correo electrónico" required />
        <input type="password" name="password" class="panel-input" placeholder="Contraseña" required />

        <button type="submit" class="btn-login" data-login-submit>Iniciar Sesión</button>
        <a href="/register" class="btn-register">Registrarse</a>
        <a href="/recuperar" class="panel-recover">Recuperar contraseña</a>
    </form>
</x-login-panel>

<main class="confirmed-page">
    <section class="confirmed-card">
        <h1>Registro confirmado</h1>
        <p>Tu correo fue verificado correctamente. Ya puedes iniciar sesión.</p>
        <a href="/">Volver al inicio</a>
    </section>
</main>

<x-footer />

</body>
</html>
