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

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #e5e5e5;
            color: #0f1b33;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .feed-page {
            width: min(100%, 680px);
            margin: 0 auto;
            padding: 1.6rem 1rem 3rem;
            flex: 1;
        }

        .feed-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.35rem;
        }

        .feed-title {
            margin: 0;
            font-size: 1.9rem;
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: 0;
            color: #0f1b33;
        }

        .feed-actions {
            display: flex;
            align-items: center;
            gap: 0.55rem;
        }

        .view-toggle {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: #ffffff;
            border: 1px solid #d8dde6;
            border-radius: 9px;
            padding: 0.35rem;
            box-shadow: 0 1px 4px rgba(15, 27, 51, 0.08);
        }

        .view-toggle button,
        .filter-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            height: 36px;
            border: 0;
            border-radius: 7px;
            padding: 0 0.75rem;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
        }

        .view-toggle button {
            color: #5f6b7f;
            background: transparent;
        }

        .view-toggle button.is-active {
            color: #ffffff;
            background: #1a2332;
        }

        .filter-button {
            color: #1a2332;
            background: #ffffff;
            border: 1px solid #d8dde6;
            box-shadow: 0 1px 4px rgba(15, 27, 51, 0.08);
        }

        .active-filter-bar {
            display: none;
            align-items: center;
            gap: 0.6rem;
            background: #ffffff;
            border: 1px solid #d8dde6;
            border-radius: 8px;
            padding: 0.7rem 0.95rem;
            margin-bottom: 1.2rem;
            font-size: 0.92rem;
            color: #24324d;
            box-shadow: 0 1px 4px rgba(15, 27, 51, 0.08);
        }

        .active-filter-bar.is-active {
            display: flex;
        }

        .active-filter-bar strong {
            color: #0f1b33;
        }

        .active-filter-bar button {
            margin-left: auto;
            border: 0;
            background: transparent;
            color: #315df4;
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
        }

        .feed-list {
            display: grid;
            gap: 1.2rem;
        }

        .feed-list.is-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            align-items: start;
        }

        .publication-card {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #d8dde6;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(15, 27, 51, 0.12);
        }

        .publication-meta {
            padding: 0.9rem 1rem 0.75rem;
        }

        .publication-user {
            margin: 0 0 0.25rem;
            color: #020617;
            font-size: 0.95rem;
            font-weight: 800;
        }

        .publication-date {
            margin: 0;
            color: #64748b;
            font-size: 0.86rem;
        }

        .publication-image-placeholder {
            min-height: 330px;
            background: linear-gradient(135deg, #f8fafc, #dfe5ee);
            border-top: 1px solid #edf0f5;
            border-bottom: 1px solid #edf0f5;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #7f8794;
            font-size: 1rem;
            font-weight: 700;
        }

        .publication-content {
            padding: 1.1rem 1rem 0.9rem;
        }

        .publication-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.85rem;
        }

        .publication-title {
            margin: 0;
            color: #020617;
            font-size: 1.18rem;
            line-height: 1.25;
            font-weight: 800;
        }

        .publication-review {
            margin: 0;
            color: #1f2937;
            font-size: 1rem;
            line-height: 1.55;
        }

        .publication-rating {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            flex: 0 0 auto;
            min-width: 74px;
            height: 48px;
            padding: 0 0.85rem;
            border-radius: 10px;
            background: #fef3c7;
            color: #020617;
            font-size: 1.05rem;
            font-weight: 800;
        }

        .publication-rating svg {
            width: 22px;
            height: 22px;
            color: #facc15;
            fill: #facc15;
        }

        .publication-footer {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.9rem;
            padding-top: 0.8rem;
            border-top: 1px solid #e5e7eb;
        }

        .publication-action {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            border: 0;
            background: transparent;
            color: #24324d;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            padding: 0;
        }

        .publication-action:hover {
            color: #1a2332;
        }

        .publication-action svg {
            width: 25px;
            height: 25px;
        }

        .publication-like-button .like-icon {
            color: #24324d;
            transition: color 160ms ease, fill 160ms ease;
        }

        .publication-like-button:hover .like-icon {
            color: #fb2c36;
        }

        .publication-like-button.is-liked .like-icon {
            color: #fb2c36;
            fill: currentColor;
        }

        .publication-like-button:disabled {
            cursor: wait;
            opacity: 0.65;
        }

        .empty-feed,
        .feed-error {
            display: none;
            background: #ffffff;
            border: 1px solid #d8dde6;
            border-radius: 8px;
            padding: 1.2rem;
            color: #64748b;
            text-align: center;
            box-shadow: 0 2px 8px rgba(15, 27, 51, 0.08);
        }

        .login-required-modal {
            position: fixed;
            inset: 0;
            z-index: 400;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.35);
            padding: 1rem;
        }

        .login-required-modal.is-open {
            display: flex;
        }

        .login-required-box {
            width: min(100%, 360px);
            background: #ffffff;
            border-radius: 10px;
            padding: 1.4rem;
            text-align: center;
            box-shadow: 0 14px 32px rgba(0, 0, 0, 0.18);
        }

        .login-required-box h2 {
            margin: 0 0 0.55rem;
            font-size: 1.25rem;
            color: #0f1b33;
        }

        .login-required-box p {
            margin: 0 0 1.1rem;
            color: #64748b;
        }

        .login-required-box button {
            width: 100%;
            border: 0;
            border-radius: 8px;
            background: #1a2332;
            color: #ffffff;
            padding: 0.85rem 1rem;
            font-weight: 750;
            cursor: pointer;
        }

        @media (max-width: 720px) {
            .feed-toolbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .feed-actions {
                width: 100%;
                justify-content: space-between;
            }

            .feed-list.is-grid {
                grid-template-columns: 1fr;
            }

            .publication-image-placeholder {
                min-height: 260px;
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

<main class="feed-page">
    <div class="feed-toolbar">
        <h1 class="feed-title">Feed de Reseñas</h1>

        <div class="feed-actions">
            <div class="view-toggle" aria-label="Cambiar vista">
                <button type="button" class="is-active" id="listViewButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                    </svg>
                    Lista
                </button>
                <button type="button" id="gridViewButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Viñetas
                </button>
            </div>

            <button type="button" class="filter-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18M6 12h12M10 19h4" />
                </svg>
                Filtro
            </button>
        </div>
    </div>

    <div class="active-filter-bar" id="activeFilterBar">
        <span>Resultados para: <strong id="activeFilterName"></strong></span>
        <button type="button" id="clearFilterButton">Quitar búsqueda ✕</button>
    </div>

    <div id="feedList" class="feed-list"></div>
    <div id="emptyFeed" class="empty-feed">No hay publicaciones disponibles.</div>
    <div id="feedError" class="feed-error">No se pudieron cargar las publicaciones.</div>
</main>

<x-footer />

<div class="login-required-modal" id="loginRequiredModal" role="dialog" aria-modal="true" aria-labelledby="loginRequiredTitle">
    <div class="login-required-box">
        <h2 id="loginRequiredTitle">Inicie sesión antes</h2>
        <p>Debes iniciar sesión para dar like a una publicación.</p>
        <button type="button" id="loginRequiredButton">Iniciar Sesión</button>
    </div>
</div>

<script>
    const feedList = document.getElementById('feedList');
    const emptyFeed = document.getElementById('emptyFeed');
    const feedError = document.getElementById('feedError');
    const listViewButton = document.getElementById('listViewButton');
    const gridViewButton = document.getElementById('gridViewButton');
    const loginRequiredModal = document.getElementById('loginRequiredModal');
    const loginRequiredButton = document.getElementById('loginRequiredButton');
    const activeFilterBar = document.getElementById('activeFilterBar');
    const activeFilterName = document.getElementById('activeFilterName');
    const clearFilterButton = document.getElementById('clearFilterButton');

    let currentFilterProductId = null;

    function escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function formatRelativeDate(value) {
        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return 'Fecha no disponible';
        }

        const seconds = Math.max(1, Math.floor((Date.now() - date.getTime()) / 1000));
        const units = [
            ['año', 31536000],
            ['mes', 2592000],
            ['semana', 604800],
            ['día', 86400],
            ['hora', 3600],
            ['minuto', 60],
        ];

        for (const [label, amount] of units) {
            const count = Math.floor(seconds / amount);

            if (count >= 1) {
                return `Hace ${count} ${label}${count === 1 ? '' : 's'}`;
            }
        }

        return 'Hace unos segundos';
    }

    function buildProductMap(products) {
        return products.reduce((map, product) => {
            map[product.productId ?? product.id] = product.name;
            return map;
        }, {});
    }

    function getPublicationUserName(publication) {
        const storedUser = JSON.parse(localStorage.getItem('sansUser') || 'null');

        if (publication.userName) {
            return publication.userName;
        }

        if (publication.user?.name) {
            return publication.user.name;
        }

        if (publication.name) {
            return publication.name;
        }

        if (storedUser && Number(storedUser.id) === Number(publication.userId)) {
            return storedUser.name;
        }

        return `usuario_${publication.userId}`;
    }

    function showLoginRequired() {
        loginRequiredModal.classList.add('is-open');
        abrirPanel();
    }

    function apiHeaders() {
        const headers = { 'Accept': 'application/json' };
        const token = localStorage.getItem('jwtToken');

        if (token) {
            headers.Authorization = `Bearer ${token}`;
        }

        return headers;
    }

    function updateLikeButton(button, liked, numberOfLikes) {
        button.classList.toggle('is-liked', liked);
        button.setAttribute('aria-pressed', liked ? 'true' : 'false');
        button.querySelector('[data-like-count]').textContent = numberOfLikes;
    }

    async function togglePublicationLike(publication, button) {
        const token = localStorage.getItem('jwtToken');

        if (!token) {
            showLoginRequired();
            return;
        }

        button.disabled = true;

        try {
            const response = await fetch(`/api/publications/${publication.publicationId}/like`, {
                method: 'POST',
                headers: apiHeaders(),
            });

            if (response.status === 401) {
                localStorage.removeItem('jwtToken');
                localStorage.removeItem('sansUser');
                window.dispatchEvent(new Event('sans-auth-changed'));
                showLoginRequired();
                return;
            }

            if (!response.ok) {
                throw new Error('Like request failed');
            }

            const data = await response.json();
            publication.likedByCurrentUser = Boolean(data.liked);
            publication.numberOfLikes = Number(data.numberOfLikes);
            updateLikeButton(button, publication.likedByCurrentUser, publication.numberOfLikes);
        } catch (error) {
            alert('No se pudo actualizar el like. Inténtalo nuevamente.');
        } finally {
            button.disabled = false;
        }
    }

    function renderPublications(publications, productsById) {
        feedList.innerHTML = '';
        emptyFeed.style.display = publications.length ? 'none' : 'block';

        publications.forEach((publication) => {
            const productName = productsById[publication.productId] || `Producto #${publication.productId}`;
            const userName = getPublicationUserName(publication);
            const card = document.createElement('article');
            card.className = 'publication-card';
            card.innerHTML = `
                <div class="publication-meta">
                    <p class="publication-user">@${escapeHtml(userName)}</p>
                    <p class="publication-date">${escapeHtml(formatRelativeDate(publication.publicationDate))}</p>
                </div>

                <div class="publication-image-placeholder">aún no disponible</div>

                <div class="publication-content">
                    <div class="publication-heading">
                        <h2 class="publication-title">${escapeHtml(productName)}</h2>
                        <div class="publication-rating" aria-label="Rating ${escapeHtml(Number(publication.rating).toFixed(1))} de 5">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 2.5l2.9 5.88 6.49.94-4.7 4.58 1.11 6.46L12 17.31l-5.8 3.05 1.11-6.46-4.7-4.58 6.49-.94L12 2.5Z" />
                            </svg>
                            ${escapeHtml(Number(publication.rating).toFixed(1))}
                        </div>
                    </div>
                    <p class="publication-review">${escapeHtml(publication.review)}</p>

                    <div class="publication-footer">
                        <button type="button" class="publication-action publication-like-button ${publication.likedByCurrentUser ? 'is-liked' : ''}" data-like-button aria-pressed="${publication.likedByCurrentUser ? 'true' : 'false'}">
                            <svg class="like-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" />
                            </svg>
                            <span data-like-count>${escapeHtml(publication.numberOfLikes)}</span>
                        </button>

                        <button type="button" class="publication-action">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" />
                            </svg>
                            <span>0</span>
                        </button>
                    </div>
                </div>
            `;

            const likeButton = card.querySelector('[data-like-button]');
            likeButton.addEventListener('click', () => togglePublicationLike(publication, likeButton));

            feedList.appendChild(card);
        });
    }

    function setFilterUi(product) {
        if (product) {
            activeFilterBar.classList.add('is-active');
            activeFilterName.textContent = product.name;
        } else {
            activeFilterBar.classList.remove('is-active');
            activeFilterName.textContent = '';
        }
    }

    async function loadPublications(productId = null) {
        try {
            const publicationsUrl = productId
                ? `/api/publications?productId=${encodeURIComponent(productId)}`
                : '/api/publications';

            const [publicationsResponse, productsResponse] = await Promise.all([
                fetch(publicationsUrl, { headers: apiHeaders() }),
                fetch('/api/products', { headers: apiHeaders() }),
            ]);

            if (!publicationsResponse.ok) {
                throw new Error('Publications request failed');
            }

            const publications = await publicationsResponse.json();
            const products = productsResponse.ok ? await productsResponse.json() : [];
            const ordered = [...publications].sort((a, b) => new Date(b.publicationDate) - new Date(a.publicationDate));

            renderPublications(ordered, buildProductMap(products));
        } catch (error) {
            feedError.style.display = 'block';
        }
    }

    window.sansApplyProductFilter = function (product) {
        currentFilterProductId = product ? product.id : null;
        setFilterUi(product);

        const url = new URL(window.location.href);

        if (product) {
            url.searchParams.set('productId', product.id);
            url.searchParams.set('nombre', product.name);
        } else {
            url.searchParams.delete('productId');
            url.searchParams.delete('nombre');
        }

        window.history.pushState({}, '', url);
        loadPublications(currentFilterProductId);
    };

    listViewButton.addEventListener('click', () => {
        feedList.classList.remove('is-grid');
        listViewButton.classList.add('is-active');
        gridViewButton.classList.remove('is-active');
    });

    gridViewButton.addEventListener('click', () => {
        feedList.classList.add('is-grid');
        gridViewButton.classList.add('is-active');
        listViewButton.classList.remove('is-active');
    });

    loginRequiredButton.addEventListener('click', () => {
        loginRequiredModal.classList.remove('is-open');
        abrirPanel();
    });

    loginRequiredModal.addEventListener('click', (event) => {
        if (event.target === loginRequiredModal) {
            loginRequiredModal.classList.remove('is-open');
        }
    });

    clearFilterButton.addEventListener('click', () => window.sansApplyProductFilter(null));

    window.addEventListener('sans-auth-changed', () => {
        if (localStorage.getItem('jwtToken')) {
            loginRequiredModal.classList.remove('is-open');
        }

        loadPublications(currentFilterProductId);
    });

    window.addEventListener('popstate', () => {
        const params = new URLSearchParams(window.location.search);
        const productId = params.get('productId');
        const nombre = params.get('nombre');

        currentFilterProductId = productId;
        setFilterUi(productId ? { id: productId, name: nombre || `Producto #${productId}` } : null);
        loadPublications(productId);
    });

    (function init() {
        const params = new URLSearchParams(window.location.search);
        const productId = params.get('productId');
        const nombre = params.get('nombre');

        if (productId) {
            currentFilterProductId = productId;
            setFilterUi({ id: productId, name: nombre || `Producto #${productId}` });
            loadPublications(productId);
        } else {
            loadPublications();
        }
    })();
</script>

</body>
</html>
