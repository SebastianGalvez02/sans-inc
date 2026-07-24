<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Profile - Sans Inc</title>
    <link rel="icon" type="image/png" href="{{ asset('sans-favicon.png') }}">

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
            position: relative;
            padding: 0.9rem 1rem 0.75rem;
            padding-right: 3.5rem;
        }

        .publication-management {
            position: absolute;
            top: 0.65rem;
            right: 0.7rem;
        }

        .publication-menu-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #1b2437;
            cursor: pointer;
        }

        .publication-menu-button:hover,
        .publication-menu-button[aria-expanded="true"] {
            background: #f1f5f9;
        }

        .publication-menu-button svg {
            width: 21px;
            height: 21px;
            fill: #1b2437;
        }

        .publication-menu {
            position: absolute;
            top: calc(100% + 0.25rem);
            right: 0;
            z-index: 5;
            display: none;
            min-width: 130px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #d8dde6;
            border-radius: 7px;
            box-shadow: 0 8px 20px rgba(15, 27, 51, 0.16);
        }

        .publication-menu.is-open {
            display: grid;
        }

        .publication-menu-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
            min-height: 38px;
            padding: 0.55rem 0.7rem;
            border: 0;
            background: #ffffff;
            color: #1b2437;
            font: inherit;
            font-size: 0.86rem;
            text-align: left;
            cursor: pointer;
        }

        .publication-menu-item:hover {
            background: #f4f7fb;
        }

        .publication-menu-item[data-delete-publication] {
            color: #b42318;
        }

        .publication-menu-item svg {
            width: 17px;
            height: 17px;
            flex: 0 0 auto;
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

        .publication-edit-form[hidden] {
            display: none;
        }

        .publication-edit-form {
            display: grid;
            gap: 0.7rem;
        }

        .publication-edit-form label {
            display: grid;
            gap: 0.35rem;
            color: #1b2437;
            font-size: 0.86rem;
            font-weight: 700;
        }

        .publication-edit-form input,
        .publication-edit-form textarea {
            width: 100%;
            border: 1px solid #cfd5df;
            border-radius: 8px;
            padding: 0.7rem 0.8rem;
            background: #ffffff;
            color: #111827;
            font: inherit;
            outline: none;
        }

        .publication-edit-form input:focus,
        .publication-edit-form textarea:focus {
            border-color: #1b2437;
            box-shadow: 0 0 0 3px rgba(27, 36, 55, 0.12);
        }

        .publication-edit-form textarea {
            min-height: 90px;
            resize: vertical;
        }

        .publication-edit-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.55rem;
        }

        .publication-edit-actions button {
            min-height: 34px;
            border-radius: 6px;
            padding: 0.45rem 0.7rem;
            font: inherit;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
        }

        .publication-edit-cancel {
            border: 1px solid #1b2437;
            background: #ffffff;
            color: #1b2437;
        }

        .publication-edit-save {
            border: 1px solid #1b2437;
            background: #1b2437;
            color: #ffffff;
        }

        .publication-delete-modal {
            position: fixed;
            inset: 0;
            z-index: 600;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(15, 23, 42, 0.48);
        }

        .publication-delete-modal.is-open {
            display: flex;
        }

        .publication-delete-box {
            width: min(100%, 390px);
            padding: 1.35rem;
            background: #ffffff;
            border-radius: 9px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.2);
            text-align: center;
        }

        .publication-delete-box h2 {
            margin: 0 0 1.1rem;
            color: #1b2437;
            font-size: 1.1rem;
        }

        .publication-delete-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.7rem;
        }

        .publication-delete-actions button {
            min-height: 40px;
            border-radius: 7px;
            padding: 0.6rem 0.8rem;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
        }

        .publication-delete-cancel {
            border: 1px solid #1b2437;
            background: #ffffff;
            color: #1b2437;
        }

        .publication-delete-accept {
            border: 1px solid #1b2437;
            background: #1b2437;
            color: #ffffff;
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

<div class="publication-delete-modal" id="publicationDeleteModal" role="dialog" aria-modal="true" aria-labelledby="publicationDeleteTitle">
    <div class="publication-delete-box">
        <h2 id="publicationDeleteTitle">Are you sure you want to delete this publication?</h2>
        <div class="publication-delete-actions">
            <button type="button" class="publication-delete-cancel" id="publicationDeleteCancel">Cancel</button>
            <button type="button" class="publication-delete-accept" id="publicationDeleteAccept">Accept</button>
        </div>
    </div>
</div>

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
    const publicationDeleteModal = document.getElementById('publicationDeleteModal');
    const publicationDeleteCancel = document.getElementById('publicationDeleteCancel');
    const publicationDeleteAccept = document.getElementById('publicationDeleteAccept');

    let currentUser = null;
    let publicationToDelete = null;

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

    function closePublicationMenus() {
        publicationsGrid.querySelectorAll('.publication-menu.is-open').forEach((menu) => {
            menu.classList.remove('is-open');
            menu.parentElement?.querySelector('[data-publication-menu]')?.setAttribute('aria-expanded', 'false');
        });
    }

    function setPublicationEditMode(card, isEditing) {
        const review = card.querySelector('.publication-review');
        const editForm = card.querySelector('[data-publication-edit-form]');

        review.style.display = isEditing ? 'none' : '';
        editForm.hidden = !isEditing;
    }

    async function updateUserPublication(publication, card, saveButton) {
        const ratingInput = card.querySelector('[data-publication-rating]');
        const reviewInput = card.querySelector('[data-publication-review]');
        const rating = Number(ratingInput.value);
        const review = reviewInput.value.trim();

        if (!Number.isFinite(rating) || rating < 0 || rating > 5) {
            showMessage(nameMessage, 'error', 'Rating must be between 0 and 5.');
            return;
        }

        if (review.length < 3 || review.length > 255) {
            showMessage(nameMessage, 'error', 'Review must contain between 3 and 255 characters.');
            return;
        }

        saveButton.disabled = true;

        try {
            const response = await fetch(`/api/publications/${publication.publicationId}`, {
                method: 'PUT',
                headers: apiHeaders(),
                body: JSON.stringify({
                    productId: publication.productId,
                    rating,
                    review,
                }),
            });

            if (response.status === 401) {
                logoutLocal();
                window.location.href = '/';
                return;
            }

            if (!response.ok) {
                const data = await response.json().catch(() => ({}));
                throw new Error(data.message || data.error || 'Unable to update the publication.');
            }

            clearMessage(nameMessage);
            await loadUserPublications();
        } catch (error) {
            showMessage(nameMessage, 'error', error.message || 'Unable to update the publication.');
        } finally {
            saveButton.disabled = false;
        }
    }

    function openPublicationDeleteConfirmation(publication) {
        publicationToDelete = publication;
        publicationDeleteModal.classList.add('is-open');
    }

    function closePublicationDeleteConfirmation() {
        publicationDeleteModal.classList.remove('is-open');
        publicationToDelete = null;
    }

    async function deleteUserPublication() {
        if (!publicationToDelete) {
            return;
        }

        publicationDeleteAccept.disabled = true;

        try {
            const response = await fetch(`/api/publications/${publicationToDelete.publicationId}`, {
                method: 'DELETE',
                headers: apiHeaders(),
            });

            if (response.status === 401) {
                logoutLocal();
                window.location.href = '/';
                return;
            }

            if (!response.ok) {
                const data = await response.json().catch(() => ({}));
                throw new Error(data.message || data.error || 'Unable to delete the publication.');
            }

            closePublicationDeleteConfirmation();
            await loadUserPublications();
        } catch (error) {
            closePublicationDeleteConfirmation();
            showMessage(nameMessage, 'error', error.message || 'Unable to delete the publication.');
        } finally {
            publicationDeleteAccept.disabled = false;
        }
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

                    <div class="publication-management">
                        <button type="button" class="publication-menu-button" data-publication-menu title="Publication options" aria-label="Publication options" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <circle cx="12" cy="5" r="1.6" />
                                <circle cx="12" cy="12" r="1.6" />
                                <circle cx="12" cy="19" r="1.6" />
                            </svg>
                        </button>
                        <div class="publication-menu">
                            <button type="button" class="publication-menu-item" data-edit-publication title="Edit publication">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4 16.5-.8 3.3a1 1 0 0 0 1.2 1.2l3.3-.8L19 9a2.1 2.1 0 0 0-3-3L4 16.5Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.5 7.5 2 2" />
                                </svg>
                                <span>Edit</span>
                            </button>
                            <button type="button" class="publication-menu-item" data-delete-publication title="Delete publication">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12m-9 0V5.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V7m-7 0 .7 12.2a1.5 1.5 0 0 0 1.5 1.3h3.6a1.5 1.5 0 0 0 1.5-1.3L16 7M10 11v6m4-6v6" />
                                </svg>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>

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

                    <div class="publication-edit-form" data-publication-edit-form hidden>
                        <label>
                            Rating
                            <input type="number" data-publication-rating min="0" max="5" step="0.1" value="${escapeHtml(publication.rating)}">
                        </label>
                        <label>
                            Review
                            <textarea data-publication-review maxlength="255">${escapeHtml(publication.review)}</textarea>
                        </label>
                        <div class="publication-edit-actions">
                            <button type="button" class="publication-edit-cancel" data-publication-edit-cancel>Cancel</button>
                            <button type="button" class="publication-edit-save" data-publication-edit-save>Accept</button>
                        </div>
                    </div>

                </div>
            `;

            const menuButton = card.querySelector('[data-publication-menu]');
            const menu = card.querySelector('.publication-menu');

            menuButton.addEventListener('click', (event) => {
                event.stopPropagation();
                const isOpen = menu.classList.contains('is-open');
                closePublicationMenus();
                menu.classList.toggle('is-open', !isOpen);
                menuButton.setAttribute('aria-expanded', String(!isOpen));
            });

            card.querySelector('[data-edit-publication]').addEventListener('click', () => {
                menu.classList.remove('is-open');
                menuButton.setAttribute('aria-expanded', 'false');
                setPublicationEditMode(card, true);
                card.querySelector('[data-publication-rating]').focus();
            });

            card.querySelector('[data-delete-publication]').addEventListener('click', () => {
                menu.classList.remove('is-open');
                menuButton.setAttribute('aria-expanded', 'false');
                openPublicationDeleteConfirmation(publication);
            });

            card.querySelector('[data-publication-edit-cancel]').addEventListener('click', () => {
                card.querySelector('[data-publication-rating]').value = publication.rating;
                card.querySelector('[data-publication-review]').value = publication.review;
                setPublicationEditMode(card, false);
            });

            card.querySelector('[data-publication-edit-save]').addEventListener('click', (event) => {
                updateUserPublication(publication, card, event.currentTarget);
            });

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

    publicationDeleteCancel.addEventListener('click', closePublicationDeleteConfirmation);
    publicationDeleteAccept.addEventListener('click', deleteUserPublication);

    publicationDeleteModal.addEventListener('click', (event) => {
        if (event.target === publicationDeleteModal) {
            closePublicationDeleteConfirmation();
        }
    });

    document.addEventListener('click', (event) => {
        if (!event.target.closest('.publication-management')) {
            closePublicationMenus();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            if (publicationDeleteModal.classList.contains('is-open')) {
                closePublicationDeleteConfirmation();
            } else {
                closePublicationMenus();
            }
        }
    });

    loadProfile();
</script>

</body>
</html>
