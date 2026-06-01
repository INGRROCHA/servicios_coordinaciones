<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithPagination;

class TicketSearch extends Component
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

    // Guarda el ID del estado seleccionado (null significa "Todos")
    public $selectedEstado = null;

    // Método que escucha a los botones de la vista y reinicia la página al cambiar el filtro
    public function setEstadoFilter($estadoId)
    {
        $this->selectedEstado = $estadoId;
        $this->resetPage();
    }

    public function render()
    {
        // 1. Consulta base global 
        $query = Ticket::query()
            ->select('ticket.*') 
            ->leftJoin('servicios', 'ticket.id_servicio', '=', 'servicios.id_servicio')
            ->leftJoin('secciones', 'ticket.id_seccion', '=', 'secciones.id_seccion')
            ->leftJoin('coordinaciones', 'ticket.id_coordinacion', '=', 'coordinaciones.id_coordinacion') // Incluido para el rastro global
            ->with(['seccion', 'servicio', 'coordinacion','estadoRelacion'])
            // Filtro de los botones de estado (si se ha seleccionado alguno)
            ->when($this->selectedEstado, function ($q) {
                $q->where('ticket.estado', $this->selectedEstado);
            }); 

        // 2. Aplicamos la búsqueda expandida a nivel sistema
        $query->where(function($q) {
            $q->where('ticket.id_ticket', 'like', '%' . $this->search . '%')
              ->orWhere('ticket.nombre', 'like', '%' . $this->search . '%')
              ->orWhere('ticket.descripcion', 'like', '%' . $this->search . '%')
              ->orWhere('servicios.servicio', 'like', '%' . $this->search . '%')
              ->orWhere('secciones.seccion', 'like', '%' . $this->search . '%')
              ->orWhere('coordinaciones.coordinacion', 'like', '%' . $this->search . '%'); // Buscable globalmente
        });

        // 3. Ordenamiento completo para las 3 tablas relacionales
        if ($this->sortBy === 'nombre_seccion') {
            $query->orderBy('secciones.seccion', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_servicio') {
            $query->orderBy('servicios.servicio', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_coordinacion') {
            $query->orderBy('coordinaciones.coordinacion', $this->sortDir); // Ordenable globalmente
        } else {
            $query->orderBy('ticket.' . $this->sortBy, $this->sortDir);
        }

        // 4. Ejecutamos la paginación
        $tickets = $query->paginate($this->perPage);

        return view('livewire.ticket-search', [
            'tickets' => $tickets
        ])->layout('components.layout');
    }
}