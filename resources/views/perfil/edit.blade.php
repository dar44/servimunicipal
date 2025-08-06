@extends('layouts.app')

@section('title', 'Editar perfil')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-5 fw-semibold">Editar perfil</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 700px">
        @csrf   @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input  type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Apellidos</label>
                <input  type="text" name="surname" class="form-control @error('surname') is-invalid @enderror"
                        value="{{ old('surname', $user->surname) }}" required>
                @error('surname') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">DNI</label>
                <input  type="text" name="dni" class="form-control @error('dni') is-invalid @enderror"
                        value="{{ old('dni', $user->dni) }}" required>
                @error('dni') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input  type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $user->phone) }}" required>
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Imagen de perfil (opcional)</label>
                <input  type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mt-5 text-end">
            <a href="{{ route('profile.show') }}" class="btn btn-secondary me-2">Cancelar</a>
            <button class="btn btn-primary">Guardar cambios</button>
        </div>
    </form>
</div>
@endsection
