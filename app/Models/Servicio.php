<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $primaryKey = 'id_servicio';

    protected $fillable = [
        'id_servicio',
        'servicio',
        'id_seccion',
        'estatus',
        'created_at',
        'updated_at'
    ];
    
    public $incrementing = false; // porque es tipo string (saat_1, etc)

    public function ticket(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

     public function estadoRelacion(): HasMany
    {
        return $this->hasMany(Estado::class);
    }
}
