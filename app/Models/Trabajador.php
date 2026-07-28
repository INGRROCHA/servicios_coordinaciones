<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Trabajador extends Model
{
    use LogsActivity;

    protected $table = 'tr_secc';
    protected $primaryKey = 'id_tr_secc';

    protected $fillable = [
        'id_tr_secc',
        'id_rol',
        'id_seccion',
        'id_servicio',
        'nombre',
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
            ->useLogName('trabajador_modificacion'); 
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        // 1. Capturamos el nombre desde la sesión activa
        $nombreUsuario = session('nombre_completo', 'Usuario Desconocido');
        
        $propiedadesActuales = $activity->properties instanceof \Illuminate\Support\Collection 
            ? $activity->properties 
            : collect($activity->properties ?? []);

        // 2. Fusionamos los datos que Spatie ya capturó con el nombre del usuario,
        // Y agregamos el ID y Nombre del trabajador para que siempre queden registrados
        $activity->properties = $propiedadesActuales->merge([
            'causer_name' => $nombreUsuario,
            'id_tr_secc'  => $this->id_tr_secc, // Inyectamos el ID del trabajador afectado
            'nombre'      => $this->nombre,     // Inyectamos el nombre del trabajador afectado
        ]);
    }
    // ==========================================

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'tr_secc', 'id_ticket');
    }
 
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }
    
    public function seccion(): BelongsTo
    {
        return $this->belongsTo(Seccion::class, 'id_seccion', 'id_seccion');
    }

    public function j_secc(): BelongsTo
    {
        return $this->belongsTo(J_Secc::class);
    }

    public function coordinacion(): BelongsTo
    {
        return $this->belongsTo(Coordinacion::class, 'id_seccion', 'id_coordinacion');
    }
}