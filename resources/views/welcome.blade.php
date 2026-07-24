<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sans Inc</title>
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

        body.publication-detail-open {
            overflow: hidden;
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

        .filter-control {
            position: relative;
        }

        .category-filter-menu {
            position: absolute;
            top: calc(100% + 0.45rem);
            right: 0;
            z-index: 200;
            display: none;
            width: min(250px, 80vw);
            max-height: 280px;
            overflow-y: auto;
            padding: 0.4rem;
            background: #ffffff;
            border: 1px solid #d8dde6;
            border-radius: 8px;
            box-shadow: 0 10px 24px rgba(15, 27, 51, 0.16);
        }

        .category-filter-menu.is-open {
            display: grid;
            gap: 0.2rem;
        }

        .category-filter-option {
            width: 100%;
            padding: 0.65rem 0.75rem;
            border: 0;
            border-radius: 6px;
            background: #ffffff;
            color: #1a2332;
            font: inherit;
            font-size: 0.88rem;
            text-align: left;
            cursor: pointer;
        }

        .category-filter-option:hover,
        .category-filter-option.is-active {
            background: #f1f5f9;
            color: #1b2437;
            font-weight: 700;
        }

        .category-filter-status {
            margin: 0;
            padding: 0.65rem 0.75rem;
            color: #64748b;
            font-size: 0.84rem;
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
            cursor: pointer;
            transition: background-color 160ms ease, color 160ms ease;
        }

        .publication-image-placeholder:hover {
            background: linear-gradient(135deg, #e9eef6, #d2dbe8);
            color: #1a2332;
        }

        .publication-detail {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 90;
            overflow-y: auto;
            padding: 1.6rem 1rem 3rem;
            background: #eef0f4;
            animation: publication-expand 220ms ease-out;
        }

        .publication-card.is-expanded .publication-detail {
            display: block;
        }

        .publication-detail-panel {
            width: min(100%, 864px);
            margin: 0 auto;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #d8dde6;
            border-radius: 9px;
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.24);
        }

        .publication-detail-back {
            display: inline-block;
            min-height: 34px;
            padding: 0.35rem 0;
            border: 0;
            border-radius: 0;
            background: transparent;
            color: #1a2332;
            font: inherit;
            cursor: pointer;
        }

        .publication-detail-shell {
            width: min(100%, 864px);
            margin: 0 auto;
        }

        .publication-detail-shell > .publication-detail-back {
            margin: 0 0 1rem;
            padding-left: 0;
            font-size: 0.98rem;
            font-weight: 600;
        }

        .publication-detail-back:hover {
            color: #315df4;
        }

        @keyframes publication-expand {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .publication-expanded-image {
            min-height: 500px;
            background: linear-gradient(135deg, #eef2f7, #d5dee9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 1.05rem;
            font-weight: 700;
            text-align: center;
        }

        .publication-expanded-data {
            padding: 1.5rem 1.5rem 1.25rem;
            background: #ffffff;
        }

        .publication-detail-meta {
            padding: 1.25rem 1.5rem 1.1rem;
            background: #ffffff;
        }

        .publication-detail-meta .publication-user,
        .publication-detail-meta .publication-date {
            margin: 0;
        }

        .publication-detail-meta .publication-user {
            font-size: 1rem;
        }

        .publication-detail-meta .publication-date {
            margin-top: 0.25rem;
        }

        .publication-expanded-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.9rem;
        }

        .publication-expanded-data h3 {
            margin: 0 0 0.7rem;
            color: #020617;
            font-size: 1.35rem;
        }

        .publication-expanded-data p {
            margin: 0.3rem 0;
            color: #334155;
            line-height: 1.5;
        }

        .publication-expanded-data strong {
            color: #0f1b33;
        }

        .publication-expanded-data > p:nth-of-type(-n + 3) {
            display: none;
        }

        .publication-expanded-data > p:last-child {
            margin-top: 0;
            color: #243b63;
            font-size: 1rem;
        }

        .comments-section {
            scroll-margin-top: 90px;
            padding: 1.1rem;
            border-top: 1px solid #d8dde6;
            background: #f8fafc;
        }

        .comments-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.7rem;
            margin-bottom: 0.8rem;
        }

        .comments-heading h3 {
            margin: 0;
            color: #0f1b33;
            font-size: 1.1rem;
        }

        .comments-heading span {
            color: #64748b;
            font-size: 0.86rem;
            font-weight: 700;
        }

        .comment-composer {
            padding: 0;
            background: transparent;
            border: 0;
            border-radius: 0;
        }

        .comment-composer textarea {
            width: 100%;
            min-height: 50px;
            height: 50px;
            overflow: hidden;
            resize: none;
            border: 1px solid #cfd5df;
            border-radius: 9px;
            background: #ffffff;
            padding: 0.85rem 1rem;
            outline: 0;
            color: #111827;
            font: inherit;
            font-size: 1rem;
            line-height: 1.4;
            transition: border-color 160ms ease, box-shadow 160ms ease;
        }

        .comment-composer textarea:focus {
            border-color: #1a2332;
            box-shadow: 0 0 0 3px rgba(26, 35, 50, 0.12);
        }

        .comment-composer textarea::placeholder {
            color: #7f8794;
        }

        .comment-composer textarea[readonly] {
            cursor: pointer;
        }

        .comment-composer-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.7rem;
            padding-top: 0.6rem;
            border-top: 1px solid #e2e8f0;
        }

        .comment-character-count {
            color: #64748b;
            font-size: 0.82rem;
            font-variant-numeric: tabular-nums;
        }

        .comment-submit {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border: 0;
            border-radius: 7px;
            padding: 0.55rem 0.8rem;
            background: #1a2332;
            color: #ffffff;
            font-weight: 700;
            cursor: pointer;
        }

        .comment-submit:hover {
            background: #2a3442;
        }

        .comment-submit:disabled {
            cursor: wait;
            opacity: 0.55;
        }

        .comment-error,
        .comments-error {
            display: none;
            margin: 0.6rem 0 0;
            color: #b42318;
            font-size: 0.86rem;
        }

        .comments-list {
            display: grid;
            gap: 0.7rem;
            margin-top: 0.9rem;
        }

        .comments-loading,
        .comments-empty {
            margin: 0;
            padding: 0.8rem;
            color: #64748b;
            text-align: center;
            font-size: 0.9rem;
        }

        .comment-item {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            padding: 0.8rem;
            background: #ffffff;
            border: 1px solid #d8dde6;
            border-radius: 8px;
        }

        .comment-item-content {
            min-width: 0;
            flex: 1;
        }

        .comment-item-header {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 0.8rem;
            margin-bottom: 0.25rem;
        }

        .comment-author {
            color: #0f1b33;
            font-size: 0.9rem;
            font-weight: 800;
        }

        .comment-date {
            color: #94a3b8;
            font-size: 0.76rem;
            white-space: nowrap;
        }

        .comment-text {
            margin: 0;
            color: #334155;
            line-height: 1.45;
            overflow-wrap: anywhere;
        }

        .comment-actions {
            position: relative;
            flex: 0 0 auto;
        }

        .comment-menu-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #1b2437 !important;
            cursor: pointer;
        }

        .comment-menu-button:hover,
        .comment-menu-button[aria-expanded="true"] {
            background: #eef2ff;
            color: #1b2437;
        }

        .comment-menu-button svg {
            width: 21px;
            height: 21px;
            color: #1b2437;
            fill: #1b2437;
        }

        .comment-menu {
            position: absolute;
            top: calc(100% + 0.25rem);
            right: 0;
            z-index: 4;
            display: none;
            min-width: 130px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #d8dde6;
            border-radius: 7px;
            box-shadow: 0 8px 20px rgba(15, 27, 51, 0.16);
        }

        .comment-menu.is-open {
            display: grid;
        }

        .comment-menu-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
            min-height: 38px;
            padding: 0.55rem 0.7rem;
            border: 0;
            background: #ffffff;
            color: #1a2332;
            font: inherit;
            font-size: 0.86rem;
            text-align: left;
            cursor: pointer;
        }

        .comment-menu-item:hover {
            background: #f4f7fb;
        }

        .comment-menu-item[data-delete-comment] {
            color: #b42318;
        }

        .comment-menu-item svg {
            width: 17px;
            height: 17px;
            flex: 0 0 auto;
        }

        .comment-edit-form {
            display: grid;
            gap: 0.55rem;
            margin-top: 0.45rem;
        }

        .comment-edit-form[hidden] {
            display: none;
        }

        .comment-edit-input {
            width: 100%;
            min-height: 50px;
            border: 1px solid #cfd5df;
            border-radius: 9px;
            padding: 0.7rem 0.8rem;
            background: #ffffff;
            color: #111827;
            font: inherit;
            line-height: 1.4;
            outline: none;
            resize: vertical;
        }

        .comment-edit-input:focus {
            border-color: #1a2332;
            box-shadow: 0 0 0 3px rgba(26, 35, 50, 0.12);
        }

        .comment-edit-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .comment-edit-actions button {
            min-height: 32px;
            border-radius: 6px;
            padding: 0.4rem 0.65rem;
            font: inherit;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
        }

        .comment-edit-cancel {
            border: 1px solid #1b2437;
            background: #ffffff;
            color: #1b2437;
        }

        .comment-edit-save {
            border: 1px solid #1b2437;
            background: #1b2437;
            color: #ffffff;
        }

        .comment-edit-cancel:hover {
            background: #f4f7fb;
        }

        .comment-edit-save:hover {
            background: #2a3442;
        }

        .comment-confirm-modal {
            position: fixed;
            inset: 0;
            z-index: 600;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(15, 23, 42, 0.42);
        }

        .comment-confirm-modal.is-open {
            display: flex;
        }

        .comment-confirm-box {
            width: min(100%, 390px);
            padding: 1.35rem;
            background: #ffffff;
            border-radius: 9px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.2);
        }

        .comment-confirm-box h2 {
            margin: 0 0 1.1rem;
            color: #0f1b33;
            font-size: 1.1rem;
            text-align: center;
        }

        .comment-confirm-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.7rem;
        }

        .comment-confirm-actions button {
            min-height: 40px;
            border-radius: 7px;
            padding: 0.6rem 0.8rem;
            font-weight: 700;
            cursor: pointer;
        }

        .comment-cancel-button {
            border: 1px solid #1b2437;
            background: #ffffff;
            color: #1b2437;
        }

        .comment-accept-button {
            border: 1px solid #1b2437;
            background: #1b2437;
            color: #ffffff;
        }

        .comment-cancel-button:hover {
            background: #f4f7fb;
        }

        .comment-accept-button:hover {
            background: #2a3442;
        }

        .comment-confirm-actions button:disabled {
            cursor: wait;
            opacity: 0.6;
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

            .publication-expanded-image {
                min-height: 300px;
            }

            .publication-expanded-data,
            .publication-detail-meta {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .comment-item-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 0.2rem;
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

<main class="feed-page">
    <div class="feed-toolbar">
        <h1 class="feed-title">Reviews Feed</h1>

        <div class="feed-actions">
            <div class="view-toggle" aria-label="Change view">
                <button type="button" class="is-active" id="listViewButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                    </svg>
                    List
                </button>
                <button type="button" id="gridViewButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Grid
                </button>
            </div>

            <div class="filter-control">
                <button type="button" class="filter-button" id="filterButton" aria-expanded="false" aria-controls="categoryFilterMenu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18M6 12h12M10 19h4" />
                    </svg>
                    Filter
                </button>
                <div class="category-filter-menu" id="categoryFilterMenu" role="menu" aria-label="Filter by category"></div>
            </div>
        </div>
    </div>

    <div class="active-filter-bar" id="activeFilterBar">
        <span>Results for: <strong id="activeFilterName"></strong></span>
        <button type="button" id="clearFilterButton">Clear search ✕</button>
    </div>

    <div id="feedList" class="feed-list"></div>
    <div id="emptyFeed" class="empty-feed">No publications available.</div>
    <div id="feedError" class="feed-error">Publications could not be loaded.</div>
</main>

<x-footer />

<div class="login-required-modal" id="loginRequiredModal" role="dialog" aria-modal="true" aria-labelledby="loginRequiredTitle">
    <div class="login-required-box">
        <h2 id="loginRequiredTitle">Please log in first</h2>
        <p>You must log in to like a publication.</p>
        <button type="button" id="loginRequiredButton">Log In</button>
    </div>
</div>

<div class="comment-confirm-modal" id="commentConfirmModal" role="dialog" aria-modal="true" aria-labelledby="commentConfirmTitle">
    <div class="comment-confirm-box">
        <h2 id="commentConfirmTitle">Are you sure you want to delete your comment?</h2>
        <div class="comment-confirm-actions">
            <button type="button" class="comment-cancel-button" id="commentCancelButton">Cancel</button>
            <button type="button" class="comment-accept-button" id="commentAcceptButton">Accept</button>
        </div>
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
    const commentConfirmModal = document.getElementById('commentConfirmModal');
    const commentCancelButton = document.getElementById('commentCancelButton');
    const commentAcceptButton = document.getElementById('commentAcceptButton');
    const activeFilterBar = document.getElementById('activeFilterBar');
    const activeFilterName = document.getElementById('activeFilterName');
    const clearFilterButton = document.getElementById('clearFilterButton');
    const filterButton = document.getElementById('filterButton');
    const categoryFilterMenu = document.getElementById('categoryFilterMenu');

    let currentFilterProductId = null;
    let currentFilterCategoryId = null;
    let expandedPublicationId = null;
    let commentToDelete = null;
    const commentMaxLength = 255;

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
            return 'Date not available';
        }

        const seconds = Math.max(1, Math.floor((Date.now() - date.getTime()) / 1000));
        const units = [
            ['year', 31536000],
            ['month', 2592000],
            ['week', 604800],
            ['day', 86400],
            ['hour', 3600],
            ['minute', 60],
        ];

        for (const [label, amount] of units) {
            const count = Math.floor(seconds / amount);

            if (count >= 1) {
                return `${count} ${label}${count === 1 ? '' : 's'} ago`;
            }
        }

        return 'A few seconds ago';
    }

    function buildProductMap(products) {
        return products.reduce((map, product) => {
            map[product.productId ?? product.id] = product.name;
            return map;
        }, {});
    }

    function renderCategoryFilter(categories, products) {
        const availableCategoryIds = new Set(
            products.map((product) => Number(product.categoryId)).filter(Number.isFinite)
        );
        const categoriesByName = new Map();

        categories.forEach((category) => {
            const categoryId = Number(category.id ?? category.categoryId);
            const categoryName = category.name ?? category.categoryName;

            if (!availableCategoryIds.has(categoryId) || !categoryName) {
                return;
            }

            if (!categoriesByName.has(categoryName)) {
                categoriesByName.set(categoryName, {
                    name: categoryName,
                    ids: [],
                });
            }

            categoriesByName.get(categoryName).ids.push(categoryId);
        });

        const availableCategories = [...categoriesByName.values()];

        if (!availableCategories.length) {
            categoryFilterMenu.innerHTML = '<p class="category-filter-status">No categories available.</p>';
            return;
        }

        categoryFilterMenu.innerHTML = `
            <button type="button" class="category-filter-option ${currentFilterCategoryId === null ? 'is-active' : ''}" data-category-id="" role="menuitem">
                All categories
            </button>
            ${availableCategories.map((category) => {
                const categoryIds = category.ids.join(',');
                const isActive = String(currentFilterCategoryId) === categoryIds;
                return `
                    <button type="button" class="category-filter-option ${isActive ? 'is-active' : ''}" data-category-id="${categoryIds}" role="menuitem">
                        ${escapeHtml(category.name)}
                    </button>
                `;
            }).join('')}
        `;

        categoryFilterMenu.querySelectorAll('[data-category-id]').forEach((button) => {
            button.addEventListener('click', () => {
                const categoryId = button.dataset.categoryId || null;
                const category = availableCategories.find(
                    (item) => item.ids.join(',') === String(categoryId)
                );

                currentFilterProductId = null;
                currentFilterCategoryId = categoryId;
                setFilterUi(category ? { name: category.name } : null);

                const url = new URL(window.location.href);
                url.searchParams.delete('productId');
                url.searchParams.delete('nombre');

                if (category) {
                    url.searchParams.set('categoryId', categoryId);
                    url.searchParams.set('categoryName', category.name);
                } else {
                    url.searchParams.delete('categoryId');
                    url.searchParams.delete('categoryName');
                }

                window.history.pushState({}, '', url);
                categoryFilterMenu.classList.remove('is-open');
                filterButton.setAttribute('aria-expanded', 'false');
                loadPublications(null, categoryId);
            });
        });
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

        return `user_${publication.userId}`;
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
            alert('Unable to update the like. Please try again.');
        } finally {
            button.disabled = false;
        }
    }

    function getCurrentUser() {
        try {
            return JSON.parse(localStorage.getItem('sansUser') || 'null');
        } catch (error) {
            return null;
        }
    }

    function formatCommentDate(value) {
        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return 'Fecha no disponible';
        }

        return date.toLocaleString('es-CL', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        });
    }

    function getCommentUserName(comment) {
        if (comment.userName) {
            return comment.userName;
        }

        if (comment.user?.name) {
            return comment.user.name;
        }

        return `usuario_${comment.userId}`;
    }

    function updateCommentCount(detail, count) {
        const total = detail.querySelector('[data-comments-total]');
        const triggerCount = detail.closest('.publication-card')?.querySelector('[data-comments-trigger-count]');
        const label = `${count} ${count === 1 ? 'comment' : 'comments'}`;

        if (total) {
            total.textContent = label;
        }

        if (triggerCount) {
            triggerCount.textContent = count;
        }
    }

    function setCommentError(detail, message = '') {
        const error = detail.querySelector('[data-comment-error]');

        if (!error) {
            return;
        }

        error.textContent = message;
        error.style.display = message ? 'block' : 'none';
    }

    function updateCommentComposerState(detail) {
        const textarea = detail.querySelector('[data-comment-input]');

        if (textarea) {
            textarea.readOnly = !localStorage.getItem('jwtToken');
        }
    }

    function closeCommentMenus(container = document) {
        container.querySelectorAll('.comment-menu.is-open').forEach((menu) => {
            menu.classList.remove('is-open');
            menu.parentElement?.querySelector('[data-comment-menu]')?.setAttribute('aria-expanded', 'false');
        });
    }

    async function updateComment(comment, detail, item, saveButton) {
        const input = item.querySelector('[data-edit-input]');
        const content = input.value.trim();

        setCommentError(detail);

        if (content.length < 3) {
            setCommentError(detail, 'The comment must contain at least 3 characters.');
            return;
        }

        saveButton.disabled = true;

        try {
            const response = await fetch(`/api/comments/${comment.id}`, {
                method: 'PUT',
                headers: {
                    ...apiHeaders(),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ content }),
            });

            if (response.status === 401) {
                localStorage.removeItem('jwtToken');
                localStorage.removeItem('sansUser');
                window.dispatchEvent(new Event('sans-auth-changed'));
                showLoginRequired();
                return;
            }

            if (!response.ok) {
                const data = await response.json().catch(() => ({}));
                throw new Error(data.message || data.error || 'The comment could not be edited.');
            }

            await loadComments({ publicationId: comment.publicationId }, detail);
        } catch (error) {
            setCommentError(detail, error.message || 'The comment could not be edited.');
        } finally {
            saveButton.disabled = false;
        }
    }

    function renderComments(publication, detail, comments) {
        const list = detail.querySelector('[data-comments-list]');
        const currentUser = getCurrentUser();
        const orderedComments = [...comments].sort(
            (a, b) => new Date(b.createdAt) - new Date(a.createdAt)
        );

        updateCommentCount(detail, orderedComments.length);

        if (!orderedComments.length) {
            list.innerHTML = '<p class="comments-empty">No comments yet.</p>';
            return;
        }

        list.innerHTML = orderedComments.map((comment) => {
            const canManage = currentUser && Number(currentUser.id) === Number(comment.userId);
            const commentActions = canManage ? `
                <div class="comment-actions">
                    <button type="button" class="comment-menu-button" data-comment-menu title="Comment options" aria-label="Comment options" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="5" r="1.6" />
                            <circle cx="12" cy="12" r="1.6" />
                            <circle cx="12" cy="19" r="1.6" />
                        </svg>
                    </button>
                    <div class="comment-menu">
                        <button type="button" class="comment-menu-item" data-edit-comment="${comment.id}" title="Editar comentario">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4 16.5-.8 3.3a1 1 0 0 0 1.2 1.2l3.3-.8L19 9a2.1 2.1 0 0 0-3-3L4 16.5Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.5 7.5 2 2" />
                            </svg>
                            <span>edit</span>
                        </button>
                        <button type="button" class="comment-menu-item" data-delete-comment="${comment.id}" title="Eliminar comentario">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12m-9 0V5.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V7m-7 0 .7 12.2a1.5 1.5 0 0 0 1.5 1.3h3.6a1.5 1.5 0 0 0 1.5-1.3L16 7M10 11v6m4-6v6" />
                            </svg>
                            <span>delete</span>
                        </button>
                    </div>
                </div>
            ` : '';

            return `
                <article class="comment-item">
                    <div class="comment-item-content">
                        <div class="comment-item-header">
                            <span class="comment-author">@${escapeHtml(getCommentUserName(comment))}</span>
                            <time class="comment-date">${escapeHtml(formatCommentDate(comment.createdAt))}</time>
                        </div>
                        <p class="comment-text" data-comment-text>${escapeHtml(comment.content)}</p>
                        <div class="comment-edit-form" data-comment-edit-form hidden>
                            <textarea class="comment-edit-input" data-edit-input maxlength="255">${escapeHtml(comment.content)}</textarea>
                            <div class="comment-edit-actions">
                                <button type="button" class="comment-edit-cancel" data-edit-cancel>Cancel</button>
                                <button type="button" class="comment-edit-save" data-edit-save>Accept</button>
                            </div>
                        </div>
                    </div>
                    ${commentActions}
                </article>
            `;
        }).join('');

        list.querySelectorAll('[data-comment-menu]').forEach((button) => {
            button.addEventListener('click', (event) => {
                event.stopPropagation();
                const menu = button.nextElementSibling;
                const isOpen = menu.classList.contains('is-open');

                closeCommentMenus(list);
                menu.classList.toggle('is-open', !isOpen);
                button.setAttribute('aria-expanded', String(!isOpen));
            });
        });

        list.querySelectorAll('[data-edit-comment]').forEach((button) => {
            button.addEventListener('click', () => {
                const item = button.closest('.comment-item');
                const menuButton = item.querySelector('[data-comment-menu]');
                const menu = button.closest('.comment-menu');

                menu.classList.remove('is-open');
                menuButton.setAttribute('aria-expanded', 'false');
                item.querySelector('[data-comment-text]').style.display = 'none';
                item.querySelector('[data-comment-edit-form]').hidden = false;
                item.querySelector('[data-edit-input]').focus();
            });
        });

        list.querySelectorAll('[data-edit-cancel]').forEach((button) => {
            button.addEventListener('click', () => {
                const item = button.closest('.comment-item');
                item.querySelector('[data-comment-edit-form]').hidden = true;
                item.querySelector('[data-comment-text]').style.display = '';
            });
        });

        list.querySelectorAll('[data-edit-save]').forEach((button) => {
            button.addEventListener('click', () => {
                const item = button.closest('.comment-item');
                const comment = orderedComments.find(
                    (itemComment) => Number(itemComment.id) === Number(item.querySelector('[data-edit-comment]')?.dataset.editComment)
                );

                if (comment) {
                    updateComment(comment, detail, item, button);
                }
            });
        });

        list.querySelectorAll('[data-delete-comment]').forEach((button) => {
            button.addEventListener('click', () => {
                commentToDelete = {
                    id: Number(button.dataset.deleteComment),
                    publication,
                    detail,
                };
                commentConfirmModal.classList.add('is-open');
            });
        });
    }

    async function loadComments(publication, detail, scrollToComments = false) {
        const list = detail.querySelector('[data-comments-list]');
        list.innerHTML = '<p class="comments-loading">Loading comments...</p>';
        setCommentError(detail);

        try {
            const response = await fetch(
                `/api/comments?publicationId=${encodeURIComponent(publication.publicationId)}`,
                { headers: apiHeaders() }
            );

            if (!response.ok) {
                throw new Error('Comments request failed');
            }

            const comments = await response.json();
            renderComments(publication, detail, comments);

            if (scrollToComments) {
                detail.querySelector('[data-comments-section]')?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                });
            }
        } catch (error) {
            list.innerHTML = '';
            setCommentError(detail, 'Comments could not be loaded.');
        }
    }

    async function submitComment(publication, detail) {
        if (!localStorage.getItem('jwtToken')) {
            showLoginRequired();
            return;
        }

        const textarea = detail.querySelector('[data-comment-input]');
        const submitButton = detail.querySelector('[data-comment-submit]');
        const content = textarea.value.trim();

        setCommentError(detail);

        if (content.length < 3) {
            setCommentError(detail, 'The comment must contain at least 3 characters.');
            return;
        }

        submitButton.disabled = true;

        try {
            const response = await fetch('/api/comments', {
                method: 'POST',
                headers: {
                    ...apiHeaders(),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    publicationId: publication.publicationId,
                    content,
                }),
            });

            if (response.status === 401) {
                localStorage.removeItem('jwtToken');
                localStorage.removeItem('sansUser');
                window.dispatchEvent(new Event('sans-auth-changed'));
                showLoginRequired();
                return;
            }

            if (!response.ok) {
                const data = await response.json().catch(() => ({}));
                throw new Error(data.message || 'The comment could not be published.');
            }

            textarea.value = '';
            detail.querySelector('[data-comment-character-count]').textContent = '0/255';
            resizeCommentInput(textarea);
            await loadComments(publication, detail);
        } catch (error) {
            setCommentError(detail, error.message || 'The comment could not be published.');
        } finally {
            submitButton.disabled = false;
        }
    }

    function resizeCommentInput(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = `${Math.max(50, textarea.scrollHeight)}px`;
    }

    function closeCommentConfirmation() {
        commentConfirmModal.classList.remove('is-open');
        commentToDelete = null;
    }

    async function deleteComment() {
        if (!commentToDelete || !localStorage.getItem('jwtToken')) {
            closeCommentConfirmation();
            showLoginRequired();
            return;
        }

        commentAcceptButton.disabled = true;

        try {
            const response = await fetch(`/api/comments/${commentToDelete.id}`, {
                method: 'DELETE',
                headers: apiHeaders(),
            });

            if (response.status === 401) {
                localStorage.removeItem('jwtToken');
                localStorage.removeItem('sansUser');
                closeCommentConfirmation();
                window.dispatchEvent(new Event('sans-auth-changed'));
                showLoginRequired();
                return;
            }

            if (!response.ok) {
                throw new Error('Delete comment request failed');
            }

            const { publication, detail } = commentToDelete;
            closeCommentConfirmation();
            await loadComments(publication, detail);
        } catch (error) {
            alert('The comment could not be deleted. Please try again.');
        } finally {
            commentAcceptButton.disabled = false;
        }
    }

    function closePublicationDetail() {
        feedList.querySelectorAll('.publication-card.is-expanded').forEach((card) => {
            card.classList.remove('is-expanded');
        });

        expandedPublicationId = null;
        document.body.classList.remove('publication-detail-open');
    }

    function expandPublication(publication, card, scrollToComments = false) {
        feedList.querySelectorAll('.publication-card.is-expanded').forEach((expandedCard) => {
            if (expandedCard !== card) {
                expandedCard.classList.remove('is-expanded');
            }
        });

        card.classList.add('is-expanded');
        expandedPublicationId = publication.publicationId;
        document.body.classList.add('publication-detail-open');

        const detail = card.querySelector('[data-publication-detail]');
        updateCommentComposerState(detail);
        loadComments(publication, detail, scrollToComments);
    }

    function renderPublications(publications, productsById) {
        document.body.classList.remove('publication-detail-open');
        feedList.innerHTML = '';
        emptyFeed.style.display = publications.length ? 'none' : 'block';

        publications.forEach((publication) => {
            const productName = productsById[publication.productId] || `Product #${publication.productId}`;
            const userName = getPublicationUserName(publication);
            const card = document.createElement('article');
            card.className = 'publication-card';
            card.dataset.publicationId = publication.publicationId;
            card.innerHTML = `
                <div class="publication-meta">
                    <p class="publication-user">@${escapeHtml(userName)}</p>
                    <p class="publication-date">${escapeHtml(formatRelativeDate(publication.publicationDate))}</p>
                </div>

                <div class="publication-image-placeholder" data-expand-publication role="button" tabindex="0" aria-label="Expand publication">Not available yet</div>

                <div class="publication-content">
                    <div class="publication-heading">
                        <h2 class="publication-title">${escapeHtml(productName)}</h2>
                        <div class="publication-rating" aria-label="Rating ${escapeHtml(Number(publication.rating).toFixed(1))} of 5">
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

                        <button type="button" class="publication-action" data-comments-button title="View comments" aria-label="View comments">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" />
                            </svg>
                            <span data-comments-trigger-count>${escapeHtml(publication.commentsCount ?? publication.comments?.length ?? 0)}</span>
                        </button>
                    </div>
                </div>

                <div class="publication-detail" data-publication-detail>
                    <div class="publication-detail-shell">
                        <button type="button" class="publication-detail-back" data-close-publication title="Go back to feed" aria-label="Go back to feed">
                            &lt; go back to feed
                        </button>

                        <div class="publication-detail-panel">
                            <div class="publication-detail-meta">
                                <p class="publication-user">@${escapeHtml(userName)}</p>
                                <p class="publication-date">${escapeHtml(formatRelativeDate(publication.publicationDate))}</p>
                            </div>

                        <div class="publication-expanded-image">Not available yet</div>
                        <div class="publication-expanded-data">
                            <div class="publication-expanded-heading">
                                <h3>${escapeHtml(productName)}</h3>
                                <div class="publication-rating" aria-label="Rating ${escapeHtml(Number(publication.rating).toFixed(1))} de 5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12 2.5l2.9 5.88 6.49.94-4.7 4.58 1.11 6.46L12 17.31l-5.8 3.05 1.11-6.46-4.7-4.58 6.49-.94L12 2.5Z" />
                                    </svg>
                                    ${escapeHtml(Number(publication.rating).toFixed(1))}
                                </div>
                            </div>
                            <p><strong>User:</strong> @${escapeHtml(userName)}</p>
                            <p><strong>Date:</strong> ${escapeHtml(formatRelativeDate(publication.publicationDate))}</p>
                            <p><strong>Rating:</strong> ${escapeHtml(Number(publication.rating).toFixed(1))} / 5</p>
                            <p><strong>Review:</strong> ${escapeHtml(publication.review)}</p>
                        </div>

                        <section class="comments-section" data-comments-section aria-label="Publication comments">
                            <div class="comments-heading">
                                <h3>Comments</h3>
                                <span data-comments-total>0 comments</span>
                            </div>
                            <div class="comment-composer">
                                <textarea data-comment-input maxlength="255" readonly placeholder="Write a comment ..." aria-label="Write a comment"></textarea>
                                <div class="comment-composer-footer">
                                    <span class="comment-character-count" data-comment-character-count>0/255</span>
                                    <button type="button" class="comment-submit" data-comment-submit>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4 4 16 8-16 8 3-8-3-8Zm3 8h13" />
                                        </svg>
                                        Publish
                                    </button>
                                </div>
                            </div>
                            <p class="comment-error" data-comment-error></p>
                            <div class="comments-list" data-comments-list></div>
                        </section>
                    </div>
                </div>
            </div>
            `;

            const likeButton = card.querySelector('[data-like-button]');
            likeButton.addEventListener('click', () => togglePublicationLike(publication, likeButton));

            const imageTrigger = card.querySelector('[data-expand-publication]');
            imageTrigger.addEventListener('click', () => expandPublication(publication, card));
            imageTrigger.addEventListener('keydown', (event) => {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    expandPublication(publication, card);
                }
            });

            const commentsButton = card.querySelector('[data-comments-button]');
            commentsButton.addEventListener('click', () => expandPublication(publication, card, true));

            const detail = card.querySelector('[data-publication-detail]');
            const textarea = detail.querySelector('[data-comment-input]');
            const characterCount = detail.querySelector('[data-comment-character-count]');

            detail.querySelectorAll('[data-close-publication]').forEach((closeButton) => {
                closeButton.addEventListener('click', closePublicationDetail);
            });
            detail.addEventListener('click', (event) => {
                if (event.target === detail) {
                    closePublicationDetail();
                }
            });
            textarea.addEventListener('click', () => {
                if (!localStorage.getItem('jwtToken')) {
                    showLoginRequired();
                }
            });
            textarea.addEventListener('input', () => {
                characterCount.textContent = `${textarea.value.length}/255`;
                resizeCommentInput(textarea);
            });
            detail.querySelector('[data-comment-submit]').addEventListener('click', () => submitComment(publication, detail));

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

    async function loadPublications(productId = null, categoryId = null) {
        try {
            const publicationsUrl = productId
                ? `/api/publications?productId=${encodeURIComponent(productId)}`
                : '/api/publications';

            const [publicationsResponse, productsResponse, categoriesResponse] = await Promise.all([
                fetch(publicationsUrl, { headers: apiHeaders() }),
                fetch('/api/products', { headers: apiHeaders() }),
                fetch('/api/categories', { headers: apiHeaders() }),
            ]);

            if (!publicationsResponse.ok) {
                throw new Error('Publications request failed');
            }

            const publications = await publicationsResponse.json();
            const products = productsResponse.ok ? await productsResponse.json() : [];
            const categories = categoriesResponse.ok ? await categoriesResponse.json() : [];
            renderCategoryFilter(categories, products);

            const productsById = buildProductMap(products);
            const categoryIds = new Set(
                String(categoryId ?? '')
                    .split(',')
                    .map(Number)
                    .filter(Number.isFinite)
            );
            const filteredPublications = categoryId === null
                ? publications
                : publications.filter((publication) => {
                    const product = products.find(
                        (item) => Number(item.productId ?? item.id) === Number(publication.productId)
                    );
                    return product && categoryIds.has(Number(product.categoryId));
                });
            const ordered = [...filteredPublications].sort((a, b) => new Date(b.publicationDate) - new Date(a.publicationDate));

            renderPublications(ordered, productsById);

            if (expandedPublicationId !== null) {
                const publication = ordered.find(
                    (item) => Number(item.publicationId) === Number(expandedPublicationId)
                );
                const card = feedList.querySelector(
                    `[data-publication-id="${expandedPublicationId}"]`
                );

                if (publication && card) {
                    expandPublication(publication, card);
                }
            }
        } catch (error) {
            feedError.style.display = 'block';
        }
    }

    window.sansApplyProductFilter = function (product) {
        currentFilterProductId = product ? product.id : null;
        currentFilterCategoryId = null;
        setFilterUi(product);

        const url = new URL(window.location.href);

        if (product) {
            url.searchParams.set('productId', product.id);
            url.searchParams.set('nombre', product.name);
        } else {
            url.searchParams.delete('productId');
            url.searchParams.delete('nombre');
        }

        url.searchParams.delete('categoryId');
        url.searchParams.delete('categoryName');

        window.history.pushState({}, '', url);
        loadPublications(currentFilterProductId, null);
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

    filterButton.addEventListener('click', (event) => {
        event.stopPropagation();
        const isOpen = categoryFilterMenu.classList.toggle('is-open');
        filterButton.setAttribute('aria-expanded', String(isOpen));
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

    commentCancelButton.addEventListener('click', closeCommentConfirmation);
    commentAcceptButton.addEventListener('click', deleteComment);
    document.addEventListener('click', (event) => {
        if (!event.target.closest('.comment-actions')) {
            closeCommentMenus();
        }

        if (!event.target.closest('.filter-control')) {
            categoryFilterMenu.classList.remove('is-open');
            filterButton.setAttribute('aria-expanded', 'false');
        }
    });
    commentConfirmModal.addEventListener('click', (event) => {
        if (event.target === commentConfirmModal) {
            closeCommentConfirmation();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            if (commentConfirmModal.classList.contains('is-open')) {
                closeCommentConfirmation();
            } else if (categoryFilterMenu.classList.contains('is-open')) {
                categoryFilterMenu.classList.remove('is-open');
                filterButton.setAttribute('aria-expanded', 'false');
            } else if (expandedPublicationId !== null) {
                closePublicationDetail();
            }
        }
    });

    clearFilterButton.addEventListener('click', () => window.sansApplyProductFilter(null));

    window.addEventListener('sans-auth-changed', () => {
        if (localStorage.getItem('jwtToken')) {
            loginRequiredModal.classList.remove('is-open');
        }

        loadPublications(currentFilterProductId, currentFilterCategoryId);
    });

    window.addEventListener('popstate', () => {
        const params = new URLSearchParams(window.location.search);
        const productId = params.get('productId');
        const nombre = params.get('nombre');
        const categoryId = params.get('categoryId');
        const categoryName = params.get('categoryName');

        currentFilterProductId = productId;
        currentFilterCategoryId = categoryId;
        setFilterUi(
            productId
                ? { id: productId, name: nombre || `Product #${productId}` }
                : categoryId
                    ? { id: categoryId, name: categoryName || `Category #${categoryId}` }
                    : null
        );
        loadPublications(productId, categoryId);
    });

    (function init() {
        const params = new URLSearchParams(window.location.search);
        const productId = params.get('productId');
        const nombre = params.get('nombre');
        const categoryId = params.get('categoryId');
        const categoryName = params.get('categoryName');

        if (productId) {
            currentFilterProductId = productId;
            currentFilterCategoryId = null;
            setFilterUi({ id: productId, name: nombre || `Product #${productId}` });
            loadPublications(productId, null);
        } else if (categoryId) {
            currentFilterProductId = null;
            currentFilterCategoryId = categoryId;
            setFilterUi({ id: categoryId, name: categoryName || `Category #${categoryId}` });
            loadPublications(null, categoryId);
        } else {
            currentFilterProductId = null;
            currentFilterCategoryId = null;
            loadPublications(null, null);
        }
    })();
</script>

</body>
</html>
