<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // use $request->user() instead of Auth::user() for clarity
        $user = $request->user();
        if (! $user || ! $user->isAdmin()) {
            abort(403, 'Unauthorized.');
        }
        return $next($request);
    }
}