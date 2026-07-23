# User Management & Authentication — Requirements Documentation

This document describes how the system currently implements the user-related
functional requirements (RF-01 to RF-06, RF-20). It is a description of the
existing code, not a specification for future work.

## 1. Scope

| Requirement | Name                        |
|-------------|-----------------------------|
| RF-01       | User registration           |
| RF-02       | Email confirmation          |
| RF-03       | Login                       |
| RF-04       | Logout                      |
| RF-05       | Password recovery           |
| RF-06       | Profile editing             |
| RF-20       | Client role                 |

Only components involved in these requirements are covered. Modules unrelated
to users (e.g. Agenda, Publications, Products, Categories) are out of scope.

## 2. Architecture Overview

| Layer         | File                                                                 | Responsibility |
|---------------|-----------------------------------------------------------------------|----------------|
| Controller    | `app/Http/Controllers/AuthController.php`                             | Register, login, logout, forgot-password, reset-password |
| Controller    | `app/Http/Controllers/ProfileController.php`                           | Self-service name and password update (RF-06) |
| Model         | `app/Models/User.php`                                                  | `users` table, implements `JWTSubject`, defines the `role()` relation |
| Model         | `app/Models/Role.php`                                                  | `roles` table (`role_name`, `description`), soft-deletable |
| Model         | `App\Models\VerificationCode` (used by `VerificationCodeRepository`)   | Login-lockout counters and password-reset codes |
| Model         | `App\Models\BlacklistedToken` (used by `BlacklistedTokenRepository`)   | Invalidated JWTs |
| Repository    | `app/Repositories/UserRepository.php`                                  | `existsByEmail`, `findByEmail`, `save` — the only data-access class for users. **There is no `UserService`**; controllers call the repository directly. |
| Repository    | `app/Repositories/VerificationCodeRepository.php`                      | Failed-login lockout logic and reset-code generation/verification |
| Repository    | `app/Repositories/BlacklistedTokenRepository.php`                      | JWT blacklist read/write |
| DTOs          | `RegisterRequestDTO`, `RegisterResponseDTO`, `LoginRequestDTO`, `LoginResponseDTO`, `ForgotPasswordRequestDTO`, `ResetPasswordRequestDTO`, `ProfileResponseDTO` (all under `app/DTOs/`) | Shape request/response payloads and keep sensitive fields (password hash, tokens) out of responses |
| Support       | `app/Support/PasswordRules.php`                                        | Single source of truth for the "strong password" rule (min 8 chars, letters, numbers, symbols), reused by registration, reset-password and profile password change |
| Middleware    | `app/Http/Middleware/JwtAuthMiddleware.php` (alias `auth.jwt`)          | Validates the JWT signature/expiry and rejects blacklisted tokens |
| Middleware    | `app/Http/Middleware/EnsureUserIsClient.php` (alias `client`)           | Restricts a route to users whose `role.role_name === 'client'` |
| Mail          | `app/Mail/ResetPasswordMail.php` + `resources/views/emails/reset-password.blade.php` | Password-reset code email |

## 3. Database Schema

**`users`** (`database/migrations/2026_06_04_223523_create_users_table.php`)

| Column            | Type                          | Notes |
|-------------------|-------------------------------|-------|
| `id`               | bigint, PK                   | |
| `role_id`          | FK → `roles.id`               | required |
| `name`             | string(16)                    | matches the `max:16` validation rule |
| `email`            | string(100), unique           | |
| `password`         | string                         | hashed via the `hashed` Eloquent cast |
| `recovery_email`   | string, nullable               | present in schema; not read/written by any controller currently |
| `deleted_at`       | timestamp (SoftDeletes)        | |

**`roles`** (`database/migrations/2026_06_01_010805_create_rols_table.php`)

| Column        | Type            |
|---------------|-----------------|
| `id`           | bigint, PK      |
| `role_name`    | string          |
| `description`  | string, nullable |
| `deleted_at`   | timestamp (SoftDeletes) |

Seeded by `database/seeders/RoleSeeder.php` with three roles: `admin`, `user`,
`client` (used for RF-20).

**`verification_codes`** (`database/migrations/2026_06_05_000000_create_verification_codes_table.php`)

Serves two purposes: login-lockout tracking and password-reset codes.

| Column             | Type                     |
|--------------------|--------------------------|
| `user_id`           | FK → `users.id`, cascade delete |
| `code`              | string                   |
| `expires_at`        | timestamp                |
| `failed_attempts`   | integer, default 0       |
| `date_to_resend`    | timestamp, nullable (lockout expiry) |

**`blacklisted_tokens`** (`database/migrations/2026_06_04_223524_create_blacklisted_tokens_table.php`)

| Column         | Type                             |
|----------------|-----------------------------------|
| `user_id`       | FK → `users.id`, cascade delete   |
| `token`         | text (full JWT)                   |
| `expires_at`    | timestamp (copied from the JWT `exp` claim) |

## 4. API Endpoints

Base URL: `/api` (see `routes/api.php`).

| Method | Path                       | Middleware       | Controller@Method                    | Requirement |
|--------|----------------------------|------------------|---------------------------------------|-------------|
| POST   | `/auth/register`            | –                | `AuthController@register`             | RF-01 |
| POST   | `/auth/login`                | –                | `AuthController@login`                | RF-03 |
| POST   | `/auth/logout`               | `auth.jwt`       | `AuthController@logout`               | RF-04 |
| POST   | `/auth/forgot-password`      | –                | `AuthController@forgotPassword`       | RF-05 |
| POST   | `/auth/reset-password`       | –                | `AuthController@resetPassword`        | RF-05 |
| GET    | `/user`                      | `auth.jwt`       | inline closure in `routes/api.php`     | – (returns the raw authenticated `User` model) |
| PUT    | `/user/profile`              | `auth.jwt`       | `ProfileController@updateProfile`     | RF-06 |
| PUT    | `/user/password`              | `auth.jwt`       | `ProfileController@updatePassword`    | RF-06 |

### 4.1 POST `/auth/register` — RF-01

- Request body: `name` (string, required, max 16), `email` (string, required, valid email, max 100), `role_id` (required, must exist in `roles`), `password` (required, confirmed, strong — see §5.1).
- `409 Conflict` if the email is already registered (`UserRepository::existsByEmail`).
- `201 Created` with `RegisterResponseDTO` (`id`, `name`, `email`, `registered_at`) on success.
- Password is hashed with `Hash::make()` before persisting.

### 4.2 POST `/auth/login` — RF-03

- Request body: `email`, `password`.
- Looks up the user first (`UserRepository::findByEmail`) to evaluate lockout state before attempting authentication.
- `403` if the account is currently locked out (see §5.2), with `unlocks_at`.
- Authenticates via `JWTAuth::attempt()`.
- `401 Invalid credentials` on failure, with `remaining_attempts` when the user exists; the same generic message is returned when the email doesn't exist, to avoid user enumeration.
- `200 OK` with `LoginResponseDTO` (`id`, `name`, `email`, `role_id`, `token`, `token_type`) on success; resets the failed-attempt counter.

### 4.3 POST `/auth/logout` — RF-04

- Requires `auth.jwt` (a valid, non-blacklisted token).
- Reads the raw token and its `exp` claim, stores it in `blacklisted_tokens`, then best-effort invalidates it in `tymon/jwt-auth`.
- `401` if no token is provided.
- `200 OK` on success.

### 4.4 POST `/auth/forgot-password` and POST `/auth/reset-password` — RF-05

- `forgot-password`: validates `email`; **always returns `200`** whether or not the email exists (anti-enumeration). If it exists, generates a 6-digit numeric code (`VerificationCodeRepository::createResetCode`, 15-minute expiry) and queues `ResetPasswordMail`.
- `reset-password`: validates `email`, `code`, and a strong, confirmed `password`. Returns `400` if the user doesn't exist or the code is invalid/expired. On success, hashes and saves the new password and deletes the verification-code record.

### 4.5 PUT `/user/profile` and PUT `/user/password` — RF-06

- Both require `auth.jwt` and operate **only on `$request->user()`** — there is no id parameter, so a user can never edit another account (enforced by design, referenced in the controller docblock as "RN-02 / RNF-05").
- `updateProfile`: validates `name` (same rule as registration: required, string, max 16). Returns `200` with a `ProfileResponseDTO` (`id`, `name`, `email`).
- `updatePassword`: validates `current_password` against the authenticated user via Laravel's `current_password:api` rule, and a new, confirmed, strong `password` (`PasswordRules::strong()`). On success, hashes and saves the new password, then blacklists the current JWT (same mechanism as logout), forcing re-authentication.

## 5. Cross-Cutting Business Rules

### 5.1 Password policy

Defined once in `App\Support\PasswordRules::strong()` and reused by registration, password reset, and profile password change: minimum 8 characters, at least one letter, one number, and one symbol. Confirmation (`password_confirmation`) is required in all three flows.

### 5.2 Login lockout

Implemented in `VerificationCodeRepository`:
- `MAX_FAILED_ATTEMPTS = 5`, `LOCKOUT_MINUTES = 15`.
- Each wrong-password attempt increments `failed_attempts` for that user; reaching the max sets `date_to_resend` (lockout expiry).
- A locked-out user is rejected with `403` on any further login attempt, even with the correct password, until the lockout window elapses.
- A successful login resets the counter.

### 5.3 JWT invalidation (blacklist)

Both logout and password-change invalidate the current token by writing it to `blacklisted_tokens` (`BlacklistedTokenRepository`). `JwtAuthMiddleware` checks this table before validating the token's signature/expiry, so a blacklisted token is rejected even if it hasn't technically expired yet.

### 5.4 Self-service scope

`ProfileController` never accepts a user id from the request — every mutation targets `$request->user()` exclusively, so the JWT identity is the only way to determine which account is modified.

## 6. RF-20 — Client Role

- The `client` role is one of the three seeded roles (`admin`, `user`, `client`) in `RoleSeeder`, assignable to any user through the `role_id` field at registration (RF-01) — there is no dedicated "assign client role" endpoint; it is set like any other role at registration time via `role_id`.
- Route-level enforcement is done by the `client` middleware alias (`EnsureUserIsClient`), which loads the user's `role` relation and returns `403` unless `role_name === 'client'`. Currently applied to the Agenda endpoints (`routes/api.php`), not to any endpoint documented above.
- The client role is stored via the `role_id` foreign key on `users`, resolved through the `role()` relation to `roles.role_name`.

## 7. Requirement Traceability Summary

| Req.  | Status                | Notes |
|-------|------------------------|-------|
| RF-01 | Implemented            | `AuthController::register` |
| RF-02 | **Not implemented**    | No confirmation email is sent on registration. The only transactional email in the codebase is the password-reset code (`ResetPasswordMail`). The `User` model does not implement `MustVerifyEmail`, and no verification-related route/controller exists. |
| RF-03 | Implemented            | `AuthController::login`, includes lockout (§5.2) |
| RF-04 | Implemented            | `AuthController::logout` |
| RF-05 | Implemented            | `AuthController::forgotPassword` / `resetPassword` |
| RF-06 | Implemented            | `ProfileController::updateProfile` / `updatePassword` |
| RF-20 | Implemented            | `client` role seeded + `EnsureUserIsClient` middleware |
