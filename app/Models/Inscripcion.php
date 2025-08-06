<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';

    use HasFactory;
    protected $fillable = ['user_id', 'curso_id', 'status', 'paid', 'cancelled_by'];
    protected $casts = ['paid' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
