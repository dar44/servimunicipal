@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Gestión de Recintos Deportivos</h1>
            <p class="text-muted mb-0">Instalaciones disponibles para actividades</p>
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
                        <th style="width: 100px;">Imagen</th>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recintos as $recinto)
                        <tr class="align-middle">
                            <td>
                                <div class="ratio ratio-1x1 bg-light rounded">
                                    @if($recinto->image)
                                        <img src="{{ asset('storage/'.$recinto->image) }}" 
                                             class="img-fluid object-fit-cover rounded"
                                             alt="{{ $recinto->name }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center text-muted">
                                            <i class="bi bi-building" style="font-size: 1.5rem;"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $recinto->name }}</div>
                                <small class="text-muted d-block d-lg-none">
                                    {{ Str::limit($recinto->description, 40) }}
                                </small>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $recinto->ubication }}</div>
                                <small class="text-muted">
                                    {{ $recinto->province }} ({{ $recinto->postal_code }})
                                </small>
                            </td>
                            <td>
                                <span class="badge rounded-pill d-flex align-items-center
                                    @switch($recinto->state)
                                        @case('Disponible') bg-success @break
                                        @case('No disponible') bg-secondary @break
                                        @case('Bloqueado') bg-danger @break
                                    @endswitch">
                                    @switch($recinto->state)
                                        @case('Disponible')
                                            <i class="bi bi-check-circle me-1"></i>
                                            @break
                                        @case('No disponible')
                                            <i class="bi bi-x-circle me-1"></i>
                                            @break
                                        @case('Bloqueado')
                                            <i class="bi bi-lock me-1"></i>
                                            @break
                                    @endswitch
                                    {{ $recinto->state }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    {{-- 1) Ver detalles (igual que antes) --}}
                                    <a href="{{ route('worker.recintos.show', $recinto) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       data-bs-toggle="tooltip"
                                       title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                            
                                    {{-- 2) Si está Disponible → botón “No disponible” --}}
                                    @if($recinto->state === 'Disponible')
                                        <form action="{{ route('worker.recintos.unavailable', $recinto) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip"
                                                    title="Marcar No disponible">
                                                <i class="bi bi-slash-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                            
                                    {{-- 3) Si está No disponible → botón “Disponible” --}}
                                    @if($recinto->state === 'No disponible')
                                        <form action="{{ route('worker.recintos.available', $recinto) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-success"
                                                    data-bs-toggle="tooltip"
                                                    title="Marcar Disponible">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="py-5 text-center text-muted">
                                    <i class="bi bi-building me-2" style="font-size: 2rem;"></i>
                                    <h5 class="mt-2">No se encontraron recintos</h5>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($recintos->hasPages())
            <div class="card-footer border-top bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Mostrando {{ $recintos->firstItem() }} - {{ $recintos->lastItem() }} de {{ $recintos->total() }}
                    </small>
                    {{ $recintos->links() }}
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