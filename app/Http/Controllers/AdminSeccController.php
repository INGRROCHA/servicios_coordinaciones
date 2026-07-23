<?php

namespace App\Http\Controllers;

use App\Models\Seccion;
use Illuminate\Http\Request;

class AdminSeccController extends Controller
{
    /**
     * 🛡️ Método centralizado para validar permisos y obtener la sección.
     */
    private function validarAcceso($id)
    {
        $idValidado = (session('usuario_rol') === 'seccion') ? session('id_seccion') : $id;
        $secc = Seccion::find($idValidado);
        
        if (!$secc) {
            abort(404, 'La sección solicitada no existe.');
        }

        return $secc;
    }

    // ========================================================
    // Dashboard Principal
    // ========================================================
    public function index($id)
    {
        $secc = $this->validarAcceso($id);
        return view('admin', compact('secc'));
    }

    // ========================================================
    // Vista de Servicios
    // ========================================================
    public function servicios($id)
    {
        $secc = $this->validarAcceso($id);
        return view('admin-servicios', compact('secc'));
    }

    // ========================================================
    // Vista de Trabajadores (tr_secc)
    // ========================================================
    public function trabajadores($id)
    {
        $secc = $this->validarAcceso($id);
        return view('admin-tr_secc', compact('secc'));
    }
}