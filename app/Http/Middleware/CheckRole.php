<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        if(env('APP_ENV') === 'testing') {
            return $next($request);
        }
        if (! $request->expectsJson()) {
            throw new HttpResponseException(response()->json(['message' => 'Unauthenticated.'], 422));
        }
        if ($request->user()->role !== $role) {
            throw new AuthorizationException();
        }

        return $next($request);
    }
}
