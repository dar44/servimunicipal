@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Añadir Recinto</h1>

    <form action="{{ route('admin.recintos.store') }}" method="POST">
        @csrf
        @include('admin.recintos._form', ['recinto' => null])
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('admin.recintos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
