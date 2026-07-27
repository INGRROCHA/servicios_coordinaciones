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
        // 1. Obtenemos los trabajadores de la sección con paginación
        $trabajadores = Trabajador::with('servicio')
                            ->where('id_seccion', $this->id_seccion)
                            ->orderBy('id_tr_secc', 'desc')
                            ->paginate(10);

        // 2. Obtenemos solo los servicios ACTIVOS que pertenecen a esta sección
        $serviciosDisponibles = Servicio::where('id_seccion', $this->id_seccion)
                            ->where('estatus', 1) 
                            ->get();

        return view('livewire.admin-tr-secc', compact('trabajadores', 'serviciosDisponibles'));
    }
}