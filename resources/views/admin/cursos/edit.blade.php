@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Curso</h1>

    <form action="{{ route('admin.cursos.update', $curso->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.cursos._form')
        
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                Actualizar Curso
            </button>
            <a href="{{ route('admin.cursos.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
