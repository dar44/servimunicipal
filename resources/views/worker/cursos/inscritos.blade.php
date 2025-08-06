@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4">Usuarios Inscritos en el Curso: {{ $curso->name }}</h1>

    @if ($usuariosInscritos->isEmpty())
        <div class="alert alert-info">No hay usuarios inscritos en este curso.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuariosInscritos as $usuario)
                        <tr>
                            <td>{{ $usuario->dni }}</td>
                            <td>{{ $usuario->name }} {{ $usuario->surname }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->phone }}</td>
                            <td>
                                <!-- Botón que activa el modal -->
                                <button type="button" class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal{{ $curso->id }}-{{ $usuario->id }}">
                                    <i class="bi bi-x-circle"></i> Cancelar Inscripción
                                </button>

                                <!-- Modal para confirmar la cancelación de inscripción -->
                                <div class="modal fade" id="deleteModal{{ $curso->id }}-{{ $usuario->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $curso->id }}-{{ $usuario->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $curso->id }}-{{ $usuario->id }}">Confirmar cancelación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas cancelar la inscripción del usuario "{{ $usuario->name }} {{ $usuario->surname }}" al curso "{{ $curso->name }}"?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('worker.cursos.cancelar_inscripcion', [$curso, $usuario]) }}" method="POST">
                                                    @csrf
                                                    @method('POST')
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

    <!-- Botón Volver -->
    <div class="mt-4">
        <a href="{{ route('worker.cursos.index') }}" class="btn btn-primary">Volver</a>
    </div>
</div>
@endsection
