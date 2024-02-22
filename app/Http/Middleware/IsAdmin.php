<?php

namespace App\Http\Middleware;

use Closure;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * @throws ValidationException
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && $request->user()->isAdmin()) {
            return $next($request);
        }

        return throw new ValidationException('Unauthorized action', 401);
    }
}
