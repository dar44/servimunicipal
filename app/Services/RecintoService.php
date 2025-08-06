<?php

namespace App\Services;

use App\Models\Recinto;

class RecintoService 
{
    /**
     * Obtiene los recintos disponibles (state = true) con posibilidad de filtrar y paginar.
     *
     * @param array $filters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getRecintosDisponibles(array $filters = [])
    {
        // Base de la query: solo recintos con state = true
        $query = Recinto::where('state', true);

        // Si viene un filtro de 'province', aplicamos un where 'like'
        if (!empty($filters['province'])) {
            $province = $filters['province'];
            $query->where('province', 'LIKE', '%' . $province . '%');
        }

        // Devolvemos paginado, por ejemplo 8 resultados por página
        return $query->orderBy('id', 'desc')->paginate(8);
    }
}
