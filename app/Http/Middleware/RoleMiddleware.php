<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Manejar una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            // Redirige al login si no está autenticado
            return redirect()->route('login')->with('error', 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
        }

        // Verifica si el usuario tiene alguno de los roles permitidos
        $user = Auth::user();
        if ($user->hasAnyRole($roles)) {
            // Si el usuario tiene el rol, permite el acceso
            return $next($request);
        }

        // Si el usuario no tiene los roles, redirige con un mensaje de error
        return redirect()->back()->with('error', 'No tienes acceso a esta sección.');
    }
}
