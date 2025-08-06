@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Panel de Administración</h1>
    
    <div class="row justify-content-center">

        {{-- Recintos --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Recintos</h5>
                    <p class="card-text text-muted">Administra los recintos disponibles para eventos y actividades.</p>
                    <a href="{{ route('admin.recintos.index') }}" class="btn btn-primary px-4">
                        Gestionar Recintos
                    </a>
                </div>
            </div>
        </div>

        {{-- Cursos --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Cursos</h5>
                    <p class="card-text text-muted">Administra los cursos disponibles y su programación.</p>
                    <a href="{{ route('admin.cursos.index') }}" class="btn btn-primary px-4">
                        Gestionar Cursos
                    </a>
                </div>
            </div>
        </div>

        {{-- Usuarios --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Usuarios</h5>
                    <p class="card-text text-muted">Administra los usuarios y sus permisos del sistema.</p>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary px-4">
                        Gestionar Usuarios
                    </a>
                </div>
            </div>
        </div>

        {{-- ← NUEVO Cartel Reservas --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Reservas</h5>
                    <p class="card-text text-muted">
                        Consulta todas las reservas realizadas y gestiona su estado.
                    </p>
                    <a href="{{ route('admin.reservas.index') }}" class="btn btn-primary px-4">
                        Ver Reservas
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
