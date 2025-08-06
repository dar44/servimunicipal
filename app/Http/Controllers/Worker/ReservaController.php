<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    // Mostrar el listado de todas las reservas
    public function index()
    {
        // Obtener todas las reservas
        $reservas = Reserva::with('user', 'recinto')->get(); // Eager load para evitar consultas N+1
        return view('worker.reservas.index', compact('reservas'));
    }

    // Eliminar una reserva
    public function destroy(Reserva $reserva)
    {
        // Eliminar la reserva
        $reserva->delete();
        return redirect()->route('worker.reservas.index')->with('success', 'Reserva eliminada correctamente');
    }
}
