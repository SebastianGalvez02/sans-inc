@props([
    'logoSrc' => null,
    'title' => 'Sans Inc',
])

@php
    $logoSrc = $logoSrc ?: asset('images/LogoSans.jpeg');
@endphp

<div id="overlay" class="sans-login-overlay" onclick="cerrarPanel()"></div>

<div id="login-panel" class="sans-login-panel">
    <div class="panel-header">
        <button type="button" class="panel-close" onclick="cerrarPanel()" aria-label="Close">&#x2715;</button>
    </div>

    <div class="panel-logo">
        <img src="{{ $logoSrc }}" alt="Logo Sans" />
    </div>

    <div class="panel-title">{{ $title }}</div>

    {{ $slot }}
</div>

<style>
    .sans-login-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 200;
    }

    .sans-login-overlay.active {
        display: block;
    }

    .sans-login-panel {
        position: fixed;
        top: 0;
        right: -420px;
        width: 360px;
        height: 100%;
        background: #ffffff;
        z-index: 300;
        padding: 2rem;
        transition: right 0.3s ease;
        display: flex;
        flex-direction: column;
        font-family: 'Segoe UI', system-ui, sans-serif;
        box-sizing: border-box;
    }

    .sans-login-panel *,
    .sans-login-panel *::before,
    .sans-login-panel *::after {
        box-sizing: border-box;
    }

    .sans-login-panel.active {
        right: 0;
    }

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

    .panel-logo {
        text-align: center;
        margin-bottom: 0.8rem;
    }

    .panel-logo img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 16px;
    }

    .panel-title {
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        margin: 3rem 0 3rem 0;
        color: #111;
    }

    .panel-input {
        width: 100%;
        padding: 0.85rem 1rem;
        border: 1.5px solid #ddd;
        border-radius: 10px;
        font-size: 0.95rem;
        margin-bottom: 1rem;
        color: #333;
        outline: none;
    }

    .panel-input:focus {
        border-color: #1b2437;
    }

    .panel-input::placeholder {
        color: #aaa;
    }

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
    }

    .btn-login:hover {
        background-color: #253350;
    }

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
        text-decoration: none;
        display: block;
        text-align: center;
    }

    .btn-register:hover {
        background-color: #f5f5f5;
    }

    .panel-recover {
        text-align: center;
        font-size: 0.9rem;
        color: #2563eb;
        text-decoration: none;
    }

    .panel-recover:hover {
        text-decoration: underline;
    }

    .panel-message {
        display: none;
        border-radius: 8px;
        padding: 0.75rem 0.85rem;
        margin-bottom: 1rem;
        font-size: 0.88rem;
        line-height: 1.35;
    }

    .panel-message.is-error {
        display: block;
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .panel-message.is-success {
        display: block;
        background: #ecfdf3;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
</style>

<script>
    function abrirPanel() {
        const panel = document.getElementById('login-panel');
        const overlay = document.getElementById('overlay');

        if (panel && overlay) {
            panel.classList.add('active');
            overlay.classList.add('active');
        }
    }

    function cerrarPanel() {
        const panel = document.getElementById('login-panel');
        const overlay = document.getElementById('overlay');

        if (panel && overlay) {
            panel.classList.remove('active');
            overlay.classList.remove('active');
        }
    }

    document.addEventListener('submit', async function (event) {
        const form = event.target.closest('[data-login-form]');

        if (!form) {
            return;
        }

        event.preventDefault();

        const message = form.querySelector('[data-login-message]');
        const submit = form.querySelector('[data-login-submit]');
        const email = form.querySelector('[name="email"]')?.value;
        const password = form.querySelector('[name="password"]')?.value;

        if (message) {
            message.className = 'panel-message';
            message.textContent = '';
        }

        if (submit) {
            submit.disabled = true;
            submit.textContent = 'Logging in...';
        }

        try {
            const response = await fetch('/api/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ email, password }),
            });
            const data = await response.json();

            if (response.ok && data.user && data.user.token) {
                localStorage.setItem('jwtToken', data.user.token);
                localStorage.setItem('sansUser', JSON.stringify({
                    id: data.user.id,
                    name: data.user.name,
                    email: data.user.email,
                    role_id: data.user.role_id,
                }));

                cerrarPanel();
                window.dispatchEvent(new Event('sans-auth-changed'));

                if (typeof updateActions === 'function') {
                    updateActions();
                }

                return;
            }

            const fallback = 'Unable to log in.';
            const text = data.message || fallback;

            if (message) {
                message.className = 'panel-message is-error';
                message.textContent = text;
            } else {
                alert(text);
            }
        } catch (error) {
            const text = 'Could not connect to the server.';

            if (message) {
                message.className = 'panel-message is-error';
                message.textContent = text;
            } else {
                alert(text);
            }
        } finally {
            if (submit) {
                submit.disabled = false;
                submit.textContent = 'Log In';
            }
        }
    });
</script>
