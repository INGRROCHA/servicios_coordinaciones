<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Si ni siquiera está autenticado en tu sistema personalizado, va para afuera
        if (!session('usuario_autenticado')) {
            return redirect('/')->with('error', 'Debes iniciar sesión primero.');
        }

        // 2. Comprobamos si el rol guardado en la sesión está dentro de los permitidos para la ruta
        if (!in_array(session('usuario_rol'), $roles, true)) {
            abort(403, 'No tienes los privilegios necesarios para acceder a esta sección.');
        }

        return $next($request);
    }
}