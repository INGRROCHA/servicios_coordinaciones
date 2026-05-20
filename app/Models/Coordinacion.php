<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coordinacion extends Model
{
    protected $table = 'coordinaciones';
    protected $primaryKey = 'id_coordinacion';
    protected $fillable = ['id_coordinacion', 'id_rol', 'coordinacion', 'ClavePuesto', 'Pagaduria', 'estatus'];
    public $timestamps = false;


    public function seccion(): HasMany
    {
        return $this->hasMany(Seccion::class);
    }

    public function ticket(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function j_secc(): HasMany
    {
        return $this->hasMany(J_Secc::class);
    }

    public function trabajadores(): HasMany
    {
        return $this->hasMany(Trabajador::class);
    }

}
