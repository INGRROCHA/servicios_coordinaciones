<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithPagination;

class TicketSearchUser extends Component
{
    use WithPagination;

    // Propiedades de estado estables
    public $search = '';
    public $sortBy = 'id_ticket';
    public $sortDir = 'desc';
    public $perPage = 10;
    public ?string $no_economico = null;
    
    // Filtros activos coordinados
    public $selectedEstado = null;
    public $coordinacionId = null; 

    public function mount(?string $no_economico = null)
    {
        // 1. Leemos el número económico de la sesión si no se pasa como parámetro
        $this->no_economico = $no_economico ?? session('no_economico');

        // 2. Seguridad: Si de alguna manera entra y no hay sesión, lo regresamos al login
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

    // Método que escucha a los botones de estado
    public function setEstadoFilter($estadoId)
    {
        $this->selectedEstado = $estadoId;
        $this->resetPage();
    }

    // Nuevo método que escucha a los botones de coordinación
    public function setCoordinacionFilter($coordinacionId)
    {
        $this->coordinacionId = $coordinacionId;
        $this->resetPage();
    }

    public function render()
    {
        // 1. Iniciamos la consulta base fijando los LEFT JOINS y restricciones del usuario
        $query = Ticket::query()
            ->select('ticket.*') 
            ->leftJoin('servicios', 'ticket.id_servicio', '=', 'servicios.id_servicio')
            ->leftJoin('secciones', 'ticket.id_seccion', '=', 'secciones.id_seccion')
            ->leftJoin('coordinaciones', 'ticket.id_coordinacion', '=', 'coordinaciones.id_coordinacion')
            ->with(['seccion', 'servicio', 'coordinacion', 'estadoRelacion']) 
            ->where('ticket.num_economico', $this->no_economico) 
            
            // Filtro dinámico de Estados
            ->when($this->selectedEstado, function ($q) {
                $q->where('ticket.estado', $this->selectedEstado);
            })
            // Nuevo filtro dinámico de Coordinación heredado
            ->when($this->coordinacionId, function ($q) {
                $q->where('ticket.id_coordinacion', $this->coordinacionId);
            });

        // 2. Aplicamos la búsqueda por caracteres (Search)
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

        // 3. Sistema de Ordenamiento Estructurado
        if ($this->sortBy === 'nombre_servicio') {
            $query->orderBy('servicios.servicio', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_seccion') {
            $query->orderBy('secciones.seccion', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_coordinacion') {
            $query->orderBy('coordinaciones.coordinacion', $this->sortDir);
        } else {
            $query->orderBy('ticket.' . $this->sortBy, $this->sortDir);
        }

        // 4. Ejecutamos la paginación limpia
        $tickets = $query->paginate($this->perPage);

        return view('livewire.ticket-search-user', [
            'tickets' => $tickets
        ])->layout('components.layout');
    }
}