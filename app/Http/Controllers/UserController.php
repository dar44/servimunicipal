<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /** @var UserService */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function profile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // cursos inscritos
        $cursos = $user->cursos()                 // relación ya definida
                    ->orderBy('begining_date') // ← nombre real de la columna
                    ->get();

        // reservas futuras
        $reservas = $user->reservas()
                    ->where('start_at', '>=', now())   // ← nombre real
                    ->with('recinto')
                    ->orderBy('start_at')              // ← nombre real
                    ->get();

        return view('perfil.show', compact('user', 'cursos', 'reservas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /* ---------- editar ---------- */
    public function edit()
    {
        $user = Auth::user();                 // ignoramos $user del parámetro
        return view('perfil.edit', compact('user'));
    }

    /* ---------- actualizar ---------- */
    public function update(Request $request)
    {
        $user      = Auth::user();            // el usuario autenticado
        $validated = $request->validate(User::updateValidationRules($user));

        $this->userService->updateUsuario($user, $validated);

        return redirect()
               ->route('profile.show')
               ->with('success', 'Datos actualizados correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
