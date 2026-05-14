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
    public $no_economico; 

    public function mount($no_economico = null)
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
        $tickets = Ticket::with(['seccion', 'servicio'])
            ->where('num_economico', $this->no_economico) // DB usa 'num_economico'
            ->where(function($query) {
                $query->where('id_ticket', 'like', '%' . $this->search . '%')
                      ->orWhere('nombre', 'like', '%' . $this->search . '%')
                      ->orWhere('descripcion', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.ticket-search-user', [
            'tickets' => $tickets
        ])->layout('components.layout'); // Esto está bien si visitas la ruta directamente
    }
}