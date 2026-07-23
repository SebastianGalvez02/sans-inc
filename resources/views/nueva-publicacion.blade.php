<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva publicación - Sans Inc</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        .page {
            max-width: 980px;
            margin: 2.75rem auto 3rem;
            padding: 0 1rem;
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
        <input type="email" name="email" class="panel-input" placeholder="Correo electrónico" required />
        <input type="password" name="password" class="panel-input" placeholder="Contraseña" required />

        <button type="submit" class="btn-login" data-login-submit>Iniciar Sesión</button>
        <a href="/register" class="btn-register">Registrarse</a>
        <a href="/recuperar" class="panel-recover">Recuperar contraseña</a>
    </form>
</x-login-panel>

<div class="page">
    <h1 class="page-title">Nueva publicación</h1>

    <div class="publication-rect" id="publication-card">
            <div class="publication-section">
                <label>Subir imagen</label>
                <div class="image-dropzone" id="imageDropzone">
                    <div class="image-placeholder" id="imagePlaceholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 16V8m0 0-3 3m3-3 3 3M4 16.5A4.5 4.5 0 0 1 8.5 12h.5A6 6 0 0 1 19 9.5 4.5 4.5 0 0 1 18.5 18H8.5A4.5 4.5 0 0 1 4 13.5Z" />
                        </svg>
                        <p class="small">Haz clic o arrastra una imagen aquí</p>
                        <p class="small">PNG, JPG, WEBP</p>
                    </div>
                    <img id="imagePreview" alt="Vista previa" style="display:none;" />
                    <div class="image-change-overlay" id="imageChangeOverlay">
                        <span>Cambiar imagen</span>
                    </div>
                    <input type="file" id="imageInput" accept="image/*" hidden />
                </div>
            </div>

            <div class="publication-section">
                <label for="productInput">Producto</label>
                <div class="suggestions">
                    <input type="text" id="productInput" autocomplete="off" class="publication-control" placeholder="Escribe para buscar..." />
                    <div id="suggestions" class="suggestions-list" style="display:none"></div>
                </div>
                <input type="hidden" id="selectedProductId" />
            </div>

            <div class="publication-section">
                <label for="ratingInput">Rating</label>
                <input type="number" id="ratingInput" class="publication-control" min="0" max="5" step="0.1" value="5" />
            </div>

            <div class="publication-section">
                <label for="reviewInput">Reseña</label>
                <textarea id="reviewInput" class="publication-control" rows="5" maxlength="255" style="resize:vertical;"></textarea>
                <div class="small" style="text-align:right; width:100%;"><span id="charsLeft">255</span> caracteres restantes</div>
            </div>

            <div class="actions">
                <div id="notLoggedActions"></div>
                <div id="loggedActions" style="display:none; flex-direction:column; gap:0.75rem;"></div>
            </div>
    </div>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const imageDropzone = document.getElementById('imageDropzone');
    const imagePreview = document.getElementById('imagePreview');
    const imagePlaceholder = document.getElementById('imagePlaceholder');

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
            notLogged.innerHTML = '<button type="button" class="btn-login-inline" onclick="abrirPanel()">Iniciar Sesión</button>';
            logged.style.display='none';
        } else {
            notLogged.innerHTML = '';
            logged.style.display='flex';
            logged.innerHTML = '<button type="button" class="btn btn-cancel" id="cancelBtn">Cancelar</button><button type="button" class="btn btn-publish" id="publishBtn">Publicar</button>';
            document.getElementById('cancelBtn').addEventListener('click', ()=>{
                document.getElementById('publication-card').querySelectorAll('input,textarea').forEach(i=>i.value='');
                document.getElementById('ratingInput').value = '5';
                document.getElementById('charsLeft').textContent = '255';
                imageInput.value = '';
                showImagePreview(null);
                document.getElementById('selectedProductId').value = '';
            });
            document.getElementById('publishBtn').addEventListener('click', publish);
        }
    }

    updateActions();

    async function publish(){
        const productId = document.getElementById('selectedProductId').value;
        const rating = parseFloat(document.getElementById('ratingInput').value);
        const review = document.getElementById('reviewInput').value;
        if (!productId) { alert('Selecciona un producto de la lista.'); return; }
        const token = localStorage.getItem('jwtToken');
        if (!token) { abrirPanel(); return; }
        try{
            const res = await fetch('/api/publications', {
                method:'POST',
                headers:{ 'Content-Type':'application/json', 'Authorization':'Bearer '+token },
                body: JSON.stringify({ productId: parseInt(productId), rating, review })
            });
            if (res.status === 201) {
                const data = await res.json();
                alert('Publicación creada correctamente');
                window.location.href = '/';
            } else {
                const err = await res.json();
                alert('Error: ' + (err.message || JSON.stringify(err)));
            }
        } catch(e){ alert('Error al conectar con la API'); }
    }

    // Refresh actions if user logs in/out in another tab
    window.addEventListener('storage', updateActions);
    window.addEventListener('sans-auth-changed', updateActions);
</script>

</body>
</html>
