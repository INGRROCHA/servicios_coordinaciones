<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Servicio;
use Livewire\WithPagination;

class AdminServicios extends Component
{
    use WithPagination;

    public $search = '';
    public ?int $seccionId = null; 
    public $sortBy = 'id_servicio';
    public $sortDir = 'desc';
    public $perPage = 10; 

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
        // 1. Consulta base
        $query = Servicio::query()
            ->select('servicios.*') 
            ->leftJoin('secciones', 'servicios.id_seccion', '=', 'secciones.id_seccion') 
            ->with(['id_servicio','seccion', 'servicio', 'estatus']) 
            ->where('servicios.id_seccion', $this->seccionId)
            // Filtro de los botones de estado (si se ha seleccionado alguno)
            ->when($this->selectedEstado, function ($q) {
                $q->where('servicios.estado', $this->selectedEstado);
            });

        // 2. Aplicamos la búsqueda expandida
        $query->where(function($q) {
            $q->where('servicios.id_servicio', 'like', '%' . $this->search . '%')
              ->orWhere('servicios.servicio', 'like', '%' . $this->search . '%')
              ->orWhere('servicios.descripcion', 'like', '%' . $this->search . '%')
              ->orWhere('servicios.servicio', 'like', '%' . $this->search . '%')
              ->orWhere('coordinaciones.coordinacion', 'like', '%' . $this->search . '%');
        });

        // 3. Aplicamos el ordenamiento
        if ($this->sortBy === 'nombre_servicio') {
            $query->orderBy('servicios.servicio', $this->sortDir);
        } elseif ($this->sortBy === 'nombre_coordinacion') { 
            $query->orderBy('coordinaciones.coordinacion', $this->sortDir);
        } else {
            $query->orderBy('servicios.' . $this->sortBy, $this->sortDir);
        }

        // 4. Ejecutamos la paginación
        $tickets = $query->paginate($this->perPage);

        return view('livewire.admin-servicios', [
            'tickets' => $tickets
        ])->layout('components.layout');
    }
}