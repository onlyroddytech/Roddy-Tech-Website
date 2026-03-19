<?php

namespace App\Http\Middleware;

// =============================================================
// CheckRole Middleware
// Enforces role-based access control on route groups.
//
// Usage in routes:
//   ->middleware(['auth', 'role:admin'])
//   ->middleware(['auth', 'role:client'])
//
// If the authenticated user's role does not match the required
// role, they receive a 403 Forbidden response.
// =============================================================

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  string  $role  The required role — 'admin', 'client', or 'staff'
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user() || $request->user()->role->value !== $role) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
