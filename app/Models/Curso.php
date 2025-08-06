<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    // Nombre de la tabla en la BD (si no se sigue la convención "cursos")
    protected $table = 'cursos';

    /**
     * Campos que se pueden asignar de manera masiva (mass assignment).
     */
    protected $fillable = [
        'name',
        'description',
        'location',
        'begining_date',
        'end_date',
        'price',
        'state',
        'capacity',
        'image',
    ];

    /**
     * Si quieres que Laravel trate estos campos como instancias de Carbon (fechas),
     * lo puedes indicar aquí:
     */
    protected $casts = [
        'begining_date' => 'datetime',
        'end_date' => 'datetime',
    ];


    /**
     * Rules for creating new course
     * 
     * @return array{begining_date: string, capacity: string, description: string, end_date: string, image: string, location: string, name: string, price: string, state: string}
     */
    public static function validationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'begining_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:begining_date',
            'price' => 'required|numeric|min:0',
            'state' => 'required|string|in:Disponible,No disponible,Cancelado',
            'capacity' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Rules for updating course
     * 
     * @return array{begining_date: string, capacity: string, description: string, end_date: string, image: string, location: string, name: string, price: string, state: string}
     */
    public static function updateValidationRules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'location' => 'sometimes|string|max:255',
            'begining_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:begining_date',
            'price' => 'sometimes|numeric|min:0',
            'state' => 'sometimes|string|in:Disponible,No Disponible,Cancelado',
            'capacity' => 'sometimes|integer|min:1',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function inscripcionesCount()
    {
        return $this->hasMany(Inscripcion::class)->selectRaw('curso_id, COUNT(*) as aggregate')->groupBy('curso_id');
    }

    public function getInscripcionesCountAttribute()
    {
        if (!array_key_exists('inscripcionesCount', $this->relations)) {
            $this->load('inscripcionesCount');
        }

        $related = $this->getRelation('inscripcionesCount')->first();

        return $related ? (int) $related->aggregate : 0;
    }
}
