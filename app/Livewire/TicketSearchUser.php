<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithPagination;

class TicketSearchUser extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id_ticket';
    public $sortDir = 'desc';
    public $perPage = 10;
    public ?string $no_economico = null;
    
    public $selectedEstado = null;
    public $coordinacionId = null; 

    public function mount(?string $no_economico = null)
    {
        $this->no_economico = $no_economico ?? session('no_economico');

        if (!$this->no_economico) {
            return redirect()->route('login');
        }
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

    public function setEstadoFilter($estadoId)
    {
        $this->selectedEstado = $estadoId;
        $this->resetPage();
    }

    public function setCoordinacionFilter($coordinacionId)
    {
        $this->coordinacionId = $coordinacionId;
        $this->resetPage();
    }

    public function render()
    {
        $query = Ticket::query()
            ->select('ticket.*') 
            ->leftJoin('servicios', 'ticket.id_servicio', '=', 'servicios.id_servicio')
            ->leftJoin('secciones', 'ticket.id_seccion', '=', 'secciones.id_seccion')
            ->leftJoin('coordinaciones', 'ticket.id_coordinacion', '=', 'coordinaciones.id_coordinacion')
            ->with(['seccion', 'servicio', 'coordinacion', 'estadoRelacion']) 
            ->where('ticket.num_economico', $this->no_economico) 
            
            ->when($this->selectedEstado, function ($q) {
                $q->where('ticket.estado', $this->selectedEstado);
            })
            ->when($this->coordinacionId, function ($q) {
                $q->where('ticket.id_coordinacion', $this->coordinacionId);
            });

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('ticket.id_ticket', 'like', '%' . $this->search . '%')
                  ->orWhere('ticket.nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('ticket.descripcion', 'like', '%' . $this->search . '%')
                  ->orWhere('servicios.servicio', 'like', '%' . $this->search . '%')
                  ->orWhere('secciones.seccion', 'like', '%' . $this->search . '%')
                  ->orWhere('coordinaciones.coordinacion', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->sortBy === 'nombre_servicio') {
            $query->orderBy('servicios.servicio', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_seccion') {
            $query->orderBy('secciones.seccion', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_coordinacion') {
            $query->orderBy('coordinaciones.coordinacion', $this->sortDir);
        } else {
            $query->orderBy('ticket.' . $this->sortBy, $this->sortDir);
        }

        $tickets = $query->paginate($this->perPage);

        return view('livewire.ticket-search-user', [
            'tickets' => $tickets
        ])->layout('components.layout');
    }
}