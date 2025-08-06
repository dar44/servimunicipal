@extends('layouts.app')

@section('content')
  <div class="container">
    <h1 class="text-center mb-4">Cursos Disponibles</h1>

    <div class="row justify-content-center mb-4 g-3">
      <div class="col-md-8">
        <form action="{{ route('cursos.index') }}" method="GET" class="row g-3">
          <div class="col-md-4">
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
              class="form-control">
          </div>
          <div class="col-md-4">
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control">
          </div>
          <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-grow-1">
              <i class="bi bi-funnel"></i> Filtrar
            </button>
            <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-counterclockwise"></i>
            </a>
          </div>
        </form>
      </div>
    </div>

    @if ($cursos->count())
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        @foreach ($cursos as $curso)
          <div class="col">
            <div class="card h-100 shadow-sm">
              <img src="{{ $curso->image ? asset('storage/' . $curso->image) : asset('storage/images/default-curso.png') }}"
                class="card-img-top img-fluid" alt="{{ $curso->name }}" style="height: 200px; object-fit: cover;">

              <div class="card-body d-flex flex-column">
                <div class="mb-2">
                  <span class="badge rounded-pill bg-{{ $curso->state == 'Disponible' ? 'success' : 'danger' }}">
                    {{ $curso->state }}
                  </span>
                </div>

                <h5 class="card-title">{{ $curso->name }}</h5>
                <p class="card-text flex-grow-1 text-muted"
                  style="display: -webkit-box;
                                      -webkit-line-clamp: 3;
                                      -webkit-box-orient: vertical;
                                      overflow: hidden;">
                  {{ $curso->description }}
                </p>

                <div class="d-flex justify-content-between align-items-center">
                  <h5 class="text-primary mb-0">
                    {{ $curso->price ? number_format($curso->price, 2) . '€' : 'Gratuito' }}
                  </h5>
                  <a href="{{ route('cursos.show', $curso) }}" class="btn btn-outline-primary">
                    Ver más
                  </a>
                </div>
              </div>

              <div class="card-footer bg-transparent">
                <small class="text-muted">
                  <i class="bi bi-calendar-event"></i>
                  {{ \Carbon\Carbon::parse($curso->begining_date)->format('d/m/Y') }} -
                  {{ \Carbon\Carbon::parse($curso->end_date)->format('d/m/Y') }}
                </small>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="d-flex justify-content-center mt-5">
        {{ $cursos->appends(request()->query())->links() }}
      </div>
    @else
      <div class="alert alert-info text-center">
        <i class="bi bi-info-circle-fill"></i> No se encontraron cursos con los filtros aplicados
      </div>
    @endif
  </div>
@endsection
