<?php

namespace App\Http\Controllers;
use App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CrearController extends Controller
{
    public function buscarPorNomina($num_economico)
    {
        // Buscamos en la tabla users la información base
        $user = DB::table('users')
            ->where('num_economico', $num_economico)
            ->first(['nombre', 'email', 'adscripcion', 'dpto_coord', 'area_secc']);

        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se encontró el registro.'
        ], 404);
    }

    public function crear(Request $request){
    
        // 1. Validamos los datos de entrada (agregamos num_economico que es vital)
        $request->validate([
            'num_economico' => 'required',
            'descripcion'   => 'nullable|string|max:1000',
            'observaciones' => 'nullable|string|max:1000',
            'edificio'      => 'required',
            'nivel'         => 'required',
            'cubiculo'      => 'required',
            'extension'     => 'required'
        ]);

        // 2. OBTENEMOS LA INFORMACIÓN FRESCA DIRECTO DE LA NÓMINA (users)
        // Esto evita que dependamos de los inputs ocultos o de solo lectura del frontend
        $user = DB::table('users')
            ->where('num_economico', $request->num_economico)
            ->first();

        // Verificamos que el usuario realmente exista antes de crear el ticket
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'No se encontró el trabajador en la base de datos de nómina.'])->withInput();
        }

        $descripcion = $request->input('descripcion') ?? '';
        $observaciones = $request->input('observaciones') ?? '';
        
        // 3. Crea el ticket CONGELANDO la información del usuario
        Models\Ticket::create([
            'id_coordinacion' => $request->input('coordinacion'),
            'id_seccion'      => $request->input('seccion'), 
            'id_servicio'     => is_array($request->input('servicio')) ? ($request->input('servicio')[0] ?? null) : $request->input('servicio'),
            'num_economico'   => $request->input('num_economico'),
            
            // --- AQUÍ CONGELAMOS LOS DATOS DIRECTO DE LA BD ---
            'nombre'          => $user->nombre,
            'email'           => $user->email,
            'adscripcion'     => $user->adscripcion,
            'dpto_coord'      => $user->dpto_coord,
            'area_secc'       => $user->area_secc,
            // --------------------------------------------------

            'descripcion'     => $descripcion, 
            'observaciones'   => $observaciones, 
            'edo_ticket'      => 1,
            'id_tr_secc'      => null, // Valor por defecto vacío
            'estatus'         => 'activo'
        ]);

        // 4. Actualiza o inserta en dpersonales
        DB::table('dpersonales')->updateOrInsert(
            ['num_economico' => $request->num_economico], // Condición de búsqueda
            [
                'edificio'   => strtoupper($request->edificio),
                'nivel'      => strtoupper($request->nivel),
                'cubiculo'   => strtoupper($request->cubiculo),
                'extension'  => $request->extension,
                // IFNULL mantiene la fecha original si existe, o pone NOW() si es nuevo
                'created_at' => DB::raw('IFNULL(created_at, NOW())'), 
                'updated_at' => now()
            ]
        );

        return redirect('/tickets/show')->with('success', 'Ticket creado exitosamente.');
    }
}