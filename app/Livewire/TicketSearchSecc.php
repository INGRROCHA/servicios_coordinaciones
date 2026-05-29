<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithPagination;

class TicketSearchSecc extends Component
{
    use WithPagination;

    public $search = '';
    public ?int $seccionId = null; 
    public $sortBy = 'id_ticket';
    public $sortDir = 'desc';
    public $perPage = 10; 

    public function mount($seccionId = null)
    {
        $this->seccionId = $seccionId;
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
        // 1. Consulta base
        $query = Ticket::query()
            ->select('ticket.*') 
            ->leftJoin('servicios', 'ticket.id_servicio', '=', 'servicios.id_servicio')
            ->leftJoin('coordinaciones', 'ticket.id_coordinacion', '=', 'coordinaciones.id_coordinacion') 
            ->with(['seccion', 'servicio', 'coordinacion','estadoRelacion']) 
            ->where('ticket.id_seccion', $this->seccionId);

        // 2. Aplicamos la búsqueda expandida
        $query->where(function($q) {
            $q->where('ticket.id_ticket', 'like', '%' . $this->search . '%')
              ->orWhere('ticket.nombre', 'like', '%' . $this->search . '%')
              ->orWhere('ticket.descripcion', 'like', '%' . $this->search . '%')
              ->orWhere('servicios.servicio', 'like', '%' . $this->search . '%')
              ->orWhere('coordinaciones.coordinacion', 'like', '%' . $this->search . '%');
        });

        // 3. Aplicamos el ordenamiento
        if ($this->sortBy === 'nombre_servicio') {
            $query->orderBy('servicios.servicio', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_coordinacion') { 
            $query->orderBy('coordinaciones.coordinacion', $this->sortDir);
        } else {
            $query->orderBy('ticket.' . $this->sortBy, $this->sortDir);
        }

        // 4. Ejecutamos la paginación
        $tickets = $query->paginate($this->perPage);

        return view('livewire.ticket-search-secc', [
            'tickets' => $tickets
        ])->layout('components.layout');
    }
}