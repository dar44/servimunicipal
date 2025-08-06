@extends('layouts.app')

@section('title','Listado de reservas')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Reservas realizadas</h1>

    {{-- FILTROS --}}
    <form method="GET" class="row gy-2 gx-3 align-items-end mb-4">
        <div class="col-md-3">
            <label class="form-label">Usuario</label>
            <select name="user_id" class="form-select">
                <option value="">— Todos —</option>
                @foreach($usuarios as $id => $name)
                    <option value="{{ $id }}"
                        {{ request('user_id')==$id ? 'selected':'' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Recinto</label>
            <select name="recinto_id" class="form-select">
                <option value="">— Todos —</option>
                @foreach($recintos as $id => $name)
                    <option value="{{ $id }}"
                        {{ request('recinto_id')==$id ? 'selected':'' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Desde</label>
            <input type="date" name="date_from"
                   class="form-control"
                   value="{{ request('date_from') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">Hasta</label>
            <input type="date" name="date_to"
                   class="form-control"
                   value="{{ request('date_to') }}">
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    {{-- TABLA DE RESERVAS --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th>Recinto</th>
                    <th>Fecha y hora</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->id }}</td>
                    <td>{{ $reserva->user->name }}</td>
                    <td>{{ $reserva->recinto->name }}</td>
                    <td>{{ $reserva->start_at->format('d/m/Y H:i') }}</td>
                    <td>{{ ucfirst($reserva->status) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No hay reservas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINACIÓN --}}
    <div class="d-flex justify-content-center">
        {{ $reservas->links() }}
    </div>
</div>
@endsection
