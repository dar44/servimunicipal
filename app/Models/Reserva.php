<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional, Laravel lo deduce automáticamente)
    protected $table = 'reservas';

    protected $fillable = [
        'user_id',
        'recinto_id',
        'price',
        'start_at',
        'end_at',
        'status',
        'paid',
        'observations'
    ];
    protected $casts = ['start_at' => 'datetime', 'end_at' => 'datetime', 'paid' => 'boolean'];
    public function recinto()
    {
        return $this->belongsTo(Recinto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
