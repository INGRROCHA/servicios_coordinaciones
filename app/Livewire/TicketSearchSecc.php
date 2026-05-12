<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithPagination;

class TicketSearchSecc extends Component
{
    use WithPagination;

    public $search = '';
    public $seccionId; // Propiedad para recibir el ID
    public $sortBy = 'id_ticket';
    public $sortDir = 'desc';
    public $perPage = 10; 

    // El método mount se ejecuta una sola vez al cargar el componente
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
        $tickets = Ticket::with(['seccion', 'servicio']) 
            ->where('id_seccion', $this->seccionId) 
            ->where(function($query) {
                $query->where('id_ticket', 'like', '%' . $this->search . '%')
                    ->orWhere('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('descripcion', 'like', '%' . $this->search . '%')
                    ->orWhere('num_economico', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.ticket-search', [
            'tickets' => $tickets
        ])->layout('components.layout');
    }
}