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

    public function render()
    {
        // 1. Iniciamos la consulta base fijando los LEFT JOINS y el SELECT principal
        $query = Ticket::query()
            ->select('ticket.*') // Evita que se mezclen IDs de las tablas unidas
            ->leftJoin('servicios', 'ticket.id_servicio', '=', 'servicios.id_servicio')
            ->leftJoin('secciones', 'ticket.id_seccion', '=', 'secciones.id_seccion')
            ->leftJoin('coordinaciones', 'ticket.id_coordinacion', '=', 'coordinaciones.id_coordinacion')
            ->with(['seccion', 'servicio', 'coordinacion']) // Mantiene la carga optimizada de relaciones
            ->where('ticket.num_economico', $this->no_economico); // Especificamos la tabla para evitar ambigüedad

        // 2. Aplicamos la búsqueda expandida (Search) incluyendo las tablas unidas
        $query->where(function($q) {
            $q->where('ticket.id_ticket', 'like', '%' . $this->search . '%')
              ->orWhere('ticket.nombre', 'like', '%' . $this->search . '%')
              ->orWhere('ticket.descripcion', 'like', '%' . $this->search . '%')
              ->orWhere('servicios.servicio', 'like', '%' . $this->search . '%')
              ->orWhere('secciones.seccion', 'like', '%' . $this->search . '%')
              ->orWhere('coordinaciones.coordinacion', 'like', '%' . $this->search . '%');
        });

        // 3. Aplicamos el Ordenamiento (Sort) de forma simplificada
        if ($this->sortBy === 'nombre_servicio') {
            $query->orderBy('servicios.servicio', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_seccion') {
            $query->orderBy('secciones.seccion', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_coordinacion') {
            $query->orderBy('coordinaciones.coordinacion', $this->sortDir);
        } else {
            // Columnas directas de la tabla ticket
            $query->orderBy('ticket.' . $this->sortBy, $this->sortDir);
        }

        // 4. Ejecutamos la paginación
        $tickets = $query->paginate($this->perPage);

        return view('livewire.ticket-search-user', [
            'tickets' => $tickets
        ])->layout('components.layout');
    }
}
