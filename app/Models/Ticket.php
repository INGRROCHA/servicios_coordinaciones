<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Coordinacion;
use App\Models\Seccion;
use App\Models\Servicio;
use App\Models\Estado;
use Spatie\Activitylog\Traits\LogsActivity; 
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;          

class Ticket extends Model
{
    use LogsActivity;

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
        'estado',
        'id_tr_secc',
        'estatus',
        'created_at',
        'updated_at'
    ];
    
    // Valor por defecto para atributos
    protected $attributes = [
        'email'         => '', 
        'descripcion'   => '', 
        'observaciones' => '',
        'estado'        => 1, 
        'id_tr_secc'    => '', 
        'estatus'       => 1, 
    ];

    // Casteo de tipos
    protected $casts = [
        'estado'  => 'integer',
        'estatus' => 'integer',
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
            ->useLogName('ticket_modificacion'); 
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        // 1. Capturamos el nombre desde la sesión activa
        $nombreUsuario = session('nombre_completo', 'Usuario Desconocido');
        $propiedadesActuales = $activity->properties instanceof \Illuminate\Support\Collection 
            ? $activity->properties 
            : collect($activity->properties ?? []);

        // 2. Fusionamos los datos que Spatie ya capturó (cambios viejos/nuevos) con el nombre del usuario que hizo la modificación
        $activity->properties = $propiedadesActuales->merge([
            'causer_name' => $nombreUsuario
        ]);
    }



    // ==========================================
    // ACCESOR PARA EL NOMBRE DEL ESTADO (DINÁMICO DESDE BD)
    // ==========================================
    public function getEstadoNombreAttribute()
    {
        // Navega a través de la relación hacia la tabla estado_ticket
        // y extrae la columna 'tipo_estado'
        return $this->estadoRelacion?->tipo_estado ?? 'Desconocido';
    }

    // ==========================================
    // ACCESOR PARA EL COLOR DEL ESTADO (TAILWIND)
    // ==========================================
    public function getEstadoColorAttribute()
    {
        // Aquí mapeamos los colores directo por el ID numérico del estado
        $colores = [
            1 => 'bg-blue-100 text-blue-800',      // 1 = Abierto
            2 => 'bg-yellow-100 text-yellow-800',  // 2 = En Proceso
            3 => 'bg-red-100 text-red-800',        // 3 = Cancelado
            4 => 'bg-indigo-100 text-indigo-800',  // 4 = Asignado
            5 => 'bg-purple-100 text-purple-800',  // 5 = Reasignado
            9 => 'bg-green-100 text-green-800',    // 9 = Cerrado
        ];

        return $colores[$this->estado] ?? 'bg-gray-100 text-gray-800';
    }

    public $timestamps = true;

    // ==========================================
    // RELACIONES
    // ==========================================

    public function coordinacion(): BelongsTo {
        return $this->belongsTo(Coordinacion::class, 'id_coordinacion', 'id_coordinacion');
    }

    public function seccion(): BelongsTo {
        return $this->belongsTo(Seccion::class, 'id_seccion', 'id_seccion');
    }

    public function servicio(): BelongsTo {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }

    public function users(): BelongsTo {
        return $this->belongsTo(User::class, 'num_economico', 'num_economico');
    }

    public function dpersonales(): BelongsTo {
        return $this->belongsTo(Dpersonales::class, 'num_economico', 'num_economico');
    }
    
    // 🔹 Relación con la tabla estado_ticket
    public function estadoRelacion(): BelongsTo 
    {
        // belongsTo(Modelo, 'llave_foranea_en_ticket', 'llave_primaria_en_estado_ticket')
        return $this->belongsTo(Estado::class, 'estado', 'estado');
    }

    public function trabajadores(): BelongsTo {
        return $this->belongsTo(Trabajador::class, 'id_tr_secc', 'id_tr_secc');
    }

    // ==========================================
    // ACCESORES DE NOMBRES
    // ==========================================

    public function getNombreCoordinacionAttribute() {
        return $this->coordinacion?->nombre ?? 'Sin definir';
    }

    public function getNombreSeccionAttribute() {
        return $this->seccion?->nombre ?? 'Sin definir';
    }

    public function getNombreServicioAttribute() {
        return $this->servicio?->nombre ?? 'Sin definir';
    }
}