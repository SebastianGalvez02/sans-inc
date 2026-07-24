<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Publication - Sans Inc</title>
    <link rel="icon" type="image/png" href="{{ asset('sans-favicon.png') }}">
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
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        .page {
            width: 100%;
             max-width: 980px;
            margin: 2.75rem auto 3rem;
            padding: 0 1rem;
            flex: 1;
        }

        .page-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 1rem;
        }

        .publication-rect {
            width: 100%;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
        }

        .publication-section {
            width: 100%;
            max-width: 620px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.65rem;
            text-align: center;
        }

        .publication-section label {
            width: 100%;
            text-align: center;
            font-weight: 600;
            color: #374151;
        }

        .publication-control,
        .publication-section textarea,
        .publication-section input[type="number"],
        .publication-section input[type="text"] {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            color: #111827;
            background: #ffffff;
            outline: none;
        }

        .publication-control:focus,
        .publication-section textarea:focus,
        .publication-section input[type="number"]:focus,
        .publication-section input[type="text"]:focus {
            border-color: #1b2437;
            box-shadow: 0 0 0 3px rgba(27, 36, 55, 0.12);
        }

        .image-dropzone {
            position: relative;
            width: 100%;
            min-height: 280px;
            background: #f0f0f0;
            border: 2px dashed #cbd5e1;
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color 0.2s ease, background-color 0.2s ease;
        }

        .image-dropzone.is-dragover {
            border-color: #1b2437;
            background: #e8edf6;
        }

        .image-dropzone img {
            width: 100%;
            max-height: 360px;
            object-fit: cover;
            display: block;
        }

        .image-change-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: background-color 0.2s ease, opacity 0.2s ease;
            pointer-events: none;
        }

        .image-change-overlay span {
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 600;
            background: rgba(0, 0, 0, 0.5);
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
        }

        .image-dropzone.has-preview:hover .image-change-overlay {
            background: rgba(0, 0, 0, 0.2);
            opacity: 1;
        }

        .image-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            color: #9ca3af;
            transition: color 0.2s ease;
            padding: 4rem 1rem;
        }

        .image-dropzone:hover .image-placeholder {
            color: #1a2332;
        }

        .image-dropzone:hover .image-placeholder svg {
            color: #1a2332;
        }

        .image-placeholder svg {
            width: 3rem;
            height: 3rem;
        }

        .image-placeholder p {
            margin: 0;
        }

        .small {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .suggestions {
            position: relative;
            width: 100%;
        }

        .suggestions-list {
            position: absolute;
            top: calc(100% + 0.35rem);
            left: 0;
            right: 0;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            max-height: 220px;
            overflow: auto;
            z-index: 50;
            text-align: left;
        }

        .suggestion-item {
            padding: 0.75rem 0.95rem;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background: #f3f6ff;
        }

        .actions {
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .actions #loggedActions {
            width: 100%;
            flex-direction: row !important;
            gap: 0.75rem;
        }

        .actions #loggedActions .btn {
            flex: 1 1 0;
        }

        .btn {
            width: 100%;
            padding: 0.95rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            border: 0;
        }

        .btn-cancel {
            background: #ffffff;
            color: #1b2437;
            border: 2px solid #1b2437;
        }

        .btn-publish {
            background: #1b2437;
            color: #ffffff;
            border: 2px solid #1b2437;
        }

        .btn-login-inline {
            width: 100%;
            background: #1a2332;
            color: #ffffff;
            padding: 0.95rem 1.2rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-login-inline:hover {
            background: #2a3442;
        }

        .publication-message-modal {
            position: fixed;
            inset: 0;
            z-index: 600;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(15, 23, 42, 0.48);
        }

        .publication-message-modal.is-open {
            display: flex;
        }

        .publication-message-box {
            width: min(100%, 390px);
            padding: 1.5rem;
            background: #ffffff;
            border: 1px solid #d8dde6;
            border-radius: 10px;
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.24);
            text-align: center;
        }

        .publication-message-box h2 {
            margin: 0 0 1.25rem;
            color: #1b2437;
            font-size: 1.15rem;
        }

        .publication-message-box p {
            margin: -0.55rem 0 1.25rem;
            color: #475569;
            line-height: 1.45;
        }

        .publication-message-button {
            width: 100%;
            min-height: 42px;
            border: 1px solid #1b2437;
            border-radius: 8px;
            background: #1b2437;
            color: #ffffff;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
        }

        .publication-message-button:hover {
            background: #2a3442;
        }

        @media (max-width: 640px) {
            .page {
                margin-top: 1.75rem;
            }

            .page-title {
                font-size: 1.65rem;
            }

            .publication-rect {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

<x-navbar />

<x-login-panel>
    <form data-login-form>
        <div class="panel-message" data-login-message></div>
        <input type="email" name="email" class="panel-input" placeholder="Email" required />
        <input type="password" name="password" class="panel-input" placeholder="Password" required />

        <button type="submit" class="btn-login" data-login-submit>Log In</button>
        <a href="/register" class="btn-register">Sign Up</a>
        <a href="/recuperar" class="panel-recover">Forgot password</a>
    </form>
</x-login-panel>

<div class="page">
    <h1 class="page-title">New Publication</h1>

    <div class="publication-rect" id="publication-card">
            <div class="publication-section">
                <label>Upload image</label>
                <div class="image-dropzone" id="imageDropzone">
                    <div class="image-placeholder" id="imagePlaceholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 16V8m0 0-3 3m3-3 3 3M4 16.5A4.5 4.5 0 0 1 8.5 12h.5A6 6 0 0 1 19 9.5 4.5 4.5 0 0 1 18.5 18H8.5A4.5 4.5 0 0 1 4 13.5Z" />
                        </svg>
                        <p class="small">Click or drag an image here</p>
                        <p class="small">PNG, JPG, WEBP</p>
                    </div>
                    <img id="imagePreview" alt="Preview" style="display:none;" />
                    <div class="image-change-overlay" id="imageChangeOverlay">
                        <span>Change image</span>
                    </div>
                    <input type="file" id="imageInput" accept="image/*" hidden />
                </div>
            </div>

            <div class="publication-section">
                <label for="productInput">Product</label>
                <div class="suggestions">
                    <input type="text" id="productInput" autocomplete="off" class="publication-control" placeholder="Type to search..." />
                    <div id="suggestions" class="suggestions-list" style="display:none"></div>
                </div>
                <input type="hidden" id="selectedProductId" />
            </div>

            <div class="publication-section">
                <label for="ratingInput">Rating</label>
                <input type="number" id="ratingInput" class="publication-control" min="0" max="5" step="0.1" value="5" />
            </div>

            <div class="publication-section">
                <label for="reviewInput">Review</label>
                <textarea id="reviewInput" class="publication-control" rows="5" maxlength="255" style="resize:vertical;"></textarea>
                <div class="small" style="text-align:right; width:100%;"><span id="charsLeft">255</span> characters remaining</div>
            </div>

            <div class="actions">
                <div id="notLoggedActions"></div>
                <div id="loggedActions" style="display:none;"></div>
            </div>
    </div>
</div>

<div class="publication-message-modal" id="publicationMessageModal" role="dialog" aria-modal="true" aria-labelledby="publicationMessageTitle">
    <div class="publication-message-box">
        <h2 id="publicationMessageTitle">Publication</h2>
        <p id="publicationMessageText"></p>
        <button type="button" class="publication-message-button" id="publicationMessageButton">Accept</button>
    </div>
</div>

<x-footer />


<script>
    const imageInput = document.getElementById('imageInput');
    const imageDropzone = document.getElementById('imageDropzone');
    const imagePreview = document.getElementById('imagePreview');
    const imagePlaceholder = document.getElementById('imagePlaceholder');
    const publicationMessageModal = document.getElementById('publicationMessageModal');
    const publicationMessageTitle = document.getElementById('publicationMessageTitle');
    const publicationMessageText = document.getElementById('publicationMessageText');
    const publicationMessageButton = document.getElementById('publicationMessageButton');
    let publicationMessageRedirect = null;

    function showPublicationMessage(message, redirect = null) {
        publicationMessageRedirect = redirect;
        publicationMessageTitle.textContent = redirect ? 'Publication created successfully' : 'Publication notice';
        publicationMessageText.textContent = message;
        publicationMessageText.style.display = message ? 'block' : 'none';
        publicationMessageModal.classList.add('is-open');
    }

    publicationMessageButton.addEventListener('click', () => {
        publicationMessageModal.classList.remove('is-open');

        if (publicationMessageRedirect) {
            window.location.href = publicationMessageRedirect;
        }
    });

    function showImagePreview(file) {
        if (!file) {
            imagePreview.src = '';
            imagePreview.style.display = 'none';
            imagePlaceholder.style.display = 'flex';
            imageDropzone.classList.remove('has-preview');
            return;
        }

        const url = URL.createObjectURL(file);
        imagePreview.src = url;
        imagePreview.style.display = 'block';
        imagePlaceholder.style.display = 'none';
        imageDropzone.classList.add('has-preview');
        imagePreview.onload = function () {
            URL.revokeObjectURL(url);
        };
    }

    imageDropzone.addEventListener('click', function () {
        imageInput.click();
    });

    imageInput.addEventListener('change', function (e) {
        showImagePreview(e.target.files[0]);
    });

    imageDropzone.addEventListener('dragover', function (e) {
        e.preventDefault();
        imageDropzone.classList.add('is-dragover');
    });

    imageDropzone.addEventListener('dragleave', function (e) {
        if (!imageDropzone.contains(e.relatedTarget)) {
            imageDropzone.classList.remove('is-dragover');
        }
    });

    imageDropzone.addEventListener('drop', function (e) {
        e.preventDefault();
        imageDropzone.classList.remove('is-dragover');
        const file = e.dataTransfer.files && e.dataTransfer.files[0];
        if (!file) {
            return;
        }

        imageInput.files = e.dataTransfer.files;
        showImagePreview(file);
    });

    // Fetch products once and use for autocomplete
    let products = [];
    fetch('/api/products').then(r=>r.json()).then(data=>{ products = data; }).catch(()=>{ products = []; });

    const productInput = document.getElementById('productInput');
    const suggestionsEl = document.getElementById('suggestions');

    productInput.addEventListener('input', function(){
        const q = this.value.trim().toLowerCase();
        if (!q) { suggestionsEl.style.display='none'; return; }
        const matches = products.filter(p => (p.name || '').toLowerCase().includes(q)).slice(0,10);
        if (matches.length === 0) { suggestionsEl.style.display='none'; return; }
        suggestionsEl.innerHTML = '';
        matches.forEach(m=>{
            const div = document.createElement('div');
            div.className = 'suggestion-item';
            div.textContent = m.name;
            div.dataset.id = m.productId ?? m.id ?? '';
            div.addEventListener('click', ()=>{
                productInput.value = m.name;
                document.getElementById('selectedProductId').value = div.dataset.id;
                suggestionsEl.style.display='none';
            });
            suggestionsEl.appendChild(div);
        });
        suggestionsEl.style.display='block';
    });

    document.addEventListener('click', function(e){
        if (!e.target.closest('.suggestions')) suggestionsEl.style.display='none';
    });

    // Review char counter
    const reviewInput = document.getElementById('reviewInput');
    const charsLeft = document.getElementById('charsLeft');
    reviewInput.addEventListener('input', ()=>{
        const max = reviewInput.getAttribute('maxlength');
        charsLeft.textContent = max - reviewInput.value.length;
    });

    // Determine logged state by presence of JWT in localStorage (key: jwtToken)
    function updateActions(){
        const token = localStorage.getItem('jwtToken');
        const notLogged = document.getElementById('notLoggedActions');
        const logged = document.getElementById('loggedActions');
        if (!token) {
            notLogged.innerHTML = '<button type="button" class="btn-login-inline" onclick="abrirPanel()">Log In</button>';
            logged.style.display='none';
        } else {
            notLogged.innerHTML = '';
            logged.style.display='flex';
            logged.innerHTML = '<button type="button" class="btn btn-cancel" id="cancelBtn">Cancel</button><button type="button" class="btn btn-publish" id="publishBtn">Publish</button>';
            document.getElementById('cancelBtn').addEventListener('click', ()=>{
                window.location.href = '/';
            });
            document.getElementById('publishBtn').addEventListener('click', publish);
        }
    }

    updateActions();

    async function publish(){
        const productId = document.getElementById('selectedProductId').value;
        const rating = parseFloat(document.getElementById('ratingInput').value);
        const review = document.getElementById('reviewInput').value;
        if (!productId) {
            showPublicationMessage('Select a product from the list.');
            return;
        }
        const token = localStorage.getItem('jwtToken');
        if (!token) { abrirPanel(); return; }
        try{
            const res = await fetch('/api/publications', {
                method:'POST',
                headers:{ 'Content-Type':'application/json', 'Authorization':'Bearer '+token },
                body: JSON.stringify({ productId: parseInt(productId), rating, review })
            });
            if (res.status === 201) {
                await res.json();
                showPublicationMessage('', '/');
            } else {
                const err = await res.json();
                showPublicationMessage('Error: ' + (err.message || JSON.stringify(err)));
            }
        } catch(e){ showPublicationMessage('Error connecting to the API'); }
    }

    // Refresh actions if user logs in/out in another tab
    window.addEventListener('storage', updateActions);
    window.addEventListener('sans-auth-changed', updateActions);
</script>

</body>
</html>
