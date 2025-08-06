@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4 text-center">Listado de Reservas</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($reservas->isEmpty())
        <div class="alert alert-info">No hay reservas registradas.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID Reserva</th>
                        <th>Usuario</th>
                        <th>Recinto</th>
                        <th>Fecha y Hora</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservas as $reserva)
                        <tr>
                            <td>{{ $reserva->id }}</td>
                            <td>{{ $reserva->user->name }} {{ $reserva->user->surname }}</td>
                            <td>{{ $reserva->recinto->name }}</td>
                            <td>{{ $reserva->start_at->format('d/m/Y H:i') }} - {{ $reserva->end_at->format('H:i') }}</td>
                            <td>
                                <!-- Botón para activar el modal de confirmación -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $reserva->id }}">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>

                        <!-- Modal de confirmación para eliminar reserva -->
                        <div class="modal fade" id="deleteModal{{ $reserva->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $reserva->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $reserva->id }}">Confirmar eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar la reserva para el recinto "{{ $reserva->recinto->name }}"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('worker.reservas.destroy', $reserva) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Confirmar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
