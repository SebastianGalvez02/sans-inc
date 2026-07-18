@props([
    'homeUrl' => '/',
    'searchUrl' => '/buscar',
    'publishUrl' => '/publicar',
    'agendaUrl' => '/agenda',
])

<nav class="sans-navbar">
    <a href="{{ $homeUrl }}" class="sans-navbar__logo">Sans Inc</a>

    <div class="sans-navbar__actions">
        <a href="{{ $homeUrl }}" class="sans-navbar__icon" title="Inicio" aria-label="Inicio">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
            </svg>
        </a>

        <a href="{{ $searchUrl }}" class="sans-navbar__icon" title="Buscar" aria-label="Buscar">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <circle cx="11" cy="11" r="6" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35" />
            </svg>
        </a>

        <a href="{{ $publishUrl }}" class="sans-navbar__icon" title="Publicar" aria-label="Publicar">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8M8 12h8" />
            </svg>
        </a>

        <a href="/perfil" class="sans-navbar__icon sans-navbar__auth" title="Perfil" aria-label="Perfil">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 21a8 8 0 0 0-16 0" />
                <circle cx="12" cy="7" r="4" />
            </svg>
        </a>

        <div class="sans-navbar__divider"></div>

        <button type="button" class="sans-navbar__btn sans-navbar__guest" onclick="abrirPanel()">Iniciar Sesión</button>

        <a href="{{ $agendaUrl }}" class="sans-navbar__agenda sans-navbar__auth">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18" />
            </svg>
            Agendar Hora
        </a>

        <button type="button" class="sans-navbar__logout sans-navbar__auth" onclick="cerrarSesion()">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 17l5-5-5-5M15 12H3" />
            </svg>
            Cerrar Sesión
        </button>
    </div>
</nav>

<style>
    .sans-navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #1b2437;
        padding: 0 2rem;
        height: 75px;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    .sans-navbar__logo {
        color: #ffffff;
        font-size: 1.1rem;
        font-weight: 700;
        text-decoration: none;
        letter-spacing: 0.2px;
        white-space: nowrap;
    }

    .sans-navbar__actions {
        display: flex;
        align-items: center;
        gap: 1.4rem;
    }

    .sans-navbar__icon {
        color: #b0bcd4;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: color 0.2s;
    }

    .sans-navbar__icon:hover {
        color: #ffffff;
    }

    .sans-navbar__divider {
        width: 1px;
        height: 24px;
        background-color: #4a5568;
    }

    .sans-navbar__btn {
        color: #1b2437;
        background-color: #ffffff;
        border: 1.5px solid #ffffff;
        border-radius: 6px;
        padding: 0.45rem 1.2rem;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background-color 0.2s, color 0.2s;
    }

    .sans-navbar__btn:hover {
        background-color: #f4f7fb;
    }

    .sans-navbar__auth {
        display: none;
    }

    .sans-navbar.is-authenticated .sans-navbar__guest {
        display: none;
    }

    .sans-navbar.is-authenticated .sans-navbar__auth {
        display: flex;
    }

    .sans-navbar__agenda,
    .sans-navbar__logout {
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: 0;
        border-radius: 8px;
        padding: 0.65rem 1rem;
        color: #ffffff;
        font-size: 0.9rem;
        font-weight: 700;
        line-height: 1;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background-color 0.2s, transform 0.2s;
    }

    .sans-navbar__agenda {
        background: #315df4;
    }

    .sans-navbar__agenda:hover {
        background: #244ce0;
    }

    .sans-navbar__logout {
        background: #374151;
    }

    .sans-navbar__logout:hover {
        background: #4b5563;
    }

    @media (max-width: 640px) {
        .sans-navbar {
            padding: 0 1rem;
        }

        .sans-navbar__actions {
            gap: 0.85rem;
        }

        .sans-navbar__agenda,
        .sans-navbar__logout {
            padding: 0.6rem 0.75rem;
            font-size: 0.82rem;
        }
    }
</style>

<script>
    function usuarioAutenticado() {
        return Boolean(localStorage.getItem('jwtToken'));
    }

    function actualizarNavbar() {
        document.querySelectorAll('.sans-navbar').forEach(function (navbar) {
            navbar.classList.toggle('is-authenticated', usuarioAutenticado());
        });
    }

    async function cerrarSesion() {
        const token = localStorage.getItem('jwtToken');

        if (token) {
            try {
                await fetch('/api/auth/logout', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token,
                    },
                });
            } catch (error) {
                // El cierre local debe ocurrir incluso si el token ya expiró.
            }
        }

        localStorage.removeItem('jwtToken');
        localStorage.removeItem('sansUser');
        actualizarNavbar();
        window.dispatchEvent(new Event('sans-auth-changed'));
    }

    document.addEventListener('DOMContentLoaded', actualizarNavbar);
    window.addEventListener('storage', actualizarNavbar);
    window.addEventListener('sans-auth-changed', actualizarNavbar);
</script>
