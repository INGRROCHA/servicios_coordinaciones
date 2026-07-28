<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Servicio extends Model
{
    use LogsActivity;

    protected $table = 'servicios';
    protected $primaryKey = 'id_servicio';

    // Desactivar el auto-incremento interno de Laravel
    public $incrementing = false;
    
    // Indicar que la llave es de tipo string
    protected $keyType = 'string';

    protected $fillable = [
        'id_servicio',
        'servicio',
        'id_seccion',
        'estatus',
        'created_at',
        'updated_at'
    ];
    
    // ==========================================
    // CONFIGURACIÓN DE SPATIE ACTIVITYLOG
    // ==========================================
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() 
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('servicio_modificacion'); 
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        // 1. Capturamos el nombre desde la sesión activa
        $nombreUsuario = session('nombre_completo', 'Usuario Desconocido');
        
        $propiedadesActuales = $activity->properties instanceof \Illuminate\Support\Collection 
            ? $activity->properties 
            : collect($activity->properties ?? []);

        // 2. Fusionamos los datos y agregamos manualmente los campos del servicio
        $activity->properties = $propiedadesActuales->merge([
            'causer_name' => $nombreUsuario,
            'id_servicio' => $this->id_servicio, // Inyectamos el ID (ej. saat_1)
            'servicio'    => $this->servicio,    // Inyectamos el nombre del servicio
        ]);
    }
    // ==========================================

    public function ticket(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

     public function estadoRelacion(): HasMany
    {
        return $this->hasMany(Estado::class);
    }
}