<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    // Mostrar las reservas del usuario
    public function index()
    {
        // Obtener todas las reservas del usuario autenticado
        $reservas = auth()->user()->reservas;
        return view('reservas.index', compact('reservas'));
    }

    // Eliminar una reserva
    public function destroy(Reserva $reserva)
    {
        // Verificar si la reserva pertenece al usuario autenticado
        if ($reserva->user_id !== auth()->id()) {
            return redirect()->route('reservas.index')->with('warning', 'No puedes eliminar una reserva que no te pertenece.');
        }

        // Eliminar la reserva
        $reserva->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('reservas.index')->with('success', 'Reserva eliminada exitosamente.');
    }
}
