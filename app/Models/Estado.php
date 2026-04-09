<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estado extends Model
{
    protected $table = 'estado_ticket';
    protected $primaryKey = 'estado';
    protected $fillable = ['tipo_estado', 'descripcion', 'estatus'];
    public $timestamps = true;


    public function servicio(): HasMany
    {
        return $this->hasMany(Servicio::class, 'id_estado', 'id_estado');
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function ticket(): HasMany
    {
        return $this->hasMany(Ticket::class, 'id_estado', 'id_estado');
    }
}
