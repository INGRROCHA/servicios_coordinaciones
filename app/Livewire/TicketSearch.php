<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithPagination;

class TicketSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $coordinacionId; // Propiedad para recibir el ID

    // El método mount se ejecuta una sola vez al cargar el componente
    public function mount($coordinacionId = null)
    {
        $this->coordinacionId = $coordinacionId;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $tickets = Ticket::with(['seccion', 'servicio']) 
            ->where('id_coordinacion', $this->coordinacionId) 
            ->where(function($query) {
                $query->where('id_ticket', 'like', '%' . $this->search . '%')
                    ->orWhere('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('descripcion', 'like', '%' . $this->search . '%')
                    ->orWhere('num_economico', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id_ticket', 'desc')
            ->paginate(10);

        return view('livewire.ticket-search', [
            'tickets' => $tickets
        ]);
    }
}