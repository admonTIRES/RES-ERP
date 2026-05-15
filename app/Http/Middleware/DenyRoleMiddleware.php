<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DenyRoleMiddleware
{
    public function handle($request, Closure $next, ...$rolesDenegados)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Tu sesión ha expirado. Inicia sesión nuevamente.');
        }

        $user = Auth::user();

        $userRoles = $user->roles()
            ->where('ACTIVO', 1)
            ->pluck('NOMBRE_ROL')
            ->map(fn($rol) => strtolower(trim($rol)))
            ->toArray();

        foreach ($rolesDenegados as $deniedRole) {
            if (in_array(strtolower(trim($deniedRole)), $userRoles)) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'error' => true,
                        'message' => 'No tienes permiso para acceder a esta sección.'
                    ], 403);
                }

                return redirect()->route('alta')->with('error', 'No tienes permiso para acceder a esta sección.');
            }
        }

        return $next($request);
    }
}
