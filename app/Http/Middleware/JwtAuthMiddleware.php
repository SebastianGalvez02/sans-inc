<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Repositories\BlacklistedTokenRepository;

/**
 * JwtAuthMiddleware
 * Validates the incoming JWT and rejects any token that appears
 * in the blacklisted_tokens table (i.e. tokens invalidated via logout).
 *
 * Register this middleware in app/Http/Kernel.php under $routeMiddleware:
 *   'auth.jwt' => \App\Http\Middleware\JwtAuthMiddleware::class,
 */
class JwtAuthMiddleware
{
    public function __construct(
        protected BlacklistedTokenRepository $blacklistedTokenRepository,
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Ensure a Bearer token is present in the request
        $rawToken = JWTAuth::getToken();

        if (!$rawToken) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        // 2. Check the blacklist BEFORE attempting full JWT validation.
        //    This prevents any token explicitly invalidated via logout from being reused.
        if ($this->blacklistedTokenRepository->isBlacklisted((string) $rawToken)) {
            return response()->json(['message' => 'Token has been invalidated. Please log in again'], 401);
        }

        // 3. Verify the token signature and expiry via tymon/jwt-auth
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException) {
            return response()->json(['message' => 'Token has expired'], 401);
        } catch (TokenInvalidException) {
            return response()->json(['message' => 'Token is invalid'], 401);
        } catch (JWTException) {
            return response()->json(['message' => 'Token not found or malformed'], 401);
        }

        return $next($request);
    }
}
