<?php

namespace App\Http\Controllers;

use App\Models\Recinto;
use App\Models\Reserva;
use App\Services\RecintoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

class RecintoController extends Controller
{
    protected $recintoService;

    public function __construct(RecintoService $recintoService)
    {
        $this->recintoService = $recintoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'province' => $request->input('province'),
        ];

        $recintos = $this->recintoService->getRecintosDisponibles($filters);

        return view('recintos.index', compact('recintos'));
    }

    public function show(Recinto $recinto)
    {
        $bookings = $recinto->reservas()
            ->where('status', 'activa')
            ->whereDate('end_at', '>=', now()->toDateString())
            ->get(['start_at'])
            ->groupBy(fn ($r) => $r->start_at->toDateString())
            ->map(fn ($day) => $day->pluck('start_at')->map->format('H:i'));

        return view('recintos.show', compact('recinto', 'bookings'));
    }

    public function pagar(Request $request, Recinto $recinto)
    {
        $data = $request->validate([
            'day'  => ['required','date','after_or_equal:today'],
            'hour' => ['required','date_format:H:i','in:07:00,08:00,09:00,10:00,11:00,12:00,13:00,14:00,15:00,16:00,17:00,18:00,19:00,20:00,21:00']
        ]);

        if ($recinto->state !== 'Disponible') {
            return back()->withErrors('El recinto no está disponible.');
        }

        $startAt = Carbon::createFromFormat('Y-m-d H:i', "{$data['day']} {$data['hour']}")->setSeconds(0);
        $endAt   = $startAt->copy()->addHour();

        $hay = $recinto->reservas()
            ->where('status','activa')
            ->where('start_at','<',$endAt)
            ->where('end_at','>',$startAt)
            ->exists();

        if ($hay) {
            return back()->withErrors('Ese tramo ya está reservado.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = CheckoutSession::create([
            'payment_method_types' => ['card'],
            'mode'   => 'payment',
            'customer_email' => Auth::user()->email,
            'line_items' => [[
                'price_data' => [
                    'currency'    => 'eur',
                    'unit_amount' => 100,          
                    'product_data'=> ['name' => "Reserva de {$recinto->name}"],
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'recinto_id' => $recinto->id,
                'user_id'    => Auth::id(),
                'start'      => $startAt->toDateTimeString(),
                'end'        => $endAt->toDateTimeString(),
            ],
            'success_url' => route('recintos.pago.exito', $recinto).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('recintos.pago.cancel', $recinto),
        ]);

        return redirect($session->url);
    }

    public function pagoExito(Request $request, Recinto $recinto)
    {
        $sid = $request->query('session_id');
        if (!$sid) {
            return redirect()->route('recintos.show',$recinto)
                             ->withErrors('Pago no verificado.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $session = CheckoutSession::retrieve($sid);

        if ($session->payment_status !== 'paid') {
            return redirect()->route('recintos.show',$recinto)
                             ->withErrors('Pago incompleto.');
        }

        $startAt = Carbon::parse($session->metadata->start);
        $endAt   = Carbon::parse($session->metadata->end);

        Reserva::firstOrCreate([
            'recinto_id' => $recinto->id,
            'user_id'    => $session->metadata->user_id,
            'start_at'   => $startAt,
        ], [
            'end_at'     => $endAt,
            'price'      => 1,
            'status'     => 'activa',
            'paid'       => true,
        ]);

        return redirect()->route('recintos.show',$recinto)
                         ->with('success','Reserva confirmada y pagada correctamente.');
    }

    public function pagoCancel(Recinto $recinto)
    {
        return redirect()->route('recintos.show',$recinto)
                         ->with('warning','Pago cancelado.');
    }
}
