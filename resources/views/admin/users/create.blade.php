@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear nuevo Usuario</h1>

    <form action="{{ route('admin.usuarios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.users._form')
        
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                Crear Usuario
            </button>
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection