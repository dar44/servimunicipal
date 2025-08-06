@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> 
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Gestión de Cursos</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.cursos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Nuevo Curso
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Imagen</th>
                            <th style="width: 20%;">Nombre</th>
                            <th style="width: 25%;">Descripción</th>
                            <th>Fecha Inicio</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cursos as $curso)
                            <tr>
                                <td>
                                    @if($curso->image)
                                        <img src="{{ asset('storage/' . $curso->image) }}" 
                                             alt="Imagen del curso" 
                                             class="rounded" 
                                             style="width: 100px; height: auto;">
                                    @else
                                        <div class="text-muted" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-image" style="font-size: 1.5rem;"></i>
                                        </div>
                                    @endif
                                </td>                                
                                <td>{{ $curso->name }}</td>
                                <td class="text-truncate" style="max-width: 250px;" title="{{ $curso->description }}">
                                    {{ $curso->description }}
                                </td>
                                <td>{{ date('d/m/Y', strtotime($curso->begining_date)) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($curso->state === 'Disponible') bg-success
                                        @elseif($curso->state === 'Cancelado') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        {{ $curso->state }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.cursos.show', $curso) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.cursos.edit', $curso) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal{{ $curso->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="modal fade" id="deleteModal{{ $curso->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de eliminar el curso "{{ $curso->name }}"?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('admin.cursos.destroy', $curso) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay cursos registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $cursos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
