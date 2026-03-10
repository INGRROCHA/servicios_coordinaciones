<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; 

class EditarController extends Controller
{
    /**
     * Método para procesar la actualización del ticket.
     * Ruta esperada: Route::put('/tickets/{id_ticket}', [EditarController::class, 'editarTicket']);
     */
    public function editarTicket(Request $request, $id_ticket) 
    {
        // 1. Validación
        $request->validate([
            'coordinacion' => 'required',
            'seccion'      => 'required',
            'servicio'     => 'required',
        ], [
            'coordinacion.required' => 'Es obligatorio seleccionar una Coordinación.',
            'seccion.required'      => 'Es obligatorio seleccionar una Sección.',
            'servicio.required'     => 'Es obligatorio seleccionar un Servicio.',
        ]);

        // 2. Procesar lógica del servicio
        $id_servicio = is_array($request->input('servicio')) 
            ? ($request->input('servicio')[0] ?? null) 
            : $request->input('servicio');

        // 3. Actualización usando Eloquent para aprovechar eventos y relaciones
        $ticket = Ticket::where('id_ticket', $id_ticket)->firstOrFail();
        
        $ticket->update([
            'id_coordinacion' => $request->input('coordinacion'),
            'id_seccion'      => $request->input('seccion'), 
            'id_servicio'     => $id_servicio,
            'descripcion'     => $request->input('descripcion') ?? null,
            'id_estado'       => 1, // Para desarrollo, se asigna el estado "Abierto"
            'id_tr_secc'      => $request->input('id_tr_secc') ?? null,
        ]);

        // 4. Redirección
        return redirect('/tickets/index')->with('success', 'Ticket actualizado exitosamente.');
    }
}