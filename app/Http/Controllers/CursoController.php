<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Inscripcion;
use App\Services\CursoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

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
    public function index(Request $request)
    {
        $filters = [
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),
        ];

        $cursos = $this->cursoService->getCursos($filters);

        return view('cursos.index', compact('cursos'));
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
    public function show(Curso $curso)
    {
        $curso->loadCount('inscripciones');
        $available = max($curso->capacity - $curso->inscripciones_count, 0);

        $already = Auth::check()
            ? $curso->inscripciones()->where('user_id', Auth::id())->exists()
            : false;

        return view('cursos.show', compact('curso', 'available', 'already'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        //
    }

    public function pagar(Request $request, Curso $curso)
    {
        $curso->loadCount('inscripciones');
        if ($curso->state !== 'Disponible' ||
            $curso->inscripciones_count >= $curso->capacity) {
            return back()->withErrors('Curso no disponible o sin plazas.');
        }

        if ($curso->price == 0) {
            return $this->crearInscripcion($curso, Auth::id(), false);
        }

        // Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = CheckoutSession::create([
            'payment_method_types' => ['card'],
            'mode'       => 'payment',
            'customer_email' => Auth::user()->email,
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'eur',
                    'unit_amount'  => (int) ($curso->price * 100), 
                    'product_data' => [
                        'name' => $curso->name,
                    ],
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'curso_id' => $curso->id,
                'user_id'  => Auth::id(),
            ],
            'success_url' => route('cursos.pago.exito', $curso)
                           . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('cursos.pago.cancel', $curso),
        ]);

        return redirect($session->url);
    }

    public function pagoExito(Request $request, Curso $curso)
    {
        $sessionId = $request->get('session_id');
        if (!$sessionId) {
            return redirect()->route('cursos.show', $curso)
                             ->withErrors('Pago no verificado.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $session = CheckoutSession::retrieve($sessionId);

        if ($session->payment_status !== 'paid') {
            return redirect()->route('cursos.show', $curso)
                             ->withErrors('Pago incompleto.');
        }

        $userId = $session->metadata->user_id;

        return $this->crearInscripcion($curso, $userId, true);
    }

    public function pagoCancel(Curso $curso)
    {
        return redirect()->route('cursos.show', $curso)
                         ->with('warning', 'Pago cancelado.');
    }

    private function crearInscripcion(Curso $curso, int $userId, bool $paid)
    {
        if ($curso->inscripciones()->where('user_id', $userId)->exists()) {
            return redirect()->route('cursos.show', $curso)
                             ->withErrors('Ya estás inscrito.');
        }

        Inscripcion::create([
            'curso_id' => $curso->id,
            'user_id'  => $userId,
            'status'   => 'activa',
            'paid'     => $paid,
        ]);

        return redirect()->route('cursos.show', $curso)
                         ->with('success', 'Inscripción realizada correctamente.');
    }

    public function cancelar(Request $request, Curso $curso)
    {
        $userId = Auth::id();

        $this->cursoService->cancelarInscripcion($curso, $userId);

        return redirect()->route('cursos.show', $curso)
                        ->with('success', 'Inscripción cancelada correctamente.');
    }

}
