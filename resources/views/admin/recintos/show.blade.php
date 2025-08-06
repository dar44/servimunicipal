@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1 class="mb-4">Detalle del Recinto</h1>

      <div class="card mb-4 shadow">
        <div class="card-body">
          <h3 class="card-title">{{ $recinto->name }}</h3>

          <dl class="row">
            <dt class="col-sm-3">Descripción:</dt>
            <dd class="col-sm-9">{{ $recinto->description }}</dd>

            <dt class="col-sm-3">Ubicación:</dt>
            <dd class="col-sm-9">{{ $recinto->ubication }}</dd>

            <dt class="col-sm-3">Provincia:</dt>
            <dd class="col-sm-9">{{ $recinto->province }}</dd>

            <dt class="col-sm-3">Código Postal:</dt>
            <dd class="col-sm-9">{{ $recinto->postal_code }}</dd>

            <dt class="col-sm-3">Estado:</dt>
            <dd class="col-sm-9">
              @if($recinto->state)
                <span class="badge bg-success">Activo</span>
              @else
                <span class="badge bg-secondary">Inactivo</span>
              @endif
            </dd>
          </dl>
        </div>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('admin.recintos.index') }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Volver
        </a>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.recintos.edit', $recinto->id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
          </a>
          <form action="{{ route('admin.recintos.destroy', $recinto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este recinto?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
              <i class="bi bi-trash"></i> Eliminar
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
