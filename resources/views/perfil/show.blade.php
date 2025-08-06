@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
<div class="container py-4">

    {{-- título centrado --}}
    <h1 class="mb-5 fw-semibold text-center">Mi perfil</h1>

    <div class="row justify-content-center g-4 align-items-center">

        {{-- Foto --}}
        <div class="col-md-3 text-center">
            @if($user->image)
                <img src="{{ asset('storage/'.$user->image) }}"
                     alt="Foto de {{ $user->name }}"
                     class="img-fluid rounded-circle shadow"
                     style="max-width: 180px;">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=180"
                     alt="{{ $user->name }}"
                     class="img-fluid rounded-circle shadow">
            @endif
        </div>

        {{-- Datos --}}
        <div class="col-md-6">
            <ul class="list-unstyled fs-5 mb-0">
                <li><strong>Nombre:</strong> {{ $user->name }}</li>
            
                {{-- Apellidos (usa el nombre de columna que tengas: "surname", "last_name" o "apellidos") --}}
                <li><strong>Apellidos:</strong> {{ $user->surname ?? $user->last_name ?? $user->apellidos }}</li>
            
                <li><strong>DNI:</strong> {{ $user->dni }}</li>
                <li><strong>Teléfono:</strong> {{ $user->phone }}</li>
                <li><strong>Correo:</strong> {{ $user->email }}</li>
                <li><strong>Registrado el:</strong> {{ $user->created_at->format('d/m/Y') }}</li>
            </ul>
        </div>

    </div>

    {{-- ====================== Cursos inscritos ====================== --}}
    <h2 class="h4 mt-5 mb-3">Mis cursos</h2>

    @forelse ($cursos as $curso)
        <div class="border rounded p-3 mb-3">
            {{-- Nombre del curso --}}
            <strong>{{ $curso->name }}</strong><br>

            {{-- Fecha de inicio --}}
            <strong>Inicio:</strong>
            {{ optional($curso->begining_date)->format('d/m/Y') }}<br>

            {{-- Fecha de fin (opcional) --}}
            <strong>Fin:</strong>
            {{ optional($curso->end_date)->format('d/m/Y') }}
        </div>
    @empty
        <p class="text-muted">No tienes cursos inscritos.</p>
    @endforelse



    {{-- ====================== Reservas activas ====================== --}}
    <h2 class="h4 mt-5 mb-3">Reservas activas</h2>

    @forelse ($reservas as $reserva)
        <div class="border rounded p-3 mb-3">
            {{-- nombre real del recinto --}}
            <strong>{{ $reserva->recinto->name }}</strong><br>

            {{-- fecha real: start_at (no starts_at) --}}
            <strong>Fecha:</strong>
            {{ optional($reserva->start_at)->format('d/m/Y H:i') }}<br>

            {{-- estado real: status --}}
            <strong>Estado:</strong> {{ ucfirst($reserva->status) }}
        </div>
    @empty
        <p class="text-muted">No tienes reservas activas.</p>
    @endforelse


    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary mt-4">
        Editar datos
    </a>

</div>
@endsection
