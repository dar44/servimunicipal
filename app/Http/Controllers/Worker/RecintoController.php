<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Recinto;
use App\Models\Reserva;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class RecintoController extends Controller
{
    public function index()
    {
        $recintos = Recinto::paginate(12);
        return view('worker.recintos.index', compact('recintos'));
    }

    public function show(Recinto $recinto)
    {
        $bookings = $recinto->reservas()
            ->where('status', 'activa')
            ->whereDate('end_at', '>=', now()->toDateString())
            ->get(['start_at', 'end_at'])
            ->groupBy(fn($r) => $r->start_at->toDateString())
            ->map(fn($day) => $day->map(fn($r) => $r->start_at->format('H:i')));

        return view('worker.recintos.show', compact('recinto', 'bookings'));
    }

    public function reservar(Request $request, Recinto $recinto)
    {
        if ($recinto->state !== 'Disponible') {
            return back()->withErrors('El recinto no está disponible.');
        }

        $baseRules = [
            'day'         => ['required', 'date', 'after_or_equal:today'],
            'hour'        => ['required', 'date_format:H:i', 'in:07:00,08:00,09:00,10:00,11:00,12:00,13:00,14:00,15:00,16:00,17:00,18:00,19:00,20:00,21:00'],
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

        $data = $request->validate($rules);

        $startAt = Carbon::createFromFormat('Y-m-d H:i', "{$data['day']} {$data['hour']}")
            ->setSeconds(0);
        $endAt   = $startAt->copy()->addHour();

        $hayColision = $recinto->reservas()
            ->where('status', 'activa')
            ->where(function ($q) use ($startAt, $endAt) {
                $q->where('start_at', '<', $endAt)
                    ->where('end_at',   '>', $startAt);
            })
            ->exists();

        if ($hayColision) {
            return back()->withErrors('Ese tramo horario ya está reservado.');
        }

        if ($data['has_account'] === 'yes') {
            $user = User::where('email', $data['email'])->first();
        } else {
            $user = User::create([
                'email'    => $data['email'],
                'name'     => $data['name'],
                'surname'  => $data['surname'],
                'dni'      => $data['dni'],
                'phone'    => $data['phone'],
                'role'     => 'user',
                'password' => bcrypt(Str::random(10)),
            ]);
            Password::sendResetLink(['email' => $user->email]);
        }

        Reserva::create([
            'recinto_id' => $recinto->id,
            'user_id'    => $user->id,
            'price'      => 1,
            'start_at'   => $startAt,
            'end_at'     => $endAt,
            'status'     => 'activa',
            'paid'       => false,
            'observations' => null,
        ]);

        return redirect()
            ->route('worker.recintos.show', $recinto)
            ->with(
                'success',
                'Reserva realizada correctamente. '
                    . ($data['has_account'] === 'no'
                        ? 'Se ha enviado un e-mail para que el usuario establezca su contraseña.'
                        : '')
            );
    }
    
    public function setAvailable(Recinto $recinto)
    {
        $recinto->update(['state' => 'Disponible']);
        return back()->with('success', 'Recinto marcado como Disponible.');
    }

    public function setUnavailable(Recinto $recinto)
    {
        $recinto->update(['state' => 'No disponible']);
        return back()->with('success', 'Recinto marcado como No disponible.');
    }
}
