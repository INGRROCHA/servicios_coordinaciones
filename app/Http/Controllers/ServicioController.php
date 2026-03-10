<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Coordinacion;
use App\Models\Seccion;
use Barryvdh\DomPDF\Facade\Pdf;


class ServicioController extends Controller
{
    // Método para ver todos los tickets
    public function show()
    {
        $tickets = Ticket::with('coordinacion', 'seccion', 'servicio')->paginate(20);

        return view('tickets.show', compact('tickets'));
    }

    // Método tickets filtrado por coordinación con paginación
    public function ticketsPorCoordinacion($id)
    {
        $coord = Coordinacion::find($id);
        
        if (!$coord) {
            abort(404);
        }

        $tickets = Ticket::with(['coordinacion', 'seccion', 'servicio', 'users', 'dpersonales'])
                        ->where('id_coordinacion', $id)
                        ->paginate(20); 

        return view('coord', compact('tickets', 'coord'));
    }

    // Método tickets filtrado por Seccion con paginación
    public function ticketsPorSeccion($id2)
    {
        $secc = Seccion::find($id2);
        
        if (!$secc) {
            abort(404);
        }

        $tickets = Ticket::with(['coordinacion', 'seccion', 'servicio', 'users', 'dpersonales'])
                        ->where('id_seccion', $id2)
                        ->paginate(20); 

        return view('secc', compact('tickets', 'secc'));
    }

    // Método que edita el ticket por su id_ticket
     public function edit($id_ticket)
    {
        $ticket = Ticket::with(['users', 'dpersonales'])->where('id_ticket', $id_ticket)->firstOrFail();
        return view('tickets.edit', compact('ticket'));
    }

    // Método para ver el PDF
    public function verPdf($id_ticket)
    {  
        $ticket = Ticket::with(['coordinacion', 'seccion', 'servicio', 'users', 'dpersonales'])
                        ->where('id_ticket', $id_ticket)
                        ->firstOrFail();

        return view('tickets.ver-pdf', compact('ticket'));
    }

    // Método para generar el PDF
    public function generarPdf($id_ticket)
    {
        $ticket = Ticket::with(['coordinacion', 'seccion', 'servicio', 'users', 'dpersonales'])
                        ->where('id_ticket', $id_ticket)
                        ->firstOrFail();
        $data = ['ticket' => $ticket];
        $pdf = Pdf::loadView('tickets.generar-pdf', $data);
        return $pdf->download("$id_ticket.pdf");
    }
}
