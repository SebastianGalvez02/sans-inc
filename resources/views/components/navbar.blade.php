@props([
    'homeUrl' => '/',
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

        <div class="sans-navbar__search" id="navbarSearch">
            <button type="button" class="sans-navbar__icon" id="navbarSearchToggle" title="Buscar" aria-label="Buscar" aria-haspopup="true" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <circle cx="11" cy="11" r="6" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35" />
                </svg>
            </button>

            <div class="sans-navbar__search-panel" id="navbarSearchPanel">
                <input type="text" id="navbarSearchInput" class="sans-navbar__search-input" placeholder="Buscar producto..." autocomplete="off" />
                <div id="navbarSearchSuggestions" class="sans-navbar__search-suggestions"></div>
            </div>
        </div>

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
        border: 0;
        background: transparent;
        padding: 0;
        font: inherit;
        cursor: pointer;
        text-decoration: none;
        transition: color 0.2s;
    }

    .sans-navbar__icon:hover {
        color: #ffffff;
    }

    .sans-navbar__search {
        position: relative;
        display: flex;
        align-items: center;
    }

    .sans-navbar__search-panel {
        display: none;
        flex-direction: column;
        position: absolute;
        top: calc(100% + 14px);
        left: 50%;
        transform: translateX(-50%);
        width: min(320px, 90vw);
        z-index: 150;
    }

    .sans-navbar__search-panel.is-open {
        display: flex;
    }

    .sans-navbar__search-input {
        width: 100%;
        padding: 0.65rem 0.85rem;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 0.92rem;
        font-family: inherit;
        color: #0f1b33;
        background: #ffffff;
        outline: none;
    }

    .sans-navbar__search-input:focus {
        border-color: #315df4;
        box-shadow: 0 0 0 3px rgba(49, 93, 244, 0.18);
    }

    .sans-navbar__search-suggestions {
        display: none;
        margin-top: 0.5rem;
        background: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 12px;
        max-height: 220px;
        overflow-y: auto;
        text-align: left;
        box-shadow: 0 12px 28px rgba(15, 27, 51, 0.2);
    }

    .sans-navbar__search-item {
        padding: 0.75rem 0.95rem;
        font-size: 0.92rem;
        color: #0f1b33;
        cursor: pointer;
    }

    .sans-navbar__search-item:hover {
        background: #f3f6ff;
    }

    .sans-navbar__search-empty {
        padding: 0.75rem 0.95rem;
        font-size: 0.88rem;
        color: #64748b;
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

        .sans-navbar__search-panel {
            left: auto;
            right: -1rem;
            transform: none;
            width: min(280px, 85vw);
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

    (function () {
        const searchWrap = document.getElementById('navbarSearch');
        const toggleBtn = document.getElementById('navbarSearchToggle');
        const panel = document.getElementById('navbarSearchPanel');
        const input = document.getElementById('navbarSearchInput');
        const suggestionsEl = document.getElementById('navbarSearchSuggestions');
        const homeUrl = '{{ $homeUrl }}';

        if (!searchWrap) {
            return;
        }

        let products = null;
        let productsPromise = null;

        function loadProducts() {
            if (!productsPromise) {
                productsPromise = fetch('/api/products')
                    .then((r) => (r.ok ? r.json() : []))
                    .then((data) => { products = Array.isArray(data) ? data : []; })
                    .catch(() => { products = []; });
            }

            return productsPromise;
        }

        function renderSuggestions(query) {
            const q = query.trim().toLowerCase();

            if (!q || !products) {
                suggestionsEl.style.display = 'none';
                suggestionsEl.innerHTML = '';
                return;
            }

            const matches = products
                .filter((p) => (p.name || '').toLowerCase().includes(q))
                .slice(0, 10);

            suggestionsEl.innerHTML = '';

            if (matches.length === 0) {
                const empty = document.createElement('div');
                empty.className = 'sans-navbar__search-empty';
                empty.textContent = 'Sin resultados';
                suggestionsEl.appendChild(empty);
                suggestionsEl.style.display = 'block';
                return;
            }

            matches.forEach((product) => {
                const item = document.createElement('div');
                item.className = 'sans-navbar__search-item';
                item.textContent = product.name;
                item.addEventListener('click', () => {
                    const id = product.productId ?? product.id;
                    const name = product.name;

                    if (typeof window.sansApplyProductFilter === 'function') {
                        window.sansApplyProductFilter({ id, name });
                        closeSearch();
                    } else {
                        window.location.href = `${homeUrl}?productId=${encodeURIComponent(id)}&nombre=${encodeURIComponent(name)}`;
                    }
                });
                suggestionsEl.appendChild(item);
            });

            suggestionsEl.style.display = 'block';
        }

        function closeSearch() {
            panel.classList.remove('is-open');
            toggleBtn.setAttribute('aria-expanded', 'false');
            suggestionsEl.style.display = 'none';
            suggestionsEl.innerHTML = '';
            input.value = '';
        }

        function openSearch() {
            panel.classList.add('is-open');
            toggleBtn.setAttribute('aria-expanded', 'true');
            loadProducts().then(() => renderSuggestions(input.value));
            input.focus();
        }

        toggleBtn.addEventListener('click', (event) => {
            event.stopPropagation();
            panel.classList.contains('is-open') ? closeSearch() : openSearch();
        });

        input.addEventListener('input', () => renderSuggestions(input.value));

        input.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeSearch();
            }
        });

        document.addEventListener('click', (event) => {
            if (!searchWrap.contains(event.target)) {
                closeSearch();
            }
        });
    })();
</script>
