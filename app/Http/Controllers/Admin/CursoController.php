<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Services\CursoService;
use Exception;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    protected $cursoService;

    public function __construct(CursoService $cursoService)
    {
        $this->cursoService = $cursoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Curso::latest()->paginate(10); 
        return view('admin.cursos.index', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cursos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(Curso::validationRules());

        try {
            $this->cursoService->createCurso($validated);
            return redirect()->route('admin.cursos.index')
                ->with('success', 'Curso creado exitosamente');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        return view('admin.cursos.show', compact('curso'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        return view('admin.cursos.edit', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        $validated = $request->validate(Curso::updateValidationRules());

        try {
            $this->cursoService->updateCurso($curso, $validated);
            return redirect()->route('admin.cursos.index')
                ->with('success', 'Curso actualizado exitosamente');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        try {
            $this->cursoService->deleteCurso($curso);
            return redirect()->route('admin.cursos.index')
                ->with('success', 'Curso eliminado exitosamente');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}
