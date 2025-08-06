<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\User;
use App\Services\CursoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class CursoController extends Controller
{
    private $cursoService;
    
    public function __construct(CursoService $cursoService) 
    {
        $this->cursoService = $cursoService;
    }
    
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'state' => $request->input('state'),
            'date_filter' => $request->input('date_filter')
        ];
    
        $cursos = $this->cursoService->getCursosForWorkers($filters);
        
        return view('worker.cursos.index', compact('cursos', 'filters'));
    }

    public function show(Curso $curso)
    {
        return view('worker.cursos.show', compact('curso'));
    }

    public function inscribirForm(Curso $curso)
    {
        return view('worker.cursos.inscribir', compact('curso'));
    }

    public function inscribir(Request $request, Curso $curso)
    {
        if ($curso->state !== 'Disponible') {
            return redirect()
                ->route('worker.cursos.index')
                ->withErrors('No se puede inscribir a un curso que no está disponible.');
        }
        
        $baseRules = [
            'has_account' => ['required', 'in:yes,no'],
        ];

        if ($request->has_account === 'yes') {
            $rules = $baseRules + [
                'email' => ['required', 'email', 'exists:users,email'],
            ];
        } else {
            $rules = $baseRules + [
                'email'    => ['required', 'email', 'unique:users,email'],
                'name'     => ['required', 'string', 'max:255'],
                'surname'  => ['required', 'string', 'max:255'],
                'dni'      => ['required', 'string', 'max:15', 'unique:users,dni'],
                'phone'    => ['required', 'string', 'max:20'],
            ];
        }

        $validated = $request->validate($rules);

        if ($request->has_account === 'yes') {
            $user = User::where('email', $validated['email'])->first();
        } else {
            $user = User::create([
                'email'    => $validated['email'],
                'name'     => $validated['name'],
                'surname'  => $validated['surname'],
                'dni'      => $validated['dni'],
                'phone'    => $validated['phone'],
                'role'     => 'user',
                'password' => bcrypt(Str::random(10)),
            ]);

            Password::sendResetLink(['email' => $user->email]);
        }

        if ($curso->inscripciones()->where('user_id', $user->id)->exists()) {
            return back()->withErrors('Ese usuario ya está inscrito en este curso.');
        }

        Inscripcion::create([
            'curso_id' => $curso->id,
            'user_id'  => $user->id,
            'status'   => 'activa',
            'paid'     => false,
        ]);

        return redirect()
            ->route('worker.cursos.index')
            ->with(
                'success',
                'Inscripción realizada correctamente. '
                    . ($request->has_account === 'no'
                        ? 'Se ha enviado un e-mail para que el usuario establezca su contraseña.'
                        : '')
            );
    }

    public function showInscritos(Curso $curso)
    {
        // Recuperamos todos los usuarios inscritos a este curso
        $usuariosInscritos = $curso->inscripciones()->with('user')->get()->map(function ($inscripcion) {
            return $inscripcion->user;
        });

        return view('worker.cursos.inscritos', compact('curso', 'usuariosInscritos'));
    }

    public function cancelarInscripcion(Curso $curso, User $usuario)
    {
        // Lógica para cancelar la inscripción
        $curso->inscripciones()->where('user_id', $usuario->id)->delete();

        return redirect()->route('worker.cursos.inscritos', $curso)->with('success', 'Inscripción cancelada exitosamente.');
    }

    public function cambiarEstado(Curso $curso)
    {
        if ($curso->state === 'Disponible') {
            $curso->state = 'Cancelado';
            $curso->save();

            return redirect()->route('worker.cursos.index')->with('success', 'El curso ha sido cancelado.');
        }

        return redirect()->route('worker.cursos.index')->withErrors('El curso no se puede cancelar.');
    }


}
