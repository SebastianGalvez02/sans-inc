<footer class="sans-footer">
    <div class="sans-footer__container">

        {{-- Información general de la empresa --}}
        <div class="sans-footer__section sans-footer__brand">
            <a href="/" class="sans-footer__logo">Sans Inc</a>

            <p class="sans-footer__description">
                Plataforma web de reseñas de productos.
            </p>
        </div>

        {{-- Información de contacto --}}
        <div class="sans-footer__section">
            <h2 class="sans-footer__title">Contacto</h2>

            <p class="sans-footer__item">
                <span class="sans-footer__label">Teléfono</span>

                <a href="tel:+56978234591" class="sans-footer__link">
                    +56 9 7823 4591
                </a>
            </p>

            <p class="sans-footer__item">
                <span class="sans-footer__label">Correo electrónico</span>

                <a
                    href="mailto:sans.inc.contacto@gmail.com"
                    class="sans-footer__link"
                >
                    sans.inc.contacto@gmail.com
                </a>
            </p>

            <p class="sans-footer__item">
                <span class="sans-footer__label">Fax</span>
                <span>+56 55 2634 720</span>
            </p>
        </div>

        {{-- Dirección física --}}
        <div class="sans-footer__section">
            <h2 class="sans-footer__title">Ubicación</h2>

            <address class="sans-footer__address">
                <strong>Universidad de Antofagasta (UA)</strong>

                <span>Campus principal</span>

                <span>
                    Subsuelo 69 – Av. Angamos 0610,
                    Antofagasta, Chile
                </span>

                <span class="sans-footer__coordinates">
                    23°39'14"S 70°24'18"O
                </span>
            </address>
        </div>

    </div>

    <div class="sans-footer__bottom">
        <p>
            &copy; {{ date('Y') }} Sans Inc.
            Todos los derechos reservados.
        </p>

        <p>Proyecto Integrador de Software</p>
    </div>
</footer>

<style>
    .sans-footer {
        width: 100%;
        margin-top: auto;
        background-color: #1b2437;
        border-top: 3px solid #315df4;
        color: #cbd5e1;
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    .sans-footer__container {
        width: min(1200px, calc(100% - 4rem));
        margin: 0 auto;
        padding: 2.5rem 0 2rem;
        display: grid;
        grid-template-columns: 1fr 1fr 1.3fr;
        gap: 3rem;
    }

    .sans-footer__section {
        min-width: 0;
    }

    .sans-footer__logo {
        display: inline-block;
        margin-bottom: 0.85rem;
        color: #ffffff;
        font-size: 1.35rem;
        font-weight: 700;
        letter-spacing: 0.2px;
        text-decoration: none;
    }

    .sans-footer__logo:hover {
        color: #b8c5ff;
    }

    .sans-footer__description {
        max-width: 280px;
        margin: 0;
        color: #aeb9cc;
        font-size: 0.94rem;
        line-height: 1.6;
    }

    .sans-footer__title {
        margin: 0 0 1rem;
        color: #ffffff;
        font-size: 1rem;
        font-weight: 700;
    }

    .sans-footer__item {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
        margin: 0 0 0.85rem;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .sans-footer__label {
        color: #8fa0bd;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .sans-footer__link {
        color: #dce5f5;
        text-decoration: none;
        overflow-wrap: anywhere;
        transition: color 0.2s;
    }

    .sans-footer__link:hover {
        color: #8ba4ff;
        text-decoration: underline;
    }

    .sans-footer__address {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
        color: #cbd5e1;
        font-size: 0.9rem;
        font-style: normal;
        line-height: 1.5;
    }

    .sans-footer__address strong {
        color: #ffffff;
    }

    .sans-footer__coordinates {
        color: #8fa0bd;
        font-size: 0.82rem;
    }

    .sans-footer__bottom {
        width: min(1200px, calc(100% - 4rem));
        margin: 0 auto;
        padding: 1rem 0;
        border-top: 1px solid #344057;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        color: #8fa0bd;
        font-size: 0.8rem;
    }

    .sans-footer__bottom p {
        margin: 0;
    }

    @media (max-width: 850px) {
        .sans-footer__container {
            grid-template-columns: repeat(2, 1fr);
        }

        .sans-footer__brand {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 640px) {
        .sans-footer__container {
            width: calc(100% - 2rem);
            padding: 2rem 0 1.5rem;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .sans-footer__brand {
            grid-column: auto;
        }

        .sans-footer__bottom {
            width: calc(100% - 2rem);
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>