<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * EnsureUserIsClient
 * Restricts access to routes that require the 'client' role (RN-15).
 * Returns 403 if the authenticated user does not have the client role.
 */
class EnsureUserIsClient
{
    /**
     * Handle an incoming request.
     * Verifies that the authenticated user has the 'client' role via the roles table.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->role || $user->role->role_name !== 'client') {
            return response()->json(['message' => 'Acceso restringido a clientes.'], 403);
        }

        return $next($request);
    }
}