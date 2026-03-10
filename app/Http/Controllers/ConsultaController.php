<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;


class ConsultaController extends Controller
{
    public function mostrarFormulario()
    {
        // Muestra el formulario vacío al cargar la página
        return view('tickets.index', ['ticket' => null]);
    }

    public function buscarTicket(Request $request)
    {
        $request->validate([
            'id_ticket' => 'required|digits_between:1,5'
        ]);

        // Consulta la base de datos
        $tickets = Ticket::with(['coordinacion', 'seccion', 'servicio', 'activities.causer'])
            ->where('id_ticket', $request->id_ticket)
            ->first();

        return view('tickets.index', ['ticket' => $tickets]);
    }
}
