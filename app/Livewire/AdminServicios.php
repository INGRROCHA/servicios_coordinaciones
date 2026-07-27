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

        // 1. Obtener el prefijo basado en la sección actual
        $prefijo = $this->obtenerPrefijo($this->id_seccion);

        // 2. Buscar el último id_servicio registrado con ese prefijo en esta tabla
        $ultimoServicio = Servicio::where('id_servicio', 'like', $prefijo . '\_%')
            ->orderByRaw("CAST(SUBSTRING_INDEX(id_servicio, '_', -1) AS UNSIGNED) DESC")
            ->first();

        // 3. Calcular el siguiente número
        $siguienteNumero = 1;
        if ($ultimoServicio) {
            $partes = explode('_', $ultimoServicio->id_servicio);
            $ultimoNumero = (int) end($partes);
            $siguienteNumero = $ultimoNumero + 1;
        }

        // 4. Armar el nuevo ID
        $nuevoIdServicio = $prefijo . '_' . $siguienteNumero;

        // 5. Crear el registro asignando manualmente el ID generado
        Servicio::create([
            'id_servicio' => $nuevoIdServicio,
            'servicio'    => $this->nuevoServicio,
            'id_seccion'  => $this->id_seccion,
            'estatus'     => 1
        ]);

        $this->reset('nuevoServicio');
        session()->flash('mensaje', "Servicio creado exitosamente con código: $nuevoIdServicio");
    }

    // Función auxiliar para asignar el prefijo correcto
    private function obtenerPrefijo($idSeccion)
    {
        return match((string) $idSeccion) {
            '11' => 'saat',
            '12' => 'redes',
            '13' => 'saos',
            '14' => 'dsistemas',
            '21' => 'ij',
            '22' => 'transp',
            '23' => 'vigil',
            '31' => 'mc',
            '32' => 'me',
            '33' => 'mabi',
            '41' => 'café',
            '42' => 'adep',
            default => 'gen', // Genérico en caso de que no coincida
        };
    }

    public function render()
    {
        $servicios = Servicio::where('id_seccion', $this->id_seccion)
            // Cambiamos el orderBy para que ordene numéricamente y no alfabéticamente
            ->orderByRaw("CAST(SUBSTRING_INDEX(id_servicio, '_', -1) AS UNSIGNED) DESC")
            ->paginate(10);

        return view('livewire.admin-servicios', compact('servicios'));
    }
}