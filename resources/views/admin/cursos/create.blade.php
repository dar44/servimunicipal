@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear nuevo Curso</h1>

    <form action="{{ route('admin.cursos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.cursos._form')
        
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                Crear Curso
            </button>
            <a href="{{ route('admin.cursos.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
