@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4 text-center">Mis Reservas</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($reservas->isEmpty())
        <div class="alert alert-info">No tienes reservas en este momento.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Recinto</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de fin</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservas as $reserva)
                        <tr>
                            <td>{{ $reserva->recinto->name }}</td>
                            <td>{{ $reserva->start_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $reserva->end_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $reserva->price }}€</td>
                            <td>
                                <!-- Botón que activa el modal -->
                                <button type="button" class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal{{ $reserva->id }}">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>

                                <!-- Modal para confirmar la eliminación -->
                                <div class="modal fade" id="deleteModal{{ $reserva->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $reserva->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $reserva->id }}">Confirmar eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas eliminar esta reserva para el recinto "{{ $reserva->recinto->name }}"?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('reservas.destroy', $reserva) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        // Modal script handling
        document.addEventListener('DOMContentLoaded', () => {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function () {
                    const form = modal.querySelector('form');
                    form.reset();
                });
            });
        });
    </script>
@endpush

@endsection
