<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain as BaseInitializeTenancyByDomain;

class InitializeTenancyByDomain extends BaseInitializeTenancyByDomain
{
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->tenant_id) {
            tenancy()->initialize($request->user()->tenant_id);
        }

        return $next($request);
    }
}
// This middleware initializes the tenancy for the user based on their tenant_id.
// It checks if the user is authenticated and has a tenant_id, and if so, it initializes the tenancy.
// This is useful for ensuring that the user is operating within their own tenant context.