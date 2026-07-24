<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Profile - Sans Inc</title>

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
            background: #e8e8e8;
            color: #111827;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .profile-page {
            width: min(1040px, calc(100% - 2rem));
            margin: 0 auto;
            padding: 2rem 0 5rem;
            flex: 1;
        }

        /* =========================================================
           TARJETA SUPERIOR
        ========================================================= */

        .profile-card {
            width: 100%;
            padding: 1.55rem 1.65rem;
            background: #ffffff;
            border: 1px solid #d9dee7;
            border-radius: 13px;
            box-shadow: 0 3px 10px rgba(15, 27, 51, 0.16);
        }

        .profile-settings {
            display: grid;
            grid-template-columns: 72px minmax(0, 1fr) 1px minmax(0, 1fr);
            gap: 1rem;
            align-items: start;
        }

        .profile-avatar {
            width: 64px;
            height: 64px;
            margin-top: 0.15rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #1b2437;
            color: #ffffff;
        }

        .profile-avatar svg {
            width: 35px;
            height: 35px;
        }

        .profile-divider {
            width: 1px;
            min-height: 74px;
            background: #e5e7eb;
        }

        .setting-block {
            min-width: 0;
        }

        .setting-main-row {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .display-box,
        .setting-input {
            width: min(100%, 230px);
            height: 40px;
            padding: 0 0.9rem;
            display: flex;
            align-items: center;
            border: 1px solid #cfd5df;
            border-radius: 9px;
            background: #f9fafb;
            color: #111827;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .password-mask {
            letter-spacing: 0.1em;
        }

        .setting-input {
            background: #ffffff;
            font: inherit;
            font-weight: 500;
            outline: none;
        }

        .setting-input:focus {
            border-color: #315df4;
            box-shadow: 0 0 0 3px rgba(49, 93, 244, 0.10);
        }

        .change-button {
            height: 40px;
            padding: 0 1.15rem;
            border: 0;
            border-radius: 8px;
            background: #3569f4;
            color: #ffffff;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.18s ease, opacity 0.18s ease;
        }

        .change-button:hover {
            background: #2858dc;
        }

        .change-button.is-editing {
            background: #91acf6;
            cursor: default;
        }

        .edit-area {
            display: none;
        }

        .edit-area.is-open {
            display: block;
        }

        .edit-field {
            margin-top: 0.55rem;
        }

        .edit-field .setting-input {
            width: min(100%, 230px);
        }

        .setting-actions {
            margin-top: 0.6rem;
            display: flex;
            gap: 0.55rem;
        }

        .accept-button,
        .cancel-button {
            min-width: 82px;
            height: 40px;
            padding: 0 1rem;
            border-radius: 9px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
        }

        .accept-button {
            border: 1px solid #1b2437;
            background: #1b2437;
            color: #ffffff;
        }

        .accept-button:hover {
            background: #111827;
        }

        .accept-button:disabled {
            opacity: 0.6;
            cursor: wait;
        }

        .cancel-button {
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #475569;
        }

        .cancel-button:hover {
            background: #f8fafc;
        }

        .profile-message {
            display: none;
            max-width: 360px;
            margin-top: 0.65rem;
            padding: 0.65rem 0.8rem;
            border-radius: 7px;
            font-size: 0.82rem;
            line-height: 1.4;
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

        /* =========================================================
           PUBLICACIONES DEL USUARIO
        ========================================================= */

        .publications-section {
            margin-top: 2rem;
        }

        .publications-title {
            margin: 0 0 1rem;
            color: #111827;
            font-size: 1.65rem;
            font-weight: 800;
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

        .publication-title {
            margin: 0 0 0.85rem;
            color: #020617;
            font-size: 1.15rem;
            font-weight: 800;
        }

        .publication-review {
            margin: 0;
            color: #1f2937;
            line-height: 1.55;
        }

        .publications-empty,
        .profile-loading {
            width: 100%;
            padding: 2.4rem 1rem;
            background: #ffffff;
            border: 1px solid #d8dde6;
            border-radius: 11px;
            box-shadow: 0 2px 8px rgba(15, 27, 51, 0.12);
            color: #64748b;
            text-align: center;
            font-size: 1rem;
        }

        @media (max-width: 860px) {
            .profile-settings {
                grid-template-columns: 72px 1fr;
            }

            .profile-divider {
                display: none;
            }

            .setting-block.password-block {
                grid-column: 2;
            }
        }

        @media (max-width: 680px) {
            .profile-page {
                width: min(100% - 1rem, 1040px);
                padding-top: 1rem;
            }

            .profile-card {
                padding: 1.2rem;
            }

            .profile-settings {
                grid-template-columns: 1fr;
            }

            .profile-avatar {
                margin: 0 auto 0.5rem;
            }

            .setting-block.password-block {
                grid-column: auto;
            }

            .setting-main-row {
                flex-direction: column;
                align-items: stretch;
            }

            .display-box,
            .setting-input,
            .edit-field .setting-input,
            .change-button {
                width: 100%;
            }

            .publications-grid {
                grid-template-columns: 1fr;
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
            placeholder="Email"
            required
        >

        <input
            type="password"
            name="password"
            class="panel-input"
            placeholder="Password"
            required
        >

        <button type="submit" class="btn-login" data-login-submit>
            Log In
        </button>

        <a href="/register" class="btn-register">Sign Up</a>
        <a href="/recuperar" class="panel-recover">Forgot password</a>
    </form>
</x-login-panel>

<main class="profile-page">

    <div id="profileLoading" class="profile-loading">
        Loading profile...
    </div>

    <section id="profileCard" class="profile-card" style="display:none;">

        <div class="profile-settings">

            <div class="profile-avatar" aria-hidden="true">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
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

            {{-- =====================================================
                 NOMBRE
            ====================================================== --}}
            <div class="setting-block">

                {{-- Estado normal --}}
                <div id="nameNormal">
                    <div class="setting-main-row">

                        <div id="displayName" class="display-box"></div>

                        <button
                            type="button"
                            id="editNameButton"
                            class="change-button"
                        >
                            Change name
                        </button>

                    </div>
                </div>

                {{-- Estado edición --}}
                <div id="nameEditArea" class="edit-area">

                    <form id="nameForm">

                        <div class="setting-main-row">

                            <input
                                id="profileName"
                                name="name"
                                type="text"
                                maxlength="16"
                                class="setting-input"
                                required
                            >

                            <button
                                type="button"
                                class="change-button is-editing"
                                disabled
                            >
                                Change name
                            </button>

                        </div>

                        <div class="setting-actions">

                            <button
                                id="nameSubmit"
                                type="submit"
                                class="accept-button"
                            >
                                Accept
                            </button>

                            <button
                                id="cancelNameButton"
                                type="button"
                                class="cancel-button"
                            >
                                Cancel
                            </button>

                        </div>

                    </form>

                </div>

                <div id="nameMessage" class="profile-message"></div>

            </div>

            <div class="profile-divider"></div>

            {{-- =====================================================
                 CONTRASEÑA
            ====================================================== --}}
            <div class="setting-block password-block">

                {{-- Estado normal --}}
                <div id="passwordNormal">

                    <div class="setting-main-row">

                        {{-- SOLO visual. Nunca representa la contraseña real. --}}
                        <div class="display-box password-mask">
                            ••••••••••
                        </div>

                        <button
                            type="button"
                            id="editPasswordButton"
                            class="change-button"
                        >
                            Change password
                        </button>

                    </div>

                </div>

                {{-- Estado edición --}}
                <div id="passwordEditArea" class="edit-area">

                    <form id="passwordForm">

                        <div class="setting-main-row">

                            <input
                                id="currentPassword"
                                type="password"
                                class="setting-input"
                                placeholder="Current password"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                type="button"
                                class="change-button is-editing"
                                disabled
                            >
                                Change password
                            </button>

                        </div>

                        <div class="edit-field">
                            <input
                                id="newPassword"
                                type="password"
                                class="setting-input"
                                placeholder="New password"
                                minlength="8"
                                autocomplete="new-password"
                                required
                            >
                        </div>

                        <div class="edit-field">
                            <input
                                id="confirmPassword"
                                type="password"
                                class="setting-input"
                                placeholder="Repeat password"
                                minlength="8"
                                autocomplete="new-password"
                                required
                            >
                        </div>

                        <div class="setting-actions">

                            <button
                                id="passwordSubmit"
                                type="submit"
                                class="accept-button"
                            >
                                Accept
                            </button>

                            <button
                                id="cancelPasswordButton"
                                type="button"
                                class="cancel-button"
                            >
                                Cancel
                            </button>

                        </div>

                    </form>

                </div>

                <div id="passwordMessage" class="profile-message"></div>

            </div>

        </div>

    </section>

    <section class="publications-section">

        <h2 id="publicationsTitle" class="publications-title">
            User Reviews
        </h2>

        <div id="publicationsGrid" class="publications-grid"></div>

        <div
            id="publicationsEmpty"
            class="publications-empty"
            style="display:none;"
        >
            This user hasn't posted any reviews yet.
        </div>

    </section>

</main>

<x-footer />

<script>
    const profileLoading = document.getElementById('profileLoading');
    const profileCard = document.getElementById('profileCard');

    const displayName = document.getElementById('displayName');
    const publicationsTitle = document.getElementById('publicationsTitle');

    const nameNormal = document.getElementById('nameNormal');
    const nameEditArea = document.getElementById('nameEditArea');
    const editNameButton = document.getElementById('editNameButton');
    const nameForm = document.getElementById('nameForm');
    const profileName = document.getElementById('profileName');
    const nameSubmit = document.getElementById('nameSubmit');
    const cancelNameButton = document.getElementById('cancelNameButton');
    const nameMessage = document.getElementById('nameMessage');

    const passwordNormal = document.getElementById('passwordNormal');
    const passwordEditArea = document.getElementById('passwordEditArea');
    const editPasswordButton = document.getElementById('editPasswordButton');
    const passwordForm = document.getElementById('passwordForm');
    const currentPasswordInput = document.getElementById('currentPassword');
    const newPasswordInput = document.getElementById('newPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const passwordSubmit = document.getElementById('passwordSubmit');
    const cancelPasswordButton = document.getElementById('cancelPasswordButton');
    const passwordMessage = document.getElementById('passwordMessage');

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
        window.dispatchEvent(new Event('sans-auth-changed'));
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

    /* =============================================================
       EDITAR NOMBRE
    ============================================================= */

    function openNameEditor() {
        clearMessage(nameMessage);

        profileName.value = currentUser?.name ?? '';

        nameNormal.style.display = 'none';
        nameEditArea.classList.add('is-open');

        profileName.focus();
        profileName.select();
    }

    function closeNameEditor() {
        nameEditArea.classList.remove('is-open');
        nameNormal.style.display = 'block';

        profileName.value = currentUser?.name ?? '';
    }

    editNameButton.addEventListener('click', openNameEditor);
    cancelNameButton.addEventListener('click', closeNameEditor);

    /* =============================================================
       EDITAR CONTRASEÑA
    ============================================================= */

    function clearPasswordFields() {
        currentPasswordInput.value = '';
        newPasswordInput.value = '';
        confirmPasswordInput.value = '';
    }

    function openPasswordEditor() {
        clearMessage(passwordMessage);
        clearPasswordFields();

        passwordNormal.style.display = 'none';
        passwordEditArea.classList.add('is-open');

        currentPasswordInput.focus();
    }

    function closePasswordEditor() {
        passwordEditArea.classList.remove('is-open');
        passwordNormal.style.display = 'block';

        clearPasswordFields();
    }

    editPasswordButton.addEventListener('click', openPasswordEditor);
    cancelPasswordButton.addEventListener('click', closePasswordEditor);

    /* =============================================================
       VALIDACIÓN DE CONTRASEÑA
       Debe respetar las mismas reglas del backend:
       - mínimo 8 caracteres
       - al menos una letra
       - al menos un número
       - al menos un símbolo
    ============================================================= */

    function validateNewPassword(password) {
        if (password.length < 8) {
            return 'The new password must be at least 8 characters long.';
        }

        if (!/[A-Za-z]/.test(password)) {
            return 'The new password must contain at least one letter.';
        }

        if (!/[0-9]/.test(password)) {
            return 'The new password must contain at least one number.';
        }

        if (!/[^A-Za-z0-9]/.test(password)) {
            return 'The new password must contain at least one symbol.';
        }

        return null;
    }

    /* =============================================================
       CARGAR PERFIL
    ============================================================= */

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
                throw new Error('Unable to load the profile.');
            }

            currentUser = await response.json();

            displayName.textContent = currentUser.name;
            profileName.value = currentUser.name;
            publicationsTitle.textContent =
                `Reviews by @${currentUser.name}`;

            localStorage.setItem(
                'sansUser',
                JSON.stringify(currentUser)
            );

            profileLoading.style.display = 'none';
            profileCard.style.display = 'block';

            await loadUserPublications();

        } catch (error) {
            profileLoading.textContent =
                'Unable to load the profile.';
        }
    }

    /* =============================================================
       PUBLICACIONES DEL USUARIO
    ============================================================= */

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
                'Unable to load your publications.';
        }
    }

    function renderUserPublications(
        publications,
        productsById
    ) {
        publicationsGrid.innerHTML = '';

        if (!publications.length) {
            publicationsEmpty.style.display = 'block';
            publicationsEmpty.textContent =
                'This user hasn\'t posted any reviews yet.';
            return;
        }

        publicationsEmpty.style.display = 'none';

        publications.forEach(publication => {

            const productName =
                productsById[publication.productId]
                ?? `Product #${publication.productId}`;

            const card =
                document.createElement('article');

            card.className = 'publication-card';

            /*
             * Se muestran únicamente los datos necesarios de la publicación.
             * No se agregan contadores/resúmenes de rating, likes o reseñas
             * al perfil.
             */
            card.innerHTML = `
                <div class="publication-meta">

                    <p class="publication-user">
                        @${escapeHtml(currentUser.name)}
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
                    not yet available
                </div>

                <div class="publication-content">

                    <h3 class="publication-title">
                        ${escapeHtml(productName)}
                    </h3>

                    <p class="publication-review">
                        ${escapeHtml(publication.review)}
                    </p>

                </div>
            `;

            publicationsGrid.appendChild(card);
        });
    }

    /* =============================================================
       GUARDAR NOMBRE
    ============================================================= */

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
                    'You must enter a name.'
                );
                return;
            }

            if (name.length > 16) {
                showMessage(
                    nameMessage,
                    'error',
                    'The name cannot exceed 16 characters.'
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
                        'Unable to update the name.'
                    );

                    return;
                }

                currentUser = data.user;

                displayName.textContent =
                    currentUser.name;

                profileName.value =
                    currentUser.name;

                publicationsTitle.textContent =
                    `Reviews by @${currentUser.name}`;

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

                closeNameEditor();

                showMessage(
                    nameMessage,
                    'success',
                    'Name updated successfully.'
                );

                await loadUserPublications();

            } catch (error) {

                showMessage(
                    nameMessage,
                    'error',
                    'Could not connect to the server.'
                );

            } finally {
                nameSubmit.disabled = false;
            }
        }
    );

    /* =============================================================
       GUARDAR CONTRASEÑA
    ============================================================= */

    passwordForm.addEventListener(
        'submit',
        async function (event) {

            event.preventDefault();
            clearMessage(passwordMessage);

            const currentPassword =
                currentPasswordInput.value;

            const newPassword =
                newPasswordInput.value;

            const confirmPassword =
                confirmPasswordInput.value;

            if (!currentPassword) {
                showMessage(
                    passwordMessage,
                    'error',
                    'You must enter your current password.'
                );
                return;
            }

            const validationError =
                validateNewPassword(newPassword);

            if (validationError) {
                showMessage(
                    passwordMessage,
                    'error',
                    validationError
                );
                return;
            }

            if (newPassword !== confirmPassword) {
                showMessage(
                    passwordMessage,
                    'error',
                    'The new passwords do not match.'
                );
                return;
            }

            if (currentPassword === newPassword) {
                showMessage(
                    passwordMessage,
                    'error',
                    'The new password must be different from the current password.'
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
                        'Unable to change the password.'
                    );

                    return;
                }

                logoutLocal();

                alert(
                    'Password updated successfully. You must log in again.'
                );

                window.location.href = '/';

            } catch (error) {

                showMessage(
                    passwordMessage,
                    'error',
                    'Could not connect to the server.'
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