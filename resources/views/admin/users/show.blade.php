@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1 class="mb-4">{{ $user->name }}</h1>

      <div class="card mb-4 shadow">
        <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('storage/images/default-user.png') }}"
             class="card-img-top"
             alt="Imagen del user"
             style="max-height: 400px; object-fit: cover;">
      </div>

      <div class="card shadow">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <h4 class="mb-3">Información del Usuario</h4>

              <dl class="row">
                <dt class="col-sm-3">Nombre:</dt>
                <dd class="col-sm-9">{{ $user->name . ' ' . $user->surname }}</dd>

                <dt class="col-sm-3">Email:</dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>

                <dt class="col-sm-3">Teléfono:</dt>
                <dd class="col-sm-9">{{ $user->phone }}</dd>

                <dt class="col-sm-3">DNI:</dt>
                <dd class="col-sm-9">{{ $user->dni }}</dd>

                <dt class="col-sm-3">Rol:</dt>
                <dd class="col-sm-9">{{ $user->role }}</dd>
                
              </dl>

              <hr>
              <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                  <i class="bi bi-arrow-left"></i> Volver
                </a>
                <div class="d-flex gap-2">
                  <a href="{{ route('admin.usuarios.edit', $user) }}" class="btn btn-warning">
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
        ¿Estás seguro de eliminar permanentemente el user "{{ $user->name }}"?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form action="{{ route('admin.usuarios.destroy', $user) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Confirmar eliminación</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
