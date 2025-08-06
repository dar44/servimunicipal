<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Recinto;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index(Request $request)
    {
        // Listado de usuarios y recintos para los filtros
        $usuarios = User::orderBy('name')->pluck('name', 'id');
        $recintos = Recinto::orderBy('name')->pluck('name', 'id');

        // Query base con relaciones eager
        $query = Reserva::with(['user','recinto']);

        // Filtros opcionales
        if ($id = $request->user_id) {
            $query->where('user_id', $id);
        }
        if ($id = $request->recinto_id) {
            $query->where('recinto_id', $id);
        }
        if ($desde = $request->date_from) {
            $query->whereDate('start_at','>=',$desde);
        }
        if ($hasta = $request->date_to) {
            $query->whereDate('start_at','<=',$hasta);
        }

        // Orden y paginación
        $reservas = $query->orderBy('start_at','desc')
                          ->paginate(15)
                          ->withQueryString();

        return view('admin.reservas.index', compact('reservas','usuarios','recintos'));
    }
}
