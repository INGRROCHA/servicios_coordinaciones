<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithPagination;

class TicketSearch extends Component
{
    use WithPagination;

    // Propiedades públicas estables para la vista
    public $search = '';
    public $coordinacionId = null; 
    public $selectedEstado = null;
    public $sortBy = 'id_ticket';
    public $sortDir = 'desc';
    public $perPage = 10; 

    protected $paginationTheme = 'tailwind';

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

    // Métodos limpios de asignación de filtros
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
        // 1. Inicialización de la Query estructurada
        $query = Ticket::query()
            ->select('ticket.*') 
            ->leftJoin('servicios', 'ticket.id_servicio', '=', 'servicios.id_servicio')
            ->leftJoin('secciones', 'ticket.id_seccion', '=', 'secciones.id_seccion')
            ->leftJoin('coordinaciones', 'ticket.id_coordinacion', '=', 'coordinaciones.id_coordinacion')
            ->with(['seccion', 'servicio', 'coordinacion', 'estadoRelacion']);

        // 2. Filtros Condicionales Activos
        if (!is_null($this->selectedEstado)) {
            $query->where('ticket.estado', $this->selectedEstado);
        }

        if (!is_null($this->coordinacionId)) {
            $query->where('ticket.id_coordinacion', $this->coordinacionId);
        }

        // 3. Motor de Búsqueda por Cadenas de Texto
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

        // 4. Procesamiento del Ordenamiento Dinámico
        if ($this->sortBy === 'nombre_seccion') {
            $query->orderBy('secciones.seccion', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_servicio') {
            $query->orderBy('servicios.servicio', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_coordinacion') {
            $query->orderBy('coordinaciones.coordinacion', $this->sortDir);
        } else {
            $query->orderBy('ticket.' . $this->sortBy, $this->sortDir);
        }

        return view('livewire.ticket-search', [
            'tickets' => $query->paginate($this->perPage)
        ])->layout('components.layout');
    }
}