{{-- resources/views/components/navbar.blade.php --}}
<nav class="sans-navbar">
    <div class="sans-navbar__brand">
        <a href="/" class="sans-navbar__logo">Sans Inc</a>
    </div>

    <div class="sans-navbar__actions">
        <a href="/" class="sans-navbar__icon" title="Inicio">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v6a1 1 0 001 1h4a1 1 0 001-1v-6m-6 0h6" />
            </svg>
        </a>

        <a href="/buscar" class="sans-navbar__icon" title="Buscar">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
            </svg>
        </a>

        <a href="/publicar" class="sans-navbar__icon" title="Publicar">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
        </a>

        <a href="/login" class="sans-navbar__btn">Iniciar Sesión</a>
    </div>
</nav>

<style>
    .sans-navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #1a2233;
        padding: 0 2rem;
        height: 60px;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
    }

    .sans-navbar__logo {
        color: #ffffff;
        font-size: 1.2rem;
        font-weight: 700;
        text-decoration: none;
        letter-spacing: 0.3px;
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    .sans-navbar__actions {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .sans-navbar__icon {
        color: #c8d0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
        text-decoration: none;
    }

    .sans-navbar__icon:hover {
        color: #ffffff;
    }

    .sans-navbar__btn {
        color: #ffffff;
        border: 1.5px solid #ffffff;
        border-radius: 6px;
        padding: 0.4rem 1.1rem;
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        transition: background-color 0.2s, color 0.2s;
        white-space: nowrap;
    }

    .sans-navbar__btn:hover {
        background-color: #ffffff;
        color: #1a2233;
    }
</style>
