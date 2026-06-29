<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithPagination;

class TicketSearchCoord extends Component
{
    use WithPagination;

    public $search = '';
    public ?int $coordinacionId = null;
    public $sortBy = 'id_ticket';
    public $sortDir = 'desc';
    public $perPage = 10; 

    public function mount($coordinacionId = null)
    {
        $this->coordinacionId = $coordinacionId;
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }

    public ?int $seccionId = null;

    public function setSeccionFilter($seccionId)
    {
        $this->seccionId = $seccionId;
        $this->resetPage();
    }

    public function setSort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDir = ($this->sortDir === 'asc') ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }

    protected $paginationTheme = 'tailwind';

    public $selectedEstado = null;

    public function setEstadoFilter($estadoId)
    {
        $this->selectedEstado = $estadoId;
        $this->resetPage();
    }

    public $mostrarModal = false;
    public $ticketSeleccionado = null;
    public $mostrarModalPdf = false;

    public function verHistorial($id_ticket)
    {
        $this->ticketSeleccionado = \App\Models\Ticket::with(['coordinacion', 'seccion', 'servicio', 'trabajadores', 'activities.causer', 'estadoRelacion'])->find($id_ticket);
        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->ticketSeleccionado = null;
    }

    public function verPdf($id_ticket)
    {
        $this->ticketSeleccionado = \App\Models\Ticket::with(['coordinacion', 'seccion', 'servicio', 'trabajadores', 'dpersonales'])->find($id_ticket);
        $this->mostrarModalPdf = true;
    }

    public function cerrarModalPdf()
    {
        $this->mostrarModalPdf = false;
        $this->ticketSeleccionado = null;
    }

    public function render()
    {
        // 1. Consulta base
        $query = Ticket::query()
            ->select('ticket.*') 
            ->leftJoin('servicios', 'ticket.id_servicio', '=', 'servicios.id_servicio')
            ->leftJoin('secciones', 'ticket.id_seccion', '=', 'secciones.id_seccion')
            ->with(['seccion', 'servicio', 'coordinacion','estadoRelacion']) 
            ->where('ticket.id_coordinacion', $this->coordinacionId)
            
            // Filtro de los botones de estado (si se ha seleccionado alguno)
            ->when($this->selectedEstado, function ($q) {
                return $q->where('ticket.estado', $this->selectedEstado);
            })
            
            // Filtro para la sección seleccionada
            ->when($this->seccionId, function ($q) {
                return $q->where('ticket.id_seccion', $this->seccionId);
            });

        // 2. Aplicamos la búsqueda expandida SOLO si el buscador tiene texto escrito
        $query->when(filled($this->search), function($q) {
            return $q->where(function($subQuery) {
                $subQuery->where('ticket.id_ticket', 'like', '%' . $this->search . '%')
                  ->orWhere('ticket.nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('ticket.descripcion', 'like', '%' . $this->search . '%')
                  ->orWhere('servicios.servicio', 'like', '%' . $this->search . '%')
                  ->orWhere('secciones.seccion', 'like', '%' . $this->search . '%');
            });
        });

        // Ordenamiento de columnas
        if ($this->sortBy === 'nombre_seccion') {
            $query->orderBy('secciones.seccion', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_servicio') {
            $query->orderBy('servicios.servicio', $this->sortDir);
        } else {
            $query->orderBy('ticket.' . $this->sortBy, $this->sortDir);
        }

        // 3. Ejecutamos la paginación una sola vez de forma limpia
        $tickets = $query->paginate($this->perPage);

        // Obtener colecciones de apoyo
        $secciones = \App\Models\Seccion::where('id_coordinacion', $this->coordinacionId)->get();

        return view('livewire.ticket-search-coord', [
            'tickets' => $tickets,
            'secciones' => $secciones 
        ])->layout('components.layout');
    }
}