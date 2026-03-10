<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dpersonales extends Model
{
   protected $fillable = [
        'num_economico',
        'edificio',
        'nivel',
        'cubiculo',
        'extension',
        'created_at',
        'updated_at'
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'num_economico', 'num_economico');
    }
   
    public function tickets(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'num_economico', 'num_economico');
    }
    
}