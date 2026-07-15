<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sans Inc</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }

        /* Overlay oscuro detrás del panel */
        #overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 200;
        }
        #overlay.active { display: block; }

        /* Panel lateral derecho */
        #login-panel {
            position: fixed;
            top: 0;
            right: -420px;
            width: 360px;
            height: 100%;
            background: #ffffff;
            z-index: 300;
            padding: 2rem 2rem;
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        #login-panel.active { right: 0; }

        /* Encabezado del panel */
        .panel-header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 0;
        }
        .panel-close {
            background: none;
            border: none;
            font-size: 1.4rem;
            cursor: pointer;
            color: #555;
            line-height: 1;
            padding: 0;
        }
        .panel-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin: 3rem 0 3rem 0;
            font-family: 'Segoe UI', system-ui, sans-serif;
            color: #111;
        }

        /* Campos del formulario */
        .panel-input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1.5px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
            margin-bottom: 1rem;
            font-family: 'Segoe UI', system-ui, sans-serif;
            color: #333;
            outline: none;
        }
        .panel-input:focus { border-color: #1b2437; }
        .panel-input::placeholder { color: #aaa; }

        /* Botón Iniciar Sesión (oscuro) */
        .btn-login {
            width: 100%;
            padding: 0.9rem;
            background-color: #1b2437;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 0.9rem;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .btn-login:hover { background-color: #253350; }

        /* Botón Registrarse (blanco con borde) */
        .btn-register {
            width: 100%;
            padding: 0.9rem;
            background-color: #fff;
            color: #111;
            border: 1.5px solid #111;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 1.2rem;
            font-family: 'Segoe UI', system-ui, sans-serif;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        .btn-register:hover { background-color: #f5f5f5; }

        /* Recuperar contraseña */
        .panel-recover {
            text-align: center;
            font-size: 0.9rem;
            color: #2563eb;
            text-decoration: none;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .panel-recover:hover { text-decoration: underline; }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#f0f0f0;">

{{-- NAVBAR --}}
<nav style="
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #1b2437;
        padding: 0 2rem;
        height: 75px;
        position: sticky;
        top: 0;
        z-index: 100;
    ">
    <a href="/" style="
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: 700;
            text-decoration: none;
            font-family: 'Segoe UI', system-ui, sans-serif;
            letter-spacing: 0.2px;
        ">Sans Inc</a>

    <div style="display: flex; align-items: center; gap: 1.4rem;">

        {{-- Casa --}}
        <a href="/" title="Inicio" style="color: #b0bcd4; display:flex; align-items:center; text-decoration:none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
            </svg>
        </a>

        {{-- Búsqueda --}}
        <a href="/buscar" title="Buscar" style="color: #b0bcd4; display:flex; align-items:center; text-decoration:none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <circle cx="11" cy="11" r="6" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35" />
            </svg>
        </a>

        {{-- Publicar --}}
        <a href="/publicar" title="Publicar" style="color: #b0bcd4; display:flex; align-items:center; text-decoration:none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8M8 12h8" />
            </svg>
        </a>

        {{-- Separador --}}
        <div style="width: 1px; height: 24px; background-color: #4a5568; margin: 0 0.2rem;"></div>

        {{-- Botón Iniciar Sesión --}}
        <button onclick="abrirPanel()" style="
                color: #1b2437;
                background-color: #ffffff;
                border: 1.5px solid #ffffff;
                border-radius: 6px;
                padding: 0.45rem 1.2rem;
                font-size: 0.88rem;
                font-weight: 600;
                cursor: pointer;
                font-family: 'Segoe UI', system-ui, sans-serif;
                white-space: nowrap;
            ">Iniciar Sesión</button>
    </div>
</nav>

{{-- OVERLAY --}}
<div id="overlay" onclick="cerrarPanel()"></div>

{{-- PANEL LATERAL LOGIN --}}
<div id="login-panel">
    <div class="panel-header">
        <button class="panel-close" onclick="cerrarPanel()">&#x2715;</button>
    </div>

    {{-- Logo --}}
    <div style="text-align: center; margin-bottom: 0.8rem;">
        <img
            src="{{ asset('images/LogoSans.jpeg') }}"
            alt="Logo Sans"
            style="width: 80px; height: 80px; object-fit: cover; border-radius: 16px;"
        >
    </div>

    <div class="panel-title">Sans Inc</div>

    <input type="text" class="panel-input" placeholder="Nombre de usuario" />
    <input type="password" class="panel-input" placeholder="Contraseña" />

    <button class="btn-login">Iniciar Sesión</button>
    <a href="/register" class="btn-register">Registrarse</a>
    <a href="/recuperar" class="panel-recover">Recuperar contraseña</a>
</div>

{{-- Contenido de la página va aquí --}}

<script>
    function abrirPanel() {
        document.getElementById('login-panel').classList.add('active');
        document.getElementById('overlay').classList.add('active');
    }
    function cerrarPanel() {
        document.getElementById('login-panel').classList.remove('active');
        document.getElementById('overlay').classList.remove('active');
    }
</script>

</body>
</html>
