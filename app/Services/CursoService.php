<?php

namespace App\Services;

use App\Models\Curso;
use App\Models\Inscripcion;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class CursoService
{

    /**
     * Function to get courses
     * 
     * @param array $filters
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getCursos(array $filters = [])
    {
        $query = Curso::withCount('inscripciones')
                  ->whereIn('state', ['Disponible', 'Cancelado']);

        $query->where('state', 'Disponible');

        if (!empty($filters['start_date'])) {
            $query->where('begining_date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->where('end_date', '<=', $filters['end_date']);
        }

        return $query->latest()->paginate(8);
    }

    public function getCursosForWorkers(array $filters = [])
    {
        $query = Curso::withCount('inscripciones');

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'LIKE', "%{$filters['search']}%")
                    ->orWhere('description', 'LIKE', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['state'])) {
            $query->where('state', $filters['state']);
        }

        if (!empty($filters['date_filter'])) {
            $now = now();
            switch ($filters['date_filter']) {
                case 'proximos':
                    $query->where('begining_date', '>', $now);
                    break;
                case 'pasados':
                    $query->where('begining_date', '<', $now);
                    break;
                case 'este_mes':
                    $start = $now->copy()->startOfMonth();
                    $end = $now->copy()->endOfMonth();
                    $query->whereBetween('begining_date', [
                        $start->toDateString(),
                        $end->toDateString()
                    ]);
                    break;
            }
        }

        return $query->latest()->paginate(12);
    }

    /**
     * Function to create new course using validated data
     * 
     * @param array $data
     * @throws \Exception
     * @return Curso
     */
    public function createCurso(array $data): Curso
    {
        DB::beginTransaction();
        try {
            if (isset($data['image'])) {
                $data['image'] = $this->uploadImage($data['image']);
            }

            $curso = Curso::create($data);

            DB::commit();
            return $curso;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error al crear el curso: ' . $e->getMessage());
        }
    }

    /**
     * Function to edit a course using validated data
     * 
     * @param \App\Models\Curso $curso
     * @param array $data
     * @throws \Exception
     * @return Curso|null
     */
    public function updateCurso(Curso $curso, array $data): Curso
    {
        DB::beginTransaction();
        try {
            if (isset($data['image'])) {
                $this->deleteImage($curso->image);
                $data['image'] = $this->uploadImage($data['image']);
            }

            $curso->update($data);

            DB::commit();
            return $curso->fresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error al actualizar el curso: ' . $e->getMessage());
        }
    }

    /**
     * Function to delete course
     * 
     * @param \App\Models\Curso $curso
     * @throws \Exception
     * @return void
     */
    public function deleteCurso(Curso $curso): void
    {
        DB::beginTransaction();
        try {
            $this->deleteImage($curso->image);
            $curso->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error al eliminar el curso: ' . $e->getMessage());
        }
    }

    /**
     * Function to upload image associated to course
     * 
     * @param mixed $image
     * @return array|string
     */
    private function uploadImage($image): string
    {
        return $image->store('images/cursos', 'public');
    }

    /**
     * Function to delete image associated to course
     * 
     * @param mixed $imagePath
     * @return void
     */
    private function deleteImage(?string $imagePath): void
    {
        if (!$imagePath || $imagePath === 'images/default-curso.png') {
            return;
        }

        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    public function cancelarInscripcion(Curso $curso, int $userId): void
    {
        $inscripcion = Inscripcion::where('curso_id', $curso->id)
                                ->where('user_id', $userId)
                                ->first();

        if ($inscripcion) {
            $inscripcion->delete();
        }
    }
}
