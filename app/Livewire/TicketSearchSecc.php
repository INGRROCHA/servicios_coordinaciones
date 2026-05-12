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

    // El método mount se ejecuta una sola vez al cargar el componente
    public function mount($seccionId = null)
    {
        $this->seccionId = $seccionId;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

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
            ->orderBy('id_ticket', 'desc')
            ->paginate(10);

        return view('livewire.ticket-search', [
            'tickets' => $tickets
        ]);
    }
}