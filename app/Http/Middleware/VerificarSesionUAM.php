<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarSesionUAM
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificamos si la variable de sesión NO existe o es falsa
        if (!session('usuario_autenticado')) {
            // Si no está autenticado, lo regresamos al home (login) con un mensaje de error
            return redirect('/')->with('error', 'Acceso denegado. Por favor, inicia sesión primero.');
        }

        // Si la sesión existe, dejamos que la petición continúe su camino
        return $next($request);
    }
}