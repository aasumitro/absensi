<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $accepted = false;

        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                $accepted = true;
            }
        }

        if (! $accepted) {
            abort(401);
        }

        return $next($request);
    }
}
