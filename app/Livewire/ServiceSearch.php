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

    /**
     * Obtiene la Coordinación y Sección según el prefijo del código del servicio.
     */
    public function obtenerInfoCategoria(string $codigo): array
    {
        // Extraemos el prefijo antes del guion bajo (ej. 'me' de 'me_1')
        $prefijo = explode('_', $codigo)[0];

        $mapeo = [
            'saat'   => [
                'coordinacion' => 'Coordinación de Servicios de Cómputo',
                'seccion'      => 'Servicios Análisis y Apoyo Técnico'
            ],
            'redes'  => [
                'coordinacion' => 'Coordinación de Servicios de Cómputo',
                'seccion'      => 'Redes y Conectividad'
            ],
            'saos'   => [
                'coordinacion' => 'Coordinación de Servicios de Cómputo',
                'seccion'      => 'Servicios de Administración Operativa de Sistemas'
            ],
            'ij'     => [
                'coordinacion' => 'Coordinación de Servicios Generales',
                'seccion'      => 'Intendencia y Jardinería'
            ],
            'transp' => [
                'coordinacion' => 'Coordinación de Servicios Generales',
                'seccion'      => 'Transportes'
            ],
            'vigil'  => [
                'coordinacion' => 'Coordinación de Servicios Generales',
                'seccion'      => 'Vigilancia'
            ],
            'mc'     => [
                'coordinacion' => 'Coordinación de Espacios Físicos',
                'seccion'      => 'Mantenimiento de Campo'
            ],
            'me'     => [
                'coordinacion' => 'Coordinación de Espacios Físicos',
                'seccion'      => 'Mantenimiento Especializado'
            ],
            'mabi'   => [
                'coordinacion' => 'Coordinación de Espacios Físicos',
                'seccion'      => 'Mantenimiento, Adaptaciones a Bienes Inmuebles'
            ],
            'cafe'   => [
                'coordinacion' => 'Coordinación de Servicios para la Convivencia Integral',
                'seccion'      => 'Cafetería'
            ],
            'adep'   => [
                'coordinacion' => 'Coordinación de Servicios para la Convivencia Integral',
                'seccion'      => 'Actividades Deportivas'
            ],
        ];

        return $mapeo[$prefijo] ?? [
            'coordinacion' => 'Coordinación no especificada',
            'seccion'      => 'Sección no especificada'
        ];
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