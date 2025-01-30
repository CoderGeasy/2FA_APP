<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($request->routeIs('login') ||
            $request->routeIs('register')) {
            return $next($request);
            
        }

        // Verifica si el usuario está autenticado pero aún no ha validado 2FA
        if ($user && $user->token && !$user->is_2fa_verified) {
            return redirect()->route('verify-2fa');
        }

        return $next($request);
    }
}