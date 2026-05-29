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

    public function render()
    {
        // 1. Consulta base con prefijo de tabla en el WHERE para evitar ambigüedad
        $query = Ticket::query()
            ->select('ticket.*') 
            ->leftJoin('servicios', 'ticket.id_servicio', '=', 'servicios.id_servicio')
            ->leftJoin('secciones', 'ticket.id_seccion', '=', 'secciones.id_seccion')
            ->with(['seccion', 'servicio', 'coordinacion','estadoRelacion']) 
            ->where('ticket.id_coordinacion', $this->coordinacionId);

        // 2. Aplicamos la búsqueda expandida
        $query->where(function($q) {
            $q->where('ticket.id_ticket', 'like', '%' . $this->search . '%')
              ->orWhere('ticket.nombre', 'like', '%' . $this->search . '%')
              ->orWhere('ticket.descripcion', 'like', '%' . $this->search . '%')
              ->orWhere('servicios.servicio', 'like', '%' . $this->search . '%')
              ->orWhere('secciones.seccion', 'like', '%' . $this->search . '%');
        });
        if ($this->sortBy === 'nombre_seccion') {
            $query->orderBy('secciones.seccion', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_servicio') {
            $query->orderBy('servicios.servicio', $this->sortDir);
        } else {
            $query->orderBy('ticket.' . $this->sortBy, $this->sortDir);
        }

        // 3. Ejecutamos la paginación
        $tickets = $query->paginate($this->perPage);

        return view('livewire.ticket-search-coord', [
            'tickets' => $tickets
        ])->layout('components.layout');
    }
}