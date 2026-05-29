<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CrearController extends Controller
{

    // =====================================================================
    // Carga la vista de creación de tickets y envía la lista de adscripciones para el primer dropdown
    // =====================================================================
    public function create()
    {
        $adscripciones_lista = DB::connection('nomina')->table('Adscripciones')
            ->select('NombreAdscripcion1')
            ->whereNotNull('NombreAdscripcion1')
            ->where('NombreAdscripcion1', '!=', '')
            ->distinct()
            ->orderBy('NombreAdscripcion1')
            ->pluck('NombreAdscripcion1');

        return view('tickets.create', compact('adscripciones_lista'));
    }

    // =====================================================================
    // MÉTODOS AJAX PARA LISTAS EN CASCADA
    // =====================================================================
    public function getDepartamentos(Request $request)
    {
        $dptos = DB::connection('nomina')->table('Adscripciones')
            ->select('NombreAdscripcion2')
            ->where('NombreAdscripcion1', $request->adscripcion) // Filtramos por Adscripcion1
            ->whereNotNull('NombreAdscripcion2')
            ->where('NombreAdscripcion2', '!=', '')
            ->distinct()
            ->orderBy('NombreAdscripcion2')
            ->pluck('NombreAdscripcion2');
            
        return response()->json($dptos);
    }

    public function getAreas(Request $request)
    {
        $areas = DB::connection('nomina')->table('Adscripciones')
            ->select('NombreSeccionOficinaArea')
            ->where('NombreAdscripcion1', $request->adscripcion) // Filtramos por Adscripcion1
            ->where('NombreAdscripcion2', $request->dpto)        // Filtramos por Adscripcion2
            ->whereNotNull('NombreSeccionOficinaArea')
            ->where('NombreSeccionOficinaArea', '!=', '')
            ->distinct()
            ->orderBy('NombreSeccionOficinaArea')
            ->pluck('NombreSeccionOficinaArea');
            
        return response()->json($areas);
    }

    // =====================================================================
    // MÉTODO AJAX: Busca los datos del usuario en tiempo real
    // =====================================================================
    public function buscarPorNomina($num_economico)
    {
        $user = DB::connection('nomina')
            ->table('Empleados')
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

    // =====================================================================
    // MÉTODO POST: Guarda el ticket en la BD Principal
    // =====================================================================
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
            'extension'     => 'required',
            'adscripcion'   => 'nullable|string', 
            'dpto_coord'    => 'nullable|string',
            'area_secc'     => 'nullable|string',
        ]);

        // 2. Obtenemos información base del trabajador por seguridad (para nombre y correo)
        $user = DB::connection('nomina')
            ->table('Empleados')
            ->join('Adscripciones', 'Empleados.pagaduria', '=', 'Adscripciones.ClaveAdscripcion')
            ->where('Empleados.NumeroEconomico', $request->num_economico)
            ->where('Empleados.Estado', 1)
            ->select(
                DB::raw("CONCAT(Empleados.Nombre, ' ', Empleados.ApellidoPaterno, ' ', Empleados.ApellidoMaterno) AS nombre"),
                DB::raw("(SELECT CE_Email FROM CE_Correo_Empleados WHERE CE_NumEconomico = Empleados.NumeroEconomico LIMIT 1) AS email")
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
            'nombre'          => $user->nombre,
            'email'           => $user->email, 
            
            // Tomamos los valores del formulario (lo que el usuario seleccionó/modificó)
            'adscripcion'     => $request->input('adscripcion'),
            'dpto_coord'      => $request->input('dpto_coord'),
            'area_secc'       => $request->input('area_secc'),

            'descripcion'     => $descripcion, 
            'observaciones'   => $observaciones, 
            'id_tr_secc'      => null, 

            // Usamos la constante del modelo en lugar de un número duro
            'estado'          => 1,
            'estatus'         => true // Al ser booleano mandamos 'true' (o 1, ambos funcionan)
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

        return redirect('/show')->with('success', 'Ticket creado exitosamente.');
    }
}