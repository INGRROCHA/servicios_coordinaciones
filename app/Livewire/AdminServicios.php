<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Servicio;

class AdminServicios extends Component
{
    use WithPagination;

    public $id_seccion;
    public $nuevoServicio = '';

    // Nuevas propiedades para la tabla interactiva
    public $search = '';
    public $perPage = 10; // Paginación por defecto
    public $sortColumn = 'id_servicio'; // Columna por defecto
    public $sortDirection = 'asc'; // Orden por defecto (ascendente)

    // Cuando el usuario escribe en el buscador, regresamos a la página 1
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Cuando el usuario cambia la cantidad de registros por página, regresamos a la página 1
    public function updatingPerPage()
    {
        $this->resetPage();
    }

    // Función para alternar el ordenamiento al hacer clic en los encabezados
    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            // Si ya estaba ordenando por esta columna, invierte la dirección
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // Si es una columna nueva, empieza en ascendente
            $this->sortDirection = 'asc';
            $this->sortColumn = $column;
        }
    }

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
        $query = Servicio::where('id_seccion', $this->id_seccion);

        // 1. Aplicar la Búsqueda Dinámica
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('servicio', 'like', '%' . $this->search . '%')
                  ->orWhere('id_servicio', 'like', '%' . $this->search . '%');
            });
        }

        // 2. Aplicar el Ordenamiento Dinámico
        if ($this->sortColumn === 'id_servicio') {
            // Ordenamiento especial para los códigos alfanuméricos (me_1, me_10)
            $query->orderByRaw("CAST(SUBSTRING_INDEX(id_servicio, '_', -1) AS UNSIGNED) " . $this->sortDirection);
        } else {
            // Ordenamiento normal para las demás columnas (ej. 'servicio')
            $query->orderBy($this->sortColumn, $this->sortDirection);
        }

        // 3. Aplicar paginación dinámica
        $servicios = $query->paginate($this->perPage);

        return view('livewire.admin-servicios', compact('servicios'));
    }
}