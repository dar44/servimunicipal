@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Recinto</h1>

    <form action="{{ route('admin.recintos.update', $recinto->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.recintos._form', ['recinto' => $recinto])
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.recintos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
