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
            // Iniciamos la consulta base
            $query = Ticket::query()
                ->with(['seccion', 'servicio'])
                ->where('num_economico', $this->no_economico);

            // Aplicamos la búsqueda (Search)
            $query->where(function($q) {
                $q->where('id_ticket', 'like', '%' . $this->search . '%')
                ->orWhere('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('descripcion', 'like', '%' . $this->search . '%');
            });

            // Ordenar usando joins para columnas relacionadas:
            if ($this->sortBy === 'nombre_servicio') {
                $query->join('servicios', 'ticket.id_servicio', '=', 'servicios.id_servicio')
                    ->orderBy('servicios.servicio', $this->sortDir)
                    ->select('ticket.*');
            } elseif ($this->sortBy === 'nombre_seccion') {
                $query->join('secciones', 'ticket.id_seccion', '=', 'secciones.id_seccion')
                    ->orderBy('secciones.seccion', $this->sortDir)
                    ->select('ticket.*');
            } else {
                $query->orderBy($this->sortBy, $this->sortDir);
            }


            // Ejecutamos la paginación
            $tickets = $query->paginate($this->perPage);

            return view('livewire.ticket-search-user', [
                'tickets' => $tickets
            ])->layout('components.layout');
        }
}