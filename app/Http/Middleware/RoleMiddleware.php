<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (! $request->user()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $roles = explode('|', $role);
        $hasAccess = false;

        foreach ($roles as $r) {
            if ($request->user()->hasRole($r)) {
                $hasAccess = true;
                break;
            }
        }

        if (! $hasAccess) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
