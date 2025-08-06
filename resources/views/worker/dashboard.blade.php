@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Panel del Trabajador Municipal</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Recintos Deportivos</h5>
                    <p class="card-text text-muted">Consulta los recintos y realiza reservas para los ciudadanos.</p>
                    <a href="{{ route('worker.recintos.index') }}" class="btn btn-outline-primary px-4">
                        Ver Recintos
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Cursos Disponibles</h5>
                    <p class="card-text text-muted">Consulta los cursos y realiza inscripciones para los ciudadanos.</p>
                    <a href="{{ route('worker.cursos.index') }}" class="btn btn-outline-primary px-4">
                        Ver Cursos
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Reservas</h5>
                    <p class="card-text text-muted">Consulta y elimina reservas realizadas por los ciudadanos.</p>
                    <a href="{{ route('worker.reservas.index') }}" class="btn btn-outline-primary px-4">
                        Ver Reservas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
