<?php

namespace App\Http\Middleware;


use Illuminate\Support\Facades\Crypt;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckSession
{
    /**
     * Manejar una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
{
    $excludedRoutes = [
        'Formulario-vacantes', 
        'Vacantes',            
        'login',               
        '',
        'logout',              
        'inicio',
        'Directorio',          
        'actualizarinfo',           
        'actualizarinfoproveedor',
        'PostularseSave',    
        'actualizarinfocv',         
        'FormCVSave',
        'ServiciosSave',
        'enviar-codigo' ,
        'verificar-codigo',      
        'Proveedor' ,
        'codigo-postal/*',
        'ActualizarSave'


        ];

        foreach ($excludedRoutes as $excluded) {
            if (Str::is($excluded, $request->path())) {
                return $next($request);
            }
        }

    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
    }

    return $next($request);
}

}
