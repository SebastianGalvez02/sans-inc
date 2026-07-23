<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear cuenta - Sans Inc</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #e5e5e5;
            color: #111827;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .register-page {
            display: flex;
            justify-content: center;
            padding: 3rem 1rem;
        }

        .register-card {
            width: min(100%, 420px);
            background: #ffffff;
            border-radius: 14px;
            padding: 2.35rem 2rem 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
        }

        .register-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 3rem;
        }

        .register-logo img {
            width: 76px;
            height: 76px;
            object-fit: cover;
            border-radius: 12px;
        }

        .register-heading {
            text-align: center;
            margin-bottom: 2.2rem;
        }

        .register-heading h1 {
            margin: 0 0 0.4rem;
            font-size: 1.55rem;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: 0;
            color: #111827;
        }

        .register-heading p {
            margin: 0;
            color: #6b7280;
            font-size: 0.88rem;
        }

        .register-field {
            margin-bottom: 1rem;
        }

        .register-field label {
            display: block;
            color: #0f1b33;
            font-size: 0.88rem;
            font-weight: 650;
            margin-bottom: 0.45rem;
        }

        .register-field input {
            width: 100%;
            height: 46px;
            border: 1px solid #cfd5df;
            border-radius: 9px;
            padding: 0 1rem;
            font-size: 0.92rem;
            color: #111827;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .register-field input:focus {
            border-color: #1a2332;
            box-shadow: 0 0 0 3px rgba(26, 35, 50, 0.12);
        }

        .register-field input::placeholder {
            color: #7f8794;
        }

        .register-message {
            display: none;
            border-radius: 8px;
            padding: 0.8rem 0.9rem;
            margin: 0 0 1rem;
            font-size: 0.88rem;
            line-height: 1.35;
        }

        .register-message.is-success {
            display: block;
            background: #ecfdf3;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .register-message.is-error {
            display: block;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .register-submit {
            width: 100%;
            height: 49px;
            border: 0;
            border-radius: 8px;
            background: #1a2332;
            color: #ffffff;
            font-size: 0.98rem;
            font-weight: 750;
            cursor: pointer;
            margin-top: 0.55rem;
            transition: background-color 0.2s ease;
        }

        .register-submit:hover {
            background: #2a3442;
        }

        .register-submit:disabled {
            cursor: wait;
            opacity: 0.75;
        }

        @media (max-width: 640px) {
            .register-page {
                padding: 1.8rem 1rem;
            }

            .register-card {
                padding: 2rem 1.25rem 1.5rem;
            }
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

<main class="register-page">
    <section class="register-card" aria-labelledby="register-title">
        <div class="register-logo">
            <img src="{{ asset('images/LogoSans.jpeg') }}" alt="Sans Inc Logo">
        </div>

        <div class="register-heading">
            <h1 id="register-title">Crear cuenta</h1>
            <p>Únete a Sans Inc</p>
        </div>

        <form id="registerForm">
            <div id="registerMessage" class="register-message"></div>

            <div class="register-field">
                <label for="name">Nombre</label>
                <input id="name" name="name" type="text" maxlength="16" placeholder="Tu nombre completo" required>
            </div>

            <div class="register-field">
                <label for="email">Correo electrónico</label>
                <input id="email" name="email" type="email" maxlength="100" placeholder="correo@ejemplo.com" required>
            </div>

            <div class="register-field">
                <label for="password">Contraseña</label>
                <input id="password" name="password" type="password" placeholder="Mínimo 8 caracteres" required>
            </div>

            <button id="registerSubmit" class="register-submit" type="submit">Registrarse</button>
        </form>
    </section>
</main>

<script>
    const registerForm = document.getElementById('registerForm');
    const registerMessage = document.getElementById('registerMessage');
    const registerSubmit = document.getElementById('registerSubmit');

    function showRegisterMessage(type, text) {
        registerMessage.className = 'register-message is-' + type;
        registerMessage.textContent = text;
    }

    registerForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        const password = document.getElementById('password').value;
        registerSubmit.disabled = true;
        registerSubmit.textContent = 'Registrando...';
        registerMessage.className = 'register-message';
        registerMessage.textContent = '';

        try {
            const response = await fetch('/api/auth/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    role_id: 3,
                    password: password,
                    password_confirmation: password,
                }),
            });

            const data = await response.json();

            if (response.ok) {
                registerForm.reset();
                showRegisterMessage('success', 'Cuenta creada. Revisa tu correo para confirmar el registro antes de iniciar sesión.');
                return;
            }

            if (data.errors) {
                const firstError = Object.values(data.errors).flat()[0];
                showRegisterMessage('error', firstError || 'No se pudo crear la cuenta.');
                return;
            }

            showRegisterMessage('error', data.message || 'No se pudo crear la cuenta.');
        } catch (error) {
            showRegisterMessage('error', 'No se pudo conectar con el servidor.');
        } finally {
            registerSubmit.disabled = false;
            registerSubmit.textContent = 'Registrarse';
        }
    });
</script>

</body>
</html>
