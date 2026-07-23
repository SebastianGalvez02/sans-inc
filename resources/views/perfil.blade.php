<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mi Perfil - Sans Inc</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            background: #f0f0f0;
            color: #111827;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .profile-page {
            width: min(1100px, calc(100% - 2rem));
            margin: 0 auto;
            padding: 3rem 0;
            flex: 1;
        }

        .profile-title {
            margin: 0 0 2rem;
            color: #111827;
            font-size: 2rem;
            text-align: center;
        }

        /* ============================
           Información del perfil
        ============================ */

        .profile-card {
            max-width: 650px;
            margin: 0 auto 3rem;
            padding: 2rem;
            background: #ffffff;
            border: 1px solid #d8dde6;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(15, 27, 51, 0.12);
        }

        .profile-user-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #1b2437;
            color: #ffffff;
        }

        .profile-user-name {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 800;
        }

        .profile-user-email {
            margin: 0.3rem 0 0;
            color: #64748b;
            font-size: 0.9rem;
        }

        .profile-section {
            padding-top: 1.5rem;
            margin-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .profile-section-title {
            margin: 0 0 1rem;
            font-size: 1.1rem;
            color: #1b2437;
        }

        .profile-field {
            margin-bottom: 1rem;
        }

        .profile-field label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .profile-input {
            width: 100%;
            padding: 0.8rem 0.9rem;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            background: #ffffff;
            color: #111827;
            font: inherit;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .profile-input:focus {
            border-color: #315df4;
            box-shadow: 0 0 0 3px rgba(49, 93, 244, 0.12);
        }

        .profile-button {
            border: 0;
            border-radius: 7px;
            padding: 0.75rem 1.2rem;
            background: #315df4;
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .profile-button:hover {
            background: #244ce0;
        }

        .profile-button:disabled {
            opacity: 0.65;
            cursor: wait;
        }

        .profile-message {
            display: none;
            margin-bottom: 1rem;
            padding: 0.8rem 1rem;
            border-radius: 7px;
            font-size: 0.9rem;
        }

        .profile-message.success {
            display: block;
            background: #dcfce7;
            color: #166534;
        }

        .profile-message.error {
            display: block;
            background: #fee2e2;
            color: #991b1b;
        }

        /* ============================
           Mis publicaciones
        ============================ */

        .publications-section {
            margin-top: 2rem;
        }

        .publications-title {
            margin: 0 0 1.5rem;
            font-size: 1.5rem;
            color: #111827;
        }

        .publications-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.5rem;
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
            min-height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8fafc, #dfe5ee);
            border-top: 1px solid #edf0f5;
            border-bottom: 1px solid #edf0f5;
            color: #64748b;
            font-weight: 700;
        }

        .publication-content {
            padding: 1.1rem 1rem;
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
            font-weight: 800;
        }

        .publication-rating {
            min-width: 70px;
            padding: 0.6rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            border-radius: 7px;
            background: #f8fafc;
            font-weight: 800;
        }

        .publication-rating svg {
            width: 20px;
            height: 20px;
            color: #facc15;
            fill: #facc15;
        }

        .publication-review {
            margin: 0;
            color: #1f2937;
            line-height: 1.55;
        }

        .publication-footer {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            padding-top: 0.9rem;
            border-top: 1px solid #e5e7eb;
            color: #64748b;
            font-size: 0.9rem;
        }

        .publications-empty,
        .profile-loading {
            padding: 2rem;
            background: #ffffff;
            border: 1px solid #d8dde6;
            border-radius: 8px;
            color: #64748b;
            text-align: center;
        }

        @media (max-width: 760px) {
            .publications-grid {
                grid-template-columns: 1fr;
            }

            .profile-page {
                padding: 2rem 0;
            }

            .profile-card {
                padding: 1.4rem;
            }
        }
    </style>
</head>

<body>

<x-navbar />

<x-login-panel>
    <form data-login-form>
        <div class="panel-message" data-login-message></div>

        <input
            type="email"
            name="email"
            class="panel-input"
            placeholder="Correo electrónico"
            required
        >

        <input
            type="password"
            name="password"
            class="panel-input"
            placeholder="Contraseña"
            required
        >

        <button type="submit" class="btn-login" data-login-submit>
            Iniciar Sesión
        </button>

        <a href="/register" class="btn-register">Registrarse</a>
        <a href="/recuperar" class="panel-recover">Recuperar contraseña</a>
    </form>
</x-login-panel>

<main class="profile-page">

    <h1 class="profile-title">Mi Perfil</h1>

    <div id="profileLoading" class="profile-loading">
        Cargando perfil...
    </div>

    <section id="profileCard" class="profile-card" style="display:none;">

        <div class="profile-user-header">

            <div class="profile-avatar">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="42"
                    height="42"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M20 21a8 8 0 0 0-16 0"
                    />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>

            <h2 class="profile-user-name" id="profileUserName"></h2>
            <p class="profile-user-email" id="profileUserEmail"></p>

        </div>

        {{-- Cambio de nombre --}}
        <section class="profile-section">

            <h3 class="profile-section-title">
                Información personal
            </h3>

            <div
                id="nameMessage"
                class="profile-message"
            ></div>

            <form id="nameForm">

                <div class="profile-field">
                    <label for="profileName">
                        Nombre
                    </label>

                    <input
                        id="profileName"
                        name="name"
                        type="text"
                        maxlength="16"
                        class="profile-input"
                        required
                    >
                </div>

                <button
                    id="nameSubmit"
                    type="submit"
                    class="profile-button"
                >
                    Guardar nombre
                </button>

            </form>

        </section>

        {{-- Cambio de contraseña --}}
        <section class="profile-section">

            <h3 class="profile-section-title">
                Cambiar contraseña
            </h3>

            <div
                id="passwordMessage"
                class="profile-message"
            ></div>

            <form id="passwordForm">

                <div class="profile-field">
                    <label for="currentPassword">
                        Contraseña actual
                    </label>

                    <input
                        id="currentPassword"
                        type="password"
                        class="profile-input"
                        required
                    >
                </div>

                <div class="profile-field">
                    <label for="newPassword">
                        Nueva contraseña
                    </label>

                    <input
                        id="newPassword"
                        type="password"
                        class="profile-input"
                        minlength="8"
                        required
                    >
                </div>

                <div class="profile-field">
                    <label for="confirmPassword">
                        Confirmar nueva contraseña
                    </label>

                    <input
                        id="confirmPassword"
                        type="password"
                        class="profile-input"
                        minlength="8"
                        required
                    >
                </div>

                <button
                    id="passwordSubmit"
                    type="submit"
                    class="profile-button"
                >
                    Cambiar contraseña
                </button>

            </form>

        </section>

    </section>

    <section class="publications-section">

        <h2 class="publications-title">
            Mis publicaciones
        </h2>

        <div
            id="publicationsGrid"
            class="publications-grid"
        ></div>

        <div
            id="publicationsEmpty"
            class="publications-empty"
            style="display:none;"
        >
            Aún no tienes publicaciones.
        </div>

    </section>

</main>

<x-footer />

<script>
    const profileLoading = document.getElementById('profileLoading');
    const profileCard = document.getElementById('profileCard');

    const profileUserName = document.getElementById('profileUserName');
    const profileUserEmail = document.getElementById('profileUserEmail');
    const profileName = document.getElementById('profileName');

    const nameForm = document.getElementById('nameForm');
    const nameMessage = document.getElementById('nameMessage');
    const nameSubmit = document.getElementById('nameSubmit');

    const passwordForm = document.getElementById('passwordForm');
    const passwordMessage = document.getElementById('passwordMessage');
    const passwordSubmit = document.getElementById('passwordSubmit');

    const publicationsGrid = document.getElementById('publicationsGrid');
    const publicationsEmpty = document.getElementById('publicationsEmpty');

    let currentUser = null;

    function getToken() {
        return localStorage.getItem('jwtToken');
    }

    function apiHeaders() {
        const token = getToken();

        return {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            ...(token
                ? { 'Authorization': 'Bearer ' + token }
                : {}),
        };
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    function showMessage(element, type, message) {
        element.className = 'profile-message ' + type;
        element.textContent = message;
    }

    function clearMessage(element) {
        element.className = 'profile-message';
        element.textContent = '';
    }

    function logoutLocal() {
        localStorage.removeItem('jwtToken');
        localStorage.removeItem('sansUser');

        window.dispatchEvent(
            new Event('sans-auth-changed')
        );
    }

    function formatDate(dateString) {
        if (!dateString) {
            return '';
        }

        const date = new Date(dateString);

        return new Intl.DateTimeFormat('es-CL', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
        }).format(date);
    }

    function buildProductMap(products) {
        return products.reduce((map, product) => {
            const id = product.productId ?? product.id;
            const name = product.name ?? product.productName;

            if (id !== undefined) {
                map[id] = name;
            }

            return map;
        }, {});
    }

    async function loadProfile() {
        const token = getToken();

        if (!token) {
            window.location.href = '/';
            return;
        }

        try {
            const response = await fetch('/api/user', {
                headers: apiHeaders(),
            });

            if (response.status === 401) {
                logoutLocal();
                window.location.href = '/';
                return;
            }

            if (!response.ok) {
                throw new Error('No se pudo cargar el perfil.');
            }

            currentUser = await response.json();

            profileUserName.textContent = currentUser.name;
            profileUserEmail.textContent = currentUser.email;
            profileName.value = currentUser.name;

            localStorage.setItem(
                'sansUser',
                JSON.stringify(currentUser)
            );

            profileLoading.style.display = 'none';
            profileCard.style.display = 'block';

            await loadUserPublications();

        } catch (error) {
            profileLoading.textContent =
                'No se pudo cargar el perfil.';
        }
    }

    async function loadUserPublications() {
        try {
            const [publicationsResponse, productsResponse] =
                await Promise.all([
                    fetch('/api/publications', {
                        headers: apiHeaders(),
                    }),

                    fetch('/api/products', {
                        headers: apiHeaders(),
                    }),
                ]);

            if (!publicationsResponse.ok) {
                throw new Error();
            }

            const publications =
                await publicationsResponse.json();

            const products = productsResponse.ok
                ? await productsResponse.json()
                : [];

            const productsById =
                buildProductMap(products);

            const userPublications = publications
                .filter(publication =>
                    Number(publication.userId) ===
                    Number(currentUser.id)
                )
                .sort(
                    (a, b) =>
                        new Date(b.publicationDate) -
                        new Date(a.publicationDate)
                );

            renderUserPublications(
                userPublications,
                productsById
            );

        } catch (error) {
            publicationsGrid.innerHTML = '';

            publicationsEmpty.style.display = 'block';
            publicationsEmpty.textContent =
                'No se pudieron cargar tus publicaciones.';
        }
    }

    function renderUserPublications(
        publications,
        productsById
    ) {
        publicationsGrid.innerHTML = '';

        if (!publications.length) {
            publicationsEmpty.style.display = 'block';
            return;
        }

        publicationsEmpty.style.display = 'none';

        publications.forEach(publication => {

            const productName =
                productsById[publication.productId]
                ?? `Producto #${publication.productId}`;

            const card =
                document.createElement('article');

            card.className = 'publication-card';

            card.innerHTML = `
                <div class="publication-meta">

                    <p class="publication-user">
                        @${escapeHtml(publication.userName)}
                    </p>

                    <p class="publication-date">
                        ${escapeHtml(
                            formatDate(
                                publication.publicationDate
                            )
                        )}
                    </p>

                </div>

                <div class="publication-image-placeholder">
                    aún no disponible
                </div>

                <div class="publication-content">

                    <div class="publication-heading">

                        <h3 class="publication-title">
                            ${escapeHtml(productName)}
                        </h3>

                        <div class="publication-rating">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M12 2.5l2.9 5.88 6.49.94-4.7 4.58 1.11 6.46L12 17.31l-5.8 3.05 1.11-6.46-4.7-4.58 6.49-.94L12 2.5Z"
                                />
                            </svg>

                            ${escapeHtml(
                                Number(
                                    publication.rating
                                ).toFixed(1)
                            )}

                        </div>

                    </div>

                    <p class="publication-review">
                        ${escapeHtml(publication.review)}
                    </p>

                    <div class="publication-footer">
                        ♥ ${escapeHtml(
                            publication.numberOfLikes
                        )} Me gusta
                    </div>

                </div>
            `;

            publicationsGrid.appendChild(card);
        });
    }

    nameForm.addEventListener(
        'submit',
        async function (event) {

            event.preventDefault();
            clearMessage(nameMessage);

            const name =
                profileName.value.trim();

            if (!name) {
                showMessage(
                    nameMessage,
                    'error',
                    'Debes ingresar un nombre.'
                );
                return;
            }

            nameSubmit.disabled = true;

            try {
                const response =
                    await fetch('/api/user/profile', {
                        method: 'PUT',
                        headers: apiHeaders(),
                        body: JSON.stringify({
                            name: name,
                        }),
                    });

                const data =
                    await response.json();

                if (!response.ok) {
                    const errorMessage =
                        data.errors
                            ? Object.values(
                                data.errors
                            ).flat()[0]
                            : data.message;

                    showMessage(
                        nameMessage,
                        'error',
                        errorMessage ||
                        'No se pudo actualizar el nombre.'
                    );

                    return;
                }

                currentUser = data.user;

                profileUserName.textContent =
                    currentUser.name;

                const storedUser =
                    JSON.parse(
                        localStorage.getItem(
                            'sansUser'
                        ) || '{}'
                    );

                storedUser.name =
                    currentUser.name;

                localStorage.setItem(
                    'sansUser',
                    JSON.stringify(storedUser)
                );

                window.dispatchEvent(
                    new Event(
                        'sans-auth-changed'
                    )
                );

                showMessage(
                    nameMessage,
                    'success',
                    'Nombre actualizado correctamente.'
                );

                await loadUserPublications();

            } catch (error) {

                showMessage(
                    nameMessage,
                    'error',
                    'No se pudo conectar con el servidor.'
                );

            } finally {
                nameSubmit.disabled = false;
            }
        }
    );

    passwordForm.addEventListener(
        'submit',
        async function (event) {

            event.preventDefault();
            clearMessage(passwordMessage);

            const currentPassword =
                document.getElementById(
                    'currentPassword'
                ).value;

            const newPassword =
                document.getElementById(
                    'newPassword'
                ).value;

            const confirmPassword =
                document.getElementById(
                    'confirmPassword'
                ).value;

            if (
                newPassword !==
                confirmPassword
            ) {
                showMessage(
                    passwordMessage,
                    'error',
                    'Las nuevas contraseñas no coinciden.'
                );

                return;
            }

            passwordSubmit.disabled = true;

            try {
                const response =
                    await fetch('/api/user/password', {
                        method: 'PUT',
                        headers: apiHeaders(),

                        body: JSON.stringify({
                            current_password:
                                currentPassword,

                            password:
                                newPassword,

                            password_confirmation:
                                confirmPassword,
                        }),
                    });

                const data =
                    await response.json();

                if (!response.ok) {

                    const errorMessage =
                        data.errors
                            ? Object.values(
                                data.errors
                            ).flat()[0]
                            : data.message;

                    showMessage(
                        passwordMessage,
                        'error',
                        errorMessage ||
                        'No se pudo cambiar la contraseña.'
                    );

                    return;
                }

                logoutLocal();

                alert(
                    'Contraseña actualizada correctamente. Debes iniciar sesión nuevamente.'
                );

                window.location.href = '/';

            } catch (error) {

                showMessage(
                    passwordMessage,
                    'error',
                    'No se pudo conectar con el servidor.'
                );

            } finally {
                passwordSubmit.disabled = false;
            }
        }
    );

    loadProfile();
</script>

</body>
</html>