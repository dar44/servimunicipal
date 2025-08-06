@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Gestión de Cursos</h1>
            <p class="text-muted mb-0">Listado de cursos disponibles para inscripción</p>
        </div>
        <div class="d-flex gap-2">
            <form method="GET" class="d-flex gap-2">
                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" 
                           class="form-control" 
                           placeholder="Buscar curso..." 
                           name="search"
                           value="{{ request('search') }}">
                </div>
                
                <select class="form-select" name="state" style="width: 180px;">
                    <option value="">Todos los estados</option>
                    <option value="Disponible" {{ request('state') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="Cancelado" {{ request('state') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
                
                <select class="form-select" name="date_filter" style="width: 180px;">
                    <option value="">Todas las fechas</option>
                    <option value="proximos" {{ request('date_filter') == 'proximos' ? 'selected' : '' }}>Próximos cursos</option>
                    <option value="pasados" {{ request('date_filter') == 'pasados' ? 'selected' : '' }}>Cursos pasados</option>
                    <option value="este_mes" {{ request('date_filter') == 'este_mes' ? 'selected' : '' }}>Este mes</option>
                </select>
                
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>
                
                @if(request()->hasAny(['search', 'state', 'date_filter']))
                    <a href="{{ route('worker.cursos.index') }}" class="btn btn-outline-danger">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </a>
                @endif
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow border-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 100px; min-width: 100px;">Imagen</th>
                        <th>Nombre del Curso</th>
                        <th class="d-none d-lg-table-cell">Descripción</th>
                        <th style="min-width: 120px;">
                            <i class="bi bi-calendar-event me-1"></i>Fecha
                        </th>
                        <th>Plazas</th>
                        <th>Estado</th>
                        <th class="text-end" style="min-width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cursos as $curso)
                        <tr class="align-middle">
                            <td>
                                <div class="ratio ratio-1x1 bg-light rounded">
                                    @if($curso->image)
                                        <img src="{{ asset('storage/'.$curso->image) }}" 
                                             class="img-fluid object-fit-cover rounded"
                                             alt="{{ $curso->name }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center text-muted">
                                            <i class="bi bi-image" style="font-size: 1.5rem;"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $curso->name }}</div>
                                <small class="text-muted d-block d-lg-none">{{ Str::limit($curso->description, 40) }}</small>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <span class="d-inline-block text-truncate" 
                                      style="max-width: 300px;"
                                      data-bs-toggle="tooltip" 
                                      title="{{ $curso->description }}">
                                    {{ $curso->description }}
                                </span>
                            </td>
                            <td>
                                <div class="text-nowrap">
                                    {{ $curso->begining_date->translatedFormat('d M Y') }}
                                </div>
                                <small class="text-muted">
                                    {{ $curso->begining_date->diffForHumans() }}
                                </small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 6px;">
                                        <div class="progress-bar bg-primary" 
                                             role="progressbar" 
                                             style="width: {{ ($curso->inscripciones_count / $curso->capacity) * 100 }}%">
                                        </div>
                                    </div>
                                    <small class="text-nowrap">
                                        {{ $curso->inscripciones_count }}/{{ $curso->capacity }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <span class="badge rounded-pill d-flex align-items-center 
                                    @if($curso->state === 'Disponible') bg-success
                                    @elseif($curso->state === 'Cancelado') bg-danger
                                    @else bg-secondary @endif">
                                    @if($curso->state === 'Disponible')
                                        <i class="bi bi-check-circle me-1"></i>
                                    @elseif($curso->state === 'Cancelado')
                                        <i class="bi bi-x-circle me-1"></i>
                                    @endif
                                    {{ $curso->state }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    @if($curso->state === 'Disponible')
                                        <a href="{{ route('worker.cursos.inscribir.form', $curso) }}" 
                                           class="btn btn-sm btn-primary px-3"
                                           data-bs-toggle="tooltip"
                                           title="Inscribir participante">
                                            <i class="bi bi-person-add"></i>
                                        </a>
                                        <!-- Botón que activa el modal -->
                                        <button type="button"
                                                class="btn btn-sm btn-outline-secondary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#cancelarCursoModal{{ $curso->id }}"
                                                title="Bloquear inscripciones">
                                            <i class="bi bi-lock"></i>
                                        </button>

                                        <!-- Modal de confirmación -->
                                        <div class="modal fade" id="cancelarCursoModal{{ $curso->id }}" tabindex="-1" aria-labelledby="cancelarCursoLabel{{ $curso->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('worker.cursos.cambiar_estado', $curso) }}">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="cancelarCursoLabel{{ $curso->id }}">Confirmar cancelación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de que deseas cancelar el curso <strong>{{ $curso->name }}</strong>? Esta acción no se puede deshacer.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-danger">Sí, cancelar curso</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('worker.cursos.inscritos', $curso) }}" class="btn btn-sm btn-info" 
                                        data-bs-toggle="tooltip" title="Ver usuarios inscritos">
                                            <i class="bi bi-person-check"></i> <!-- Icono de usuarios -->
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-outline-danger" disabled>
                                            <i class="bi bi-slash-circle"></i> Cerrado
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="py-5 text-center text-muted">
                                    <i class="bi bi-book me-2" style="font-size: 2rem;"></i>
                                    <h5 class="mt-2">No se encontraron cursos</h5>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($cursos->hasPages())
            <div class="card-footer border-top bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Mostrando {{ $cursos->firstItem() }} - {{ $cursos->lastItem() }} de {{ $cursos->total() }}
                    </small>
                    {{ $cursos->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
})
</script>
@endpush

@endsection