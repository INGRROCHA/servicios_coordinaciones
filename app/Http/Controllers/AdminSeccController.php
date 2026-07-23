<?php

namespace App\Http\Controllers;
use App\Models\Seccion;
use App\Models\Servicio;
use App\Models\Trabajador;

class AdminSeccController extends Controller
{
    
    // ========================================================
    // Método servicio filtrado por Seccion con paginación
    // ========================================================
    public function servicioPorSeccion(int $id)
    {
        // 🛡️ SEGURIDAD: Si es usuario de sección, forzamos su ID de sesión.
        // Si es 'admin', se le permite ver el ID de la URL que solicitó.
        if (session('usuario_rol') === 'seccion') {
            $id2 = session('id_seccion');
        }

        $secc = Seccion::find($id);
        
        if (!$secc) {
            abort(404, 'La sección solicitada no existe.');
        }

        $servicio = Servicio::with([ 'seccion', 'servicios'])
                        ->where('id_seccion', $id)
                        ->paginate(20); 

        return view('secc', compact('servicio', 'secc'));
    }

    
    // ========================================================
    // Método trabajador filtrado por Seccion con paginación
    // ========================================================
    public function trabajadorPorSeccion(int $id2)
    {
        // 🛡️ SEGURIDAD: Si es usuario de sección, forzamos su ID de sesión.
        // Si es 'admin', se le permite ver el ID de la URL que solicitó.
        if (session('usuario_rol') === 'seccion') {
            $id2 = session('id_seccion');
        }

        $secc = Seccion::find($id2);
        
        if (!$secc) {
            abort(404, 'La sección solicitada no existe.');
        }

        $trabajador = Trabajador::with([ 'seccion', 'trabajadores'])
                        ->where('id_seccion', $id2)
                        ->paginate(20); 

        return view('secc', compact('trabajador', 'secc'));
    }

}
