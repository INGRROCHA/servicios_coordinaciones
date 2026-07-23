<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function storeDatosPersonales(Request $request)
    {
        // 1. Validación estricta de los datos recibidos
        $request->validate([
            'num_economico'   => 'required|digits:5',
            'id_coordinacion' => 'required',
            'id_seccion'      => 'required',
            'id_servicio'     => 'required',
            'descripcion'     => 'required',
            'edificio'        => 'required',
            'nivel'           => 'required',
            'cubiculo'        => 'required',
            'extension'       => 'required'
        ]);

        try {
            DB::beginTransaction();

            // 2. Registro en la tabla dpersonales
            DB::table('dpersonales')->updateOrInsert(
                ['num_economico' => $request->num_economico],
                [
                    'edificio'   => strtoupper($request->edificio),
                    'nivel'      => strtoupper($request->nivel),
                    'cubiculo'   => strtoupper($request->cubiculo),
                    'extension'  => $request->extension,
                    'created_at' => DB::raw('IFNULL(created_at, NOW())'), 
                    'updated_at' => now()
                ]
            );

            // 3. Registro en la tabla ticket 
            Ticket::create([
                'descripcion'     => $request->descripcion,
                'observaciones'   => $request->observaciones ?? '',
                'id_coordinacion' => $request->id_coordinacion,
                'id_seccion'      => $request->id_seccion,
                'id_servicio'     => $request->id_servicio,
                'num_economico'   => $request->num_economico,

            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Datos de ubicación y ticket registrados correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error crítico en storeDatosPersonales: " . $e->getMessage());
            
            return redirect()->back()->withErrors([
                'error' => 'No se pudo completar el registro. Detalle: ' . $e->getMessage()
            ])->withInput();
        }
    }
}