<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class J_Secc extends Model
{

    protected $table = 'j_secc';
    protected $primaryKey = 'id_j_secc';
    protected $fillable = [
        'id_j_secc',
        'id_rol', 
        'id_secc', 
        'j_secc', 
        'estatus',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    public function coordinacion(): BelongsTo
    {
        return $this->belongsTo(Coordinacion::class, 'id_seccion', 'id_coordinacion');
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function seccion(): BelongsTo
    {
        return $this->belongsTo(Seccion::class, 'id_secc', 'id_seccion');
    }

    public function ticket(): BelongsTo
    {
        // belongsTo(ModeloRelacionado, 'llave_foranea_en_J_secc', 'llave_primaria_en_Ticket')
        return $this->belongsTo(Ticket::class, 'j_secc', 'id_ticket');
    }

    public function trabajadores(): HasMany
    {
        return $this->hasMany(Trabajador::class, 'id_j_secc', 'id_j_secc');
    }

}
