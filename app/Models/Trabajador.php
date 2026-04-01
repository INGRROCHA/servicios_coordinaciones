<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trabajador extends Model
{

    protected $table = 'tr_secc';
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

    public function ticket(): BelongsTo
    {
        // belongsTo(ModeloRelacionado, 'llave_foranea_en_Trabajadores', 'llave_primaria_en_Ticket')
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
