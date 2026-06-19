<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ServiceSearch extends Component
{
    public $search = '';
    public $results = [];

    // Se activa cada vez que el usuario escribe en el buscador
    public function updatedSearch()
    {
        if (trim($this->search) === '') {
            $this->results = [];
            return;
        }

        // Buscamos el servicio haciendo JOIN con la tabla secciones para conocer su coordinación
        $this->results = DB::table('servicios')
            ->join('secciones', 'servicios.id_seccion', '=', 'secciones.id_seccion')
            ->select(
                'servicios.id_servicio', 
                'servicios.servicio', 
                'servicios.id_seccion', 
                'secciones.id_coordinacion'
            )
            ->where('servicios.servicio', 'like', '%' . $this->search . '%')
            ->where('servicios.estatus', 1) // Solo servicios activos
            ->limit(6)
            ->get();
    }

    // Método al hacer clic en una opción
    public function selectService($id_servicio)
    {
        $service = DB::table('servicios')
            ->join('secciones', 'servicios.id_seccion', '=', 'secciones.id_seccion')
            ->select('servicios.id_servicio', 'servicios.id_seccion', 'secciones.id_coordinacion')
            ->where('servicios.id_servicio', $id_servicio)
            ->first();

        if ($service) {
            // Despachamos los datos exactos requeridos por create.blade.php
            $this->dispatch('service-selected', 
                coordinacion: $service->id_coordinacion,
                seccion: $service->id_seccion,
                id_servicio: $service->id_servicio
            );
        }

        // Limpiamos la búsqueda
        $this->search = '';
        $this->results = [];
    }

    public function render()
    {
        return view('livewire.service-search');
    }
}