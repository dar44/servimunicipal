@extends('layouts.app')

@section('content')
  <div class="container">
    <h1 class="text-center mb-4">Recintos Disponibles</h1>

    {{-- Filtro (opcional): solo si planeas filtrar recintos por algún criterio.
         Si no tienes filtros en tu controlador, puedes eliminar este bloque. --}}
    <div class="row justify-content-center mb-4 g-3">
      <div class="col-md-8">
        <form action="{{ route('recintos.index') }}" method="GET" class="row g-3">
          {{-- Ejemplo de filtro de provincia, si quisieras --}}
          <div class="col-md-8">
            <input type="text" name="province" id="province" value="{{ request('province') }}"
              class="form-control" placeholder="Filtrar por provincia">
          </div>
          <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-grow-1">
              <i class="bi bi-funnel"></i> Filtrar
            </button>
            <a href="{{ route('recintos.index') }}" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-counterclockwise"></i>
            </a>
          </div>
        </form>
      </div>
    </div>

    {{-- Verificamos si hay recintos --}}
    @if ($recintos->count())
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        @foreach ($recintos as $recinto)
          <div class="col">
            <div class="card h-100 shadow-sm">
              {{-- Imagen: si tienes un campo "image" en la tabla recintos, úsalo aquí.
                   En caso contrario, usa un placeholder o default:
              --}}
              <img src="{{ asset('storage/images/default-curso.png') }}"
                class="card-img-top img-fluid"
                alt="{{ $recinto->name }}"
                style="height: 200px; object-fit: cover;">

              <div class="card-body d-flex flex-column">
                {{-- Estado del recinto (boolean: true=disponible, false=no disponible) --}}
                <div class="mb-2">
                  <span class="badge rounded-pill bg-{{ $recinto->state ? 'success' : 'danger' }}">
                    {{ $recinto->state ? 'Disponible' : 'No disponible' }}
                  </span>
                </div>

                <h5 class="card-title">{{ $recinto->name }}</h5>
                {{-- Descripción con un pequeño recorte de 3 líneas (igual que en la vista de cursos) --}}
                <p class="card-text flex-grow-1 text-muted"
                  style="display: -webkit-box;
                         -webkit-line-clamp: 3;
                         -webkit-box-orient: vertical;
                         overflow: hidden;">
                  {{ $recinto->description }}
                </p>

                {{-- Ubicación y provincia en la parte inferior del body, por ejemplo --}}
                <div class="mt-2 mb-2">
                  <small class="text-muted">
                    <i class="bi bi-geo-alt"></i>
                    {{ $recinto->ubication }}, {{ $recinto->province }} (CP: {{ $recinto->postal_code }})
                  </small>
                </div>

                {{-- Botón "Ver más" que lleve al show del recinto (si lo tienes implementado) --}}
                <div class="mt-auto">
                  <a href="{{ route('recintos.show', $recinto) }}" class="btn btn-outline-primary">
                    Ver más
                  </a>
                </div>
              </div>

              {{-- Footer opcional (si quisieras mostrar más info en el pie de la card) --}}
              <div class="card-footer bg-transparent">
                <small class="text-muted">
                  {{-- Ejemplo: fecha de creación, si te interesa --}}
                  Creado el {{ $recinto->created_at->format('d/m/Y') }}
                </small>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Paginación (si usas ->paginate(...) en tu controlador/servicio) --}}
      <div class="d-flex justify-content-center mt-5">
        {{ $recintos->appends(request()->query())->links() }}
      </div>
    @else
      <div class="alert alert-info text-center">
        <i class="bi bi-info-circle-fill"></i> No se encontraron recintos con los filtros aplicados
      </div>
    @endif
  </div>
@endsection
