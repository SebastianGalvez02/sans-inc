<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar contraseña - Sans Inc</title>
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

        .recover-page {
            display: flex;
            justify-content: center;
            padding: 4rem 1rem;
        }

        .recover-card {
            width: min(100%, 460px);
            background: #ffffff;
            border-radius: 14px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
        }

        .recover-step {
            display: none;
        }

        .recover-step.active {
            display: block;
        }

        .recover-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 1.25rem;
            border-radius: 50%;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1b2437;
        }

        .recover-card h1 {
            margin: 0 0 0.75rem;
            font-size: 1.5rem;
            color: #111827;
        }

        .recover-card p {
            margin: 0 0 1.75rem;
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .recover-field {
            text-align: left;
            margin-bottom: 1.1rem;
        }

        .recover-field label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #111827;
        }

        .recover-input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1.5px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #333;
            outline: none;
        }

        .recover-input:focus {
            border-color: #1b2437;
        }

        .recover-input::placeholder {
            color: #aaa;
        }

        .btn-recover {
            width: 100%;
            padding: 0.9rem;
            background-color: #1b2437;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.25rem;
        }

        .btn-recover:hover {
            background-color: #253350;
        }

        .btn-recover:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .recover-back {
            display: inline-block;
            margin-top: 1.25rem;
            background: none;
            border: none;
            color: #6b7280;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
        }

        .recover-back:hover {
            text-decoration: underline;
        }

        .recover-link {
            display: block;
            margin-top: 1.1rem;
            background: none;
            border: none;
            color: #2563eb;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .recover-link[hidden] {
            display: none;
        }

        .recover-link:hover {
            text-decoration: underline;
        }

        .recover-message {
            display: none;
            border-radius: 8px;
            padding: 0.75rem 0.85rem;
            margin-bottom: 1.1rem;
            font-size: 0.88rem;
            line-height: 1.35;
            text-align: left;
        }

        .recover-message.is-error {
            display: block;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .recover-message.is-success {
            display: block;
            background: #ecfdf3;
            color: #166534;
            border: 1px solid #bbf7d0;
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

<main class="recover-page">
    <section class="recover-card">

        {{-- Paso 1: solicitar código de recuperación --}}
        <div class="recover-step active" data-step="request">
            <div class="recover-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 6 9-6" />
                </svg>
            </div>

            <h1>Recuperar contraseña</h1>
            <p>Ingresa el correo electrónico asociado a tu cuenta y te enviaremos un código para cambiar tu contraseña.</p>

            <div class="recover-message" data-request-message></div>

            <form data-request-form>
                <div class="recover-field">
                    <label for="recover-email">Correo electrónico</label>
                    <input type="email" id="recover-email" name="email" class="recover-input" placeholder="correo@ejemplo.com" required />
                </div>

                <button type="submit" class="btn-recover" data-request-submit>Enviar correo de recuperación</button>
            </form>

            <button type="button" class="recover-link" data-goto-reset hidden>Ya tengo un código</button>
            <a href="/" class="recover-back">Volver atrás</a>
        </div>

        {{-- Paso 2: ingresar código y nueva contraseña --}}
        <div class="recover-step" data-step="reset">
            <div class="recover-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <rect x="5" y="11" width="14" height="9" rx="2" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V8a4 4 0 118 0v3" />
                </svg>
            </div>

            <h1>Restablecer contraseña</h1>
            <p>Revisa tu correo e ingresa el código de 6 dígitos junto con tu nueva contraseña.</p>

            <div class="recover-message" data-reset-message></div>

            <form data-reset-form>
                <input type="hidden" name="email" data-reset-email />

                <div class="recover-field">
                    <label for="recover-code">Código de verificación</label>
                    <input type="text" id="recover-code" name="code" class="recover-input" placeholder="123456" inputmode="numeric" maxlength="6" required />
                </div>

                <div class="recover-field">
                    <label for="recover-password">Nueva contraseña</label>
                    <input type="password" id="recover-password" name="password" class="recover-input" placeholder="Nueva contraseña" required />
                </div>

                <div class="recover-field">
                    <label for="recover-password-confirmation">Confirmar contraseña</label>
                    <input type="password" id="recover-password-confirmation" name="password_confirmation" class="recover-input" placeholder="Confirmar contraseña" required />
                </div>

                <button type="submit" class="btn-recover" data-reset-submit>Restablecer contraseña</button>
            </form>

            <button type="button" class="recover-back" data-back-to-request>Volver atrás</button>
        </div>

        {{-- Paso 3: confirmación --}}
        <div class="recover-step" data-step="done">
            <div class="recover-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1>Contraseña actualizada</h1>
            <p>Tu contraseña fue restablecida correctamente. Ya puedes iniciar sesión con tu nueva contraseña.</p>

            <a href="/" class="btn-recover" style="display:block; text-decoration:none; line-height: 1.4;">Volver al inicio</a>
        </div>

    </section>
</main>

<script>
    const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function showRecoverStep(name) {
        document.querySelectorAll('.recover-step').forEach(function (step) {
            step.classList.toggle('active', step.dataset.step === name);
        });
    }

    function firstValidationError(data) {
        if (data && data.errors) {
            return Object.values(data.errors).flat()[0];
        }

        return null;
    }

    document.querySelector('[data-back-to-request]')?.addEventListener('click', function () {
        showRecoverStep('request');
    });

    document.querySelector('[data-goto-reset]')?.addEventListener('click', function () {
        showRecoverStep('reset');
    });

    document.querySelector('[data-request-form]')?.addEventListener('submit', async function (event) {
        event.preventDefault();

        const form = event.target;
        const message = form.parentElement.querySelector('[data-request-message]');
        const submit = form.querySelector('[data-request-submit]');
        const email = form.querySelector('[name="email"]').value.trim();

        message.className = 'recover-message';
        message.textContent = '';

        if (!EMAIL_PATTERN.test(email)) {
            message.className = 'recover-message is-error';
            message.textContent = 'Ingresa un correo electrónico con un formato válido.';
            return;
        }

        submit.disabled = true;
        submit.textContent = 'Enviando...';

        try {
            const response = await fetch('/api/auth/forgot-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ email }),
            });
            const data = await response.json();

            if (response.ok) {
                const resetForm = document.querySelector('[data-reset-form]');
                resetForm.querySelector('[data-reset-email]').value = email;

                message.className = 'recover-message is-success';
                message.textContent = 'Si el correo está registrado, recibirás un código de verificación en tu bandeja de entrada.';
                document.querySelector('[data-goto-reset]').hidden = false;
                return;
            }

            message.className = 'recover-message is-error';
            message.textContent = firstValidationError(data) || data.message || 'No se pudo enviar el correo de recuperación.';
        } catch (error) {
            message.className = 'recover-message is-error';
            message.textContent = 'No se pudo conectar con el servidor.';
        } finally {
            submit.disabled = false;
            submit.textContent = 'Enviar correo de recuperación';
        }
    });

    document.querySelector('[data-reset-form]')?.addEventListener('submit', async function (event) {
        event.preventDefault();

        const form = event.target;
        const message = form.parentElement.querySelector('[data-reset-message]');
        const submit = form.querySelector('[data-reset-submit]');
        const email = form.querySelector('[data-reset-email]').value;
        const code = form.querySelector('[name="code"]').value;
        const password = form.querySelector('[name="password"]').value;
        const password_confirmation = form.querySelector('[name="password_confirmation"]').value;

        message.className = 'recover-message';
        message.textContent = '';

        if (password !== password_confirmation) {
            message.className = 'recover-message is-error';
            message.textContent = 'Las contraseñas no coinciden.';
            return;
        }

        submit.disabled = true;
        submit.textContent = 'Restableciendo...';

        try {
            const response = await fetch('/api/auth/reset-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ email, code, password, password_confirmation }),
            });
            const data = await response.json();

            if (response.ok) {
                showRecoverStep('done');
                return;
            }

            if (response.status === 400) {
                message.className = 'recover-message is-error';
                message.textContent = 'El código ingresado es incorrecto o ha expirado.';
                return;
            }

            message.className = 'recover-message is-error';
            message.textContent = firstValidationError(data) || data.message || 'No se pudo restablecer la contraseña.';
        } catch (error) {
            message.className = 'recover-message is-error';
            message.textContent = 'No se pudo conectar con el servidor.';
        } finally {
            submit.disabled = false;
            submit.textContent = 'Restablecer contraseña';
        }
    });
</script>

</body>
</html>
