@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1 class="mb-4">{{ $curso->name }}</h1>

      <div class="card mb-4 shadow">
        <img src="{{ $curso->image ? asset('storage/' . $curso->image) : asset('storage/images/default-curso.png') }}"
             class="card-img-top"
             alt="Imagen del curso"
             style="max-height: 400px; object-fit: cover;">
      </div>

      <div class="card shadow">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <h4 class="mb-3">Información del curso</h4>

              <dl class="row">
                <dt class="col-sm-3">Descripción:</dt>
                <dd class="col-sm-9">{{ $curso->description }}</dd>

                <dt class="col-sm-3">Fecha de inicio:</dt>
                <dd class="col-sm-9">{{ date('d/m/Y', strtotime($curso->begining_date)) }}</dd>

                <dt class="col-sm-3">Fecha de fin:</dt>
                <dd class="col-sm-9">{{ date('d/m/Y', strtotime($curso->end_date)) }}</dd>

                <dt class="col-sm-3">Ubicación:</dt>
                <dd class="col-sm-9">{{ $curso->location ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Precio:</dt>
                <dd class="col-sm-9">{{ $curso->price ? number_format($curso->price, 2) . ' €' : 'Gratuito' }}</dd>

                <dt class="col-sm-3">Estado:</dt>
                <dd class="col-sm-9">
                  <span class="badge 
                    @if ($curso->state === 'Disponible') bg-success
                    @elseif($curso->state === 'Cancelado') bg-danger
                    @else bg-secondary
                    @endif">
                    {{ $curso->state }}
                  </span>
                </dd>

                <dt class="col-sm-3">Capacidad:</dt>
                <dd class="col-sm-9">{{ $curso->capacity ?? 'Ilimitado' }}</dd>

                <dt class="col-sm-3">Creado el:</dt>
                <dd class="col-sm-9">{{ date('d/m/Y H:i', strtotime($curso->created_at)) }}</dd>

                <dt class="col-sm-3">Actualizado el:</dt>
                <dd class="col-sm-9">{{ date('d/m/Y H:i', strtotime($curso->updated_at)) }}</dd>
              </dl>

              <hr>
              <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.cursos.index') }}" class="btn btn-secondary">
                  <i class="bi bi-arrow-left"></i> Volver
                </a>
                <div class="d-flex gap-2">
                  <a href="{{ route('admin.cursos.edit', $curso) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                  </a>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash"></i> Eliminar
                  </button>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de eliminar permanentemente el curso "{{ $curso->name }}"?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form action="{{ route('admin.cursos.destroy', $curso) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Confirmar eliminación</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
