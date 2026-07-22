<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sans Inc</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    html,
    body {
        min-height: 100%;
    }

    body {
        min-height: 100vh;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        background-color: #f0f0f0;
    }

    .sans-page-content {
        width: 100%;
        flex: 1;
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

<main class="sans-page-content">
    {{-- Contenido principal de la página --}}
</main>

<x-footer />

</body>
</html>
