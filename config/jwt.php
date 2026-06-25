<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | JWT Authentication Secret
    |--------------------------------------------------------------------------
    | Set this in your .env file. Generate it with: php artisan jwt:secret
    | Used exclusively for symmetric algorithms (HMAC — HS256, HS384, HS512).
    */

    'secret' => env('JWT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | JWT Authentication Keys
    |--------------------------------------------------------------------------
    | Symmetric algorithms (HS256/384/512) use JWT_SECRET above.
    | Asymmetric algorithms (RS256/512, ES256/512) use the key pair below.
    */

    'keys' => [
        'public'     => env('JWT_PUBLIC_KEY'),   // E.g. 'file://path/to/public/key'
        'private'    => env('JWT_PRIVATE_KEY'),  // E.g. 'file://path/to/private/key'
        'passphrase' => env('JWT_PASSPHRASE'),   // Null if no passphrase is set
    ],

    /*
    |--------------------------------------------------------------------------
    | JWT Time to Live
    |--------------------------------------------------------------------------
    | How long (in minutes) a token remains valid after being issued.
    | Set to null for tokens that never expire (not recommended).
    | If null, remove 'exp' from required_claims below.
    */

    'ttl' => env('JWT_TTL', 40),

    /*
    |--------------------------------------------------------------------------
    | Refresh Time to Live
    |--------------------------------------------------------------------------
    | How long (in minutes) a token can be refreshed after its original issue.
    | Defaults to 2 weeks. Set to null for an infinite refresh window.
    */

    'refresh_ttl' => env('JWT_REFRESH_TTL', 20160),

    /*
    |--------------------------------------------------------------------------
    | JWT Hashing Algorithm
    |--------------------------------------------------------------------------
    | Defaults to HS256. Change only if your key setup requires it.
    */

    'algo' => env('JWT_ALGO', Tymon\JWTAuth\Providers\JWT\Provider::ALGO_HS256),

    /*
    |--------------------------------------------------------------------------
    | Required Claims
    |--------------------------------------------------------------------------
    | A TokenInvalidException is thrown if any of these are missing from the payload.
    */

    'required_claims' => [
        'iss',
        'iat',
        'exp',
        'nbf',
        'sub',
        'jti',
    ],

    /*
    |--------------------------------------------------------------------------
    | Persistent Claims
    |--------------------------------------------------------------------------
    | Claims to carry over when a token is refreshed.
    | 'sub' and 'iat' are always persisted automatically.
    */

    'persistent_claims' => [
        // 'foo',
        // 'bar',
    ],

    /*
    |--------------------------------------------------------------------------
    | Lock Subject
    |--------------------------------------------------------------------------
    | Adds a 'prv' claim to prevent cross-model token impersonation.
    | Safe to disable if you have only one authenticatable model.
    */

    'lock_subject' => true,

    /*
    |--------------------------------------------------------------------------
    | Leeway
    |--------------------------------------------------------------------------
    | Tolerance in seconds for clock skew between servers.
    | Applies to 'iat', 'nbf', and 'exp' claims.
    */

    'leeway' => env('JWT_LEEWAY', 0),

    /*
    |--------------------------------------------------------------------------
    | Blacklist Enabled
    |--------------------------------------------------------------------------
    | Must be true to support token invalidation on logout.
    | Disable only if you never need to revoke tokens before they expire.
    */

    'blacklist_enabled' => env('JWT_BLACKLIST_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Blacklist Grace Period
    |--------------------------------------------------------------------------
    | Seconds of tolerance for concurrent requests sharing the same JWT.
    | Useful when token rotation causes parallel requests to fail.
    */

    'blacklist_grace_period' => env('JWT_BLACKLIST_GRACE_PERIOD', 0),

    /*
    |--------------------------------------------------------------------------
    | Cookies Encryption
    |--------------------------------------------------------------------------
    | Set to true if you want the package to decrypt JWT cookies automatically.
    | When false, add the cookie name to EncryptCookies::$except to avoid
    | double-encryption by Laravel.
    */

    'decrypt_cookies' => false,

    /*
    |--------------------------------------------------------------------------
    | Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [
        // Encodes and decodes the JWT
        'jwt'     => Tymon\JWTAuth\Providers\JWT\Lcobucci::class,

        // Authenticates users against the guard
        'auth'    => Tymon\JWTAuth\Providers\Auth\Illuminate::class,

        // Stores blacklisted tokens (uses Laravel cache driver)
        'storage' => Tymon\JWTAuth\Providers\Storage\Illuminate::class,
    ],

];
