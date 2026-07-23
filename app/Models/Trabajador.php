<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trabajador extends Model
{
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
    // NUEVA RELACIÓN AGREGADA PARA EL DASHBOARD
    // ==========================================
    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }

    // ==========================================
    // RELACIONES EXISTENTES
    // ==========================================
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
        // OJO: Si id_seccion se vincula con id_coordinacion, asegúrate de que esto sea intencional en tu base de datos.
        // Lo habitual sería ('id_coordinacion', 'id_coordinacion') o pasar a través de la tabla secciones.
        return $this->belongsTo(Coordinacion::class, 'id_seccion', 'id_coordinacion');
    }
}