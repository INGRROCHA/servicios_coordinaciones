<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Trabajador;
use App\Models\Servicio;

class AdminTrSecc extends Component
{
    use WithPagination;

    public $id_seccion;
    
    // Campos para el nuevo registro
    public $nombre = '';
    public $id_servicio = '';

    // Variables para la tabla dinámica
    public $search = '';
    public $perPage = 10;
    public $sortColumn = 'id_tr_secc'; // Ordenar por ID por defecto
    public $sortDirection = 'asc'; // Orden ascendente por defecto

    // Resetear la paginación cuando se hace una búsqueda
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Método para cambiar el orden de las columnas
    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleEstatus($id)
    {
        $trabajador = Trabajador::find($id);
        if ($trabajador) {
            $trabajador->estatus = $trabajador->estatus == 1 ? 0 : 1;
            $trabajador->save();
        }
    }

    public function guardar()
    {
        // Validamos que el servicio seleccionado exista en la tabla servicios
        $this->validate([
            'nombre' => 'required|string|max:255',
            'id_servicio' => 'sometimes|nullable|exists:servicios,id_servicio'
        ]);

        Trabajador::create([
            'nombre' => $this->nombre,
            'id_seccion' => $this->id_seccion,
            'id_servicio' => $this->id_servicio,
            'id_rol' => 2, // Valor fijo por defecto
            'estatus' => 1 // Activo por defecto
        ]);

        $this->reset(['nombre', 'id_servicio']);
        session()->flash('mensaje', 'Trabajador registrado exitosamente.');
    }

    public function render()
    {
        // 1. Construir la consulta de trabajadores con búsqueda y ordenamiento
        $query = Trabajador::with('servicio')->where('id_seccion', $this->id_seccion);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('id_tr_secc', 'like', '%' . $this->search . '%')
                  ->orWhereHas('servicio', function ($q2) {
                      $q2->where('servicio', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Aplicamos ordenamiento y paginación
        $trabajadores = $query->orderBy($this->sortColumn, $this->sortDirection)
                              ->paginate($this->perPage);

        // 2. Obtenemos solo los servicios ACTIVOS que pertenecen a esta sección
        $serviciosDisponibles = Servicio::where('id_seccion', $this->id_seccion)
                            ->where('estatus', 1) 
                            ->get();

        return view('livewire.admin-tr-secc', compact('trabajadores', 'serviciosDisponibles'));
    }
}