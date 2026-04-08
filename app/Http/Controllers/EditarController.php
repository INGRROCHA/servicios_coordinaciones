<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; 
use Illuminate\Support\Facades\DB;

class EditarController extends Controller
{
    /**
     * Método para procesar la actualización del ticket.
     */
    public function editarTicket(Request $request, $id_ticket) 
    {
        // 1. Validación
        $request->validate([
            'coordinacion' => 'required',
            'seccion'      => 'required',
            'servicio'     => 'required',
            'id_tr_secc' => 'nullable|integer',
        ], [
            'coordinacion.required' => 'Es obligatorio seleccionar una Coordinación.',
            'seccion.required'      => 'Es obligatorio seleccionar una Sección.',
            'servicio.required'     => 'Es obligatorio seleccionar un Servicio.',
            'id_tr_secc.integer' => 'El ID del trabajador debe ser un número entero.',
        ]);

        // 2. Procesar lógica del servicio y limpieza de datos
        $id_servicio = is_array($request->input('servicio')) 
            ? ($request->input('servicio')[0] ?? null) 
            : $request->input('servicio');

        // Capturamos el valor del trabajador
        $id_tr_secc = $request->input('id_tr_secc');
        
        // Si JavaScript nos manda la palabra 'undefined' o viene vacío, lo forzamos a null
        if ($id_tr_secc === 'undefined' || $id_tr_secc === '') {
            $id_tr_secc = null;
        }
        // -----------------------------------

        // 3. Actualización usando Eloquent para aprovechar eventos y relaciones
        $ticket = Ticket::where('id_ticket', $id_ticket)->firstOrFail();
        
        $ticket->update([
            'id_coordinacion' => $request->input('coordinacion'),
            'id_seccion'      => $request->input('seccion'), 
            'id_servicio'     => $id_servicio,
            'descripcion'     => $request->input('descripcion') ?? null,
            'id_estado'       => 1, // Para desarrollo, se asigna el estado "Abierto"
            'id_tr_secc'      => $id_tr_secc, // Asignamos el trabajador
        ]);

        // 4. Redirección
        return redirect('/tickets/index')->with('success', 'Ticket actualizado exitosamente.');
    }

     public function obtenerTrabajadoresPorSeccion(Request $request) 
    {
        // 1. Capturamos las variables que vienen en la URL
        $seccion = $request->query('seccion');
        $servicio = $request->query('servicio');

        // Si no mandan sección, regresamos vacío por seguridad
        if (!$seccion) {
            return response()->json(['success' => false, 'trabajadores' => []]);
        }

        // 2. Iniciamos la consulta base
        $query = DB::table('tr_secc')
            ->select('id_tr_secc', 'nombre')
            ->where('estatus', 1)
            ->where('id_seccion', $seccion); // Primer filtro obligatorio

        // 3. Aplicamos el segundo filtro con la lógica corregida
        if ($servicio) {
            // Agrupamos la condición para evitar que el "OR" rompa el filtro de sección
            $query->where(function ($q) use ($servicio) {
                $q->where('id_servicio', $servicio)
                  ->orWhereNull('id_servicio')      // Incluye si el valor es NULL en la BD
                  ->orWhere('id_servicio', '');     // Incluye si el valor está vacío ('') en la BD
            });
        }

        // 4. Ejecutamos la consulta
        $trabajadores = $query->orderBy('nombre', 'asc')->get();

        return response()->json([
            'success' => true,
            'trabajadores' => $trabajadores
        ]);
    }
}