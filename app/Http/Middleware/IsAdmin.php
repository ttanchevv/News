<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->is_admin !== 1) {
            // Ако потребителят не е логнат или не е администратор
            return redirect()->route('home');
        }

        return $next($request); // Потребителят е администратор
    }
}
