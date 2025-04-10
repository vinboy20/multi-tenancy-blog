<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
// This middleware checks if the authenticated user is an admin.
// If not, it returns a 403 Unauthorized response.
// This is useful for protecting admin routes and ensuring that only authorized users can access them.
// It can be applied to routes or controllers to enforce admin access control.
