<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recinto extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'ubication',
        'province',
        'postal_code',
        'state',
    ];

    protected $casts = [
        'state' => 'string',
    ];

    public function scopeDisponibles($query)
    {
        return $query->where('state', 'Disponible');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
