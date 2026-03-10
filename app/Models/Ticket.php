<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Coordinacion;
use App\Models\Seccion;
use App\Models\Servicio;
use Spatie\Activitylog\Traits\LogsActivity; // <-- 1. Importar el Trait
use Spatie\Activitylog\LogOptions;          // <-- 2.  Importar LogOptions

class Ticket extends Model
{

    use LogsActivity; // <-- 3. Usar el Trait

    protected $table = 'ticket';
    protected $primaryKey = 'id_ticket';
    protected $fillable = [
        'id_ticket',
        'id_coordinacion',
        'id_seccion',
        'id_servicio',
        'nombre',
        'email',
        'num_economico',
        'adscripcion',
        'dpto_coord',
        'area_secc',
        'descripcion',
        'observaciones',
        'id_estado',
        'id_tr_secc',
        'estatus',
        'created_at',
        'updated_at'
    ];
    
    // Valor por defecto para descripción si no se envía
    protected $attributes = [
        'descripcion' => '', // Valor por defecto vacío
        'observaciones' => '',// Valor por defecto vacío
        'id_estado' => 1, // Valor por defecto 1 (Abierto)
        'id_tr_secc' => '', // Valor por defecto vacío
        'estatus' => true, // Valor por defecto activo
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Indica qué campos quieres rastrear cuando cambien
            ->logFillable() 
            // Opcional: Solo registrar si realmente hubo un cambio
            ->logOnlyDirty()
            // Opcional: No guardar registros vacíos si no cambió nada
            ->dontSubmitEmptyLogs()
            // Opcional: Nombre para identificar estos logs fácilmente
            ->useLogName('ticket_modificacion'); 
    }

    // Atributo de estatus como booleano
    protected $casts = [
        'estatus' => 'boolean',
    ];

    public function setEstatusAttribute($value)
    {
        $this->attributes['estatus'] = ($value === 'activo') ? 1 : 0;
    }

    public function getEstatusAttribute($value)
    {
        return $value ? 'activo' : 'inactivo';
    }

    public $timestamps = true;


    // 🔹 Relación con Coordinacion
    public function coordinacion(): BelongsTo
    {
        // belongsTo(ModeloRelacionado, 'llave_foranea_en_ticket', 'llave_primaria_en_coordinacion')
        return $this->belongsTo(Coordinacion::class, 'id_coordinacion', 'id_coordinacion');
    }

    // 🔹 Relación con Sección
    public function seccion(): BelongsTo
    {
        return $this->belongsTo(Seccion::class, 'id_seccion', 'id_seccion');
    }

    // 🔹 Relación con Servicio
    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }

     // 🔹 Relación con User
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'num_economico', 'num_economico');
    }

     // 🔹 Relación con Dpersonales
     public function dpersonales(): BelongsTo
    {
        return $this->belongsTo(Dpersonales::class, 'num_economico', 'num_economico');
    }
    
       // 🔹 Relación con Estado
    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }

        // 🔹 Relación con Trabajadores
    public function trabajadores(): BelongsTo
    {
        // belongsTo(ModeloRelacionado, 'llave_foranea_en_Ticket', 'llave_primaria_en_Trabajadores')
        return $this->belongsTo(Trabajadores::class, 'id_tr_secc', 'id_tr_secc');
    }
        
    

    public function getNombreCoordinacionAttribute()
    {
        return $this->coordinacion?->nombre ?? 'Sin definir';
    }

    public function getNombreSeccionAttribute()
    {
        return $this->seccion?->nombre ?? 'Sin definir';
    }

    public function getNombreServicioAttribute()
    {
        return $this->servicio?->nombre ?? 'Sin definir';
    }


}
