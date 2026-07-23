<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Servicio;

class AdminServicios extends Component
{
    use WithPagination;

    public $id_seccion;
    
    // Campos para nuevo registro
    public $nuevoServicio = '';

    public function toggleEstatus($id)
    {
        $servicio = Servicio::find($id);
        if ($servicio) {
            $servicio->estatus = $servicio->estatus == 1 ? 0 : 1;
            $servicio->save();
        }
    }

    public function guardar()
    {
        $this->validate([
            'nuevoServicio' => 'required|string|max:255'
        ]);

        Servicio::create([
            'servicio' => $this->nuevoServicio,
            'id_seccion' => $this->id_seccion,
            'estatus' => 1 // Activo por defecto
        ]);

        $this->reset('nuevoServicio');
        session()->flash('mensaje', 'Servicio creado exitosamente.');
    }

    public function render()
    {
        $servicios = Servicio::where('id_seccion', $this->id_seccion)
                            ->orderBy('id_servicio', 'desc')
                            ->paginate(10);

        return view('livewire.admin-servicios', compact('servicios'));
    }
}