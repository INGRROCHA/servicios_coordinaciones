<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CrearController extends Controller
{
    public function buscarPorNomina($num_economico)
    {
        $user = DB::connection('nomina')
            ->table('Empleados')
            // Dejamos SOLO el JOIN de Adscripciones. 
            // ELIMINAMOS por completo el leftJoin de CE_Correo_Empleados de aquí.
            ->join('Adscripciones', 'Empleados.pagaduria', '=', 'Adscripciones.ClaveAdscripcion') 
            ->where('Empleados.Estado', 1)
            ->where('Empleados.NumeroEconomico', $num_economico)
            ->select(
                DB::raw("CONCAT(Empleados.Nombre, ' ', Empleados.ApellidoPaterno, ' ', Empleados.ApellidoMaterno) AS nombre"),
                'Adscripciones.NombreAdscripcion1 AS adscripcion',
                'Adscripciones.NombreAdscripcion2 AS dpto_coord',
                'Adscripciones.NombreSeccionOficinaArea AS area_secc',
                // La subconsulta solitaria se encarga del correo
                DB::raw("(SELECT CE_Email FROM CE_Correo_Empleados WHERE CE_NumEconomico = Empleados.NumeroEconomico LIMIT 1) AS email")
            )
            ->first();

        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se encontró el registro activo en la base de datos.'
        ], 404);
    }

    public function crear(Request $request)
    {
        // 1. Validamos los datos de entrada
        $request->validate([
            'num_economico' => 'required',
            'descripcion'   => 'nullable|string|max:1000',
            'observaciones' => 'nullable|string|max:1000',
            'edificio'      => 'required',
            'nivel'         => 'required',
            'cubiculo'      => 'required',
            'extension'     => 'required'
        ]);

        // 2. OBTENEMOS LA INFORMACIÓN DE LA BASE DE DATOS EXTERNA
        $user = DB::connection('nomina')
            ->table('Empleados')
            ->join('Adscripciones', 'Empleados.pagaduria', '=', 'Adscripciones.ClaveAdscripcion')
            ->where('Empleados.NumeroEconomico', $request->num_economico)
            ->where('Empleados.Estado', 1)
            ->select(
                DB::raw("CONCAT(Empleados.Nombre, ' ', Empleados.ApellidoPaterno, ' ', Empleados.ApellidoMaterno) AS nombre"),
                // Usamos la subconsulta también aquí en lugar de llamarlo directamente
                DB::raw("(SELECT CE_Email FROM CE_Correo_Empleados WHERE CE_NumEconomico = Empleados.NumeroEconomico LIMIT 1) AS email"),
                'Adscripciones.NombreAdscripcion1 AS adscripcion',
                'Adscripciones.NombreAdscripcion2 AS dpto_coord',
                'Adscripciones.NombreSeccionOficinaArea AS area_secc'
            )
            ->first();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'No se encontró el trabajador en la base de datos.'])->withInput();
        }

        $descripcion = $request->input('descripcion') ?? '';
        $observaciones = $request->input('observaciones') ?? '';
        
        // 3. Crea el ticket en la BD PRINCIPAL
        Models\Ticket::create([
            'id_coordinacion' => $request->input('coordinacion'),
            'id_seccion'      => $request->input('seccion'), 
            'id_servicio'     => is_array($request->input('servicio')) ? ($request->input('servicio')[0] ?? null) : $request->input('servicio'),
            'num_economico'   => $request->input('num_economico'),
            
            // Congelamos los datos traídos desde la DB Externa
            'nombre'          => $user->nombre,
            'email'           => $user->email, // Si no tiene correo, insertará NULL o vacío, pero no fallará
            'adscripcion'     => $user->adscripcion,
            'dpto_coord'      => $user->dpto_coord,
            'area_secc'       => $user->area_secc,

            'descripcion'     => $descripcion, 
            'estado'          => 1, // Para desarrollo, se asigna el estado "Abierto"
            'observaciones'   => $observaciones, 
            'id_tr_secc'      => null, 
            'estatus'         => 'activo'
        ]);

        // 4. Actualiza o inserta en dpersonales (BD PRINCIPAL)
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

        return redirect('/tickets/show')->with('success', 'Ticket creado exitosamente.');
    }
}