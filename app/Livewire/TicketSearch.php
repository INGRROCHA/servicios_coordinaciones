<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithPagination;

class TicketSearch extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

	public function render()
	{

		$tickets = Ticket::with(['coordinacion', 'seccion', 'servicio']) 
			->where(function($query) {
				$query->where('id_ticket', 'like', '%' . $this->search . '%')
					  ->orWhere('nombre', 'like', '%' . $this->search . '%')
					  ->orWhere('descripcion', 'like', '%' . $this->search . '%')
					  ->orWhere('num_economico', 'like', '%' . $this->search . '%');					  
			})
			->orderBy('id_ticket', 'asc')
			->paginate(10);

		return view('livewire.ticket-search', [
			'tickets' => $tickets
		]);
	}
}