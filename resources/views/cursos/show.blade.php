@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="mb-4">
          <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver a los cursos
          </a>
        </div>

        <div class="card shadow-lg">
          <div class="row g-0">
            <div class="col-md-6">
              <img
                src="{{ $curso->image ? asset('storage/' . $curso->image) : asset('storage/images/default-curso.png') }}"
                class="img-fluid rounded-start" alt="{{ $curso->name }}"
                style="height: 500px; width: 100%; object-fit: cover;">
            </div>

            <div class="col-md-6">
              <div class="card-body h-100 d-flex flex-column">
                <div class="mb-4">
                  <div class="d-flex justify-content-between align-items-start">
                    <h1 class="card-title mb-0">{{ $curso->name }}</h1>
                    <span class="badge rounded-pill bg-{{ $curso->state == 'Disponible' ? 'success' : 'danger' }} fs-6">
                      {{ $curso->state }}
                    </span>
                  </div>
                  <hr>
                </div>

                <div class="flex-grow-1">
                  <div class="row g-3 mb-4">
                    <div class="col-6">
                      <p class="mb-0 text-muted">Fecha inicio:</p>
                      <h5>{{ \Carbon\Carbon::parse($curso->begining_date)->format('d/m/Y') }}</h5>
                    </div>
                    <div class="col-6">
                      <p class="mb-0 text-muted">Fecha fin:</p>
                      <h5>{{ \Carbon\Carbon::parse($curso->end_date)->format('d/m/Y') }}</h5>
                    </div>
                  </div>

                  <div class="mb-4">
                    <p class="mb-0 text-muted">Ubicación:</p>
                    <h5>{{ $curso->location }}</h5>
                  </div>

                  <div class="mb-4">
                    <p class="mb-0 text-muted">Descripción:</p>
                    <p class="lead">{{ $curso->description }}</p>
                  </div>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="bg-light p-3 rounded">
                        <p class="mb-0 text-muted">Plazas totales:</p>
                        <h3 class="mb-0">{{ $curso->capacity }}</h3>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="bg-light p-3 rounded">
                        <p class="mb-0 text-muted">Plazas disponibles:</p>
                        <h3 class="mb-0 {{ $available ? 'text-success' : 'text-danger' }}">{{ $available }}</h3>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <p class="mb-0 text-muted">Precio:</p>
                      <h2 class="text-primary mb-0">
                        {{ $curso->price ? number_format($curso->price, 2) . '€' : 'Gratuito' }}
                      </h2>
                    </div>
                    @if ($curso->state === 'Disponible')
                      @if ($already)
                        <button class="btn btn-secondary btn-lg px-5" disabled>Ya inscrito</button>

                        <div class="modal fade" id="deleteModal{{ $curso->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $curso->id }}" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $curso->id }}">Confirmar cancelación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                ¿Estás seguro de que deseas cancelar tu inscripción al curso "{{ $curso->name }}"?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <form action="{{ route('cursos.cancelar', $curso) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger">Confirmar</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Botón que activa el modal -->
                        <button type="button" class="btn btn-danger btn-lg px-5" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $curso->id }}">
                          Cancelar
                        </button>
                      @elseif ($available === 0)
                        <button class="btn btn-secondary btn-lg px-5" disabled>Sin plazas</button>
                      @else
                        <form action="{{ route('cursos.pagar', $curso) }}" method="POST">
                          @csrf
                          <button type="submit" class="btn btn-primary btn-lg px-5">
                            @if ($curso->price > 0)
                              Pagar e inscribirse
                            @else
                              Inscribirse
                            @endif
                          </button>
                        </form>
                      @endif
                    @else
                      <div class="alert alert-danger mb-0">Curso cancelado</div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
