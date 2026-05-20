<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seccion extends Model {
    protected $table = 'secciones';
    protected $primaryKey = 'id_seccion';
    protected $fillable = ['id_rol', 'seccion', 'ClavePuesto', 'Pagaduria', 'estatus'];


    public function servicio(): HasMany
    {
        return $this->hasMany(Servicio::class);
    }
    
    public function ticket(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function trabajadores(): HasMany
    {
        return $this->hasMany(Trabajador::class);
    }

    public function coordinacion(): BelongsTo
    {
        return $this->belongsTo(Coordinacion::class);
    }
}