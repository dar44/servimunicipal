@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="mb-4">
      <a href="{{ route('recintos.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Volver al listado
      </a>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if (session('warning'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-octagon-fill me-2"></i>
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card shadow-lg border-0">
      <div class="row g-0">
        <!-- Sección de Imagen -->
        <div class="col-md-6 position-relative">
          <img
            src="{{ $recinto->image ? asset('storage/' . $recinto->image) : asset('storage/images/default-recinto.png') }}"
            class="img-fluid rounded-start h-100 w-100 object-fit-cover" alt="{{ $recinto->name }}"
            style="min-height: 400px; max-height: 500px;">
          <div class="position-absolute top-0 end-0 m-3">
            <span
              class="badge 
                        @switch($recinto->state)
                            @case('Disponible') bg-success @break
                            @case('Bloqueado') bg-danger @break
                            @default bg-secondary
                        @endswitch fs-6">
              {{ $recinto->state }}
            </span>
          </div>
        </div>

        <!-- Sección de Detalles -->
        <div class="col-md-6">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start mb-4">
              <h1 class="h2 mb-0">{{ $recinto->name }}</h1>
              <div class="text-end">
                <div class="h4 text-primary mb-0">1€/hora</div>
                <small class="text-muted">Precio por hora</small>
              </div>
            </div>

            <dl class="row mb-4">
              <dt class="col-sm-3">Ubicación</dt>
              <dd class="col-sm-9">
                {{ $recinto->ubication }}<br>
                <small class="text-muted">
                  {{ $recinto->province }} ({{ $recinto->postal_code }})
                </small>
              </dd>

              <dt class="col-sm-3">Descripción</dt>
              <dd class="col-sm-9">{{ $recinto->description }}</dd>
            </dl>

            @if ($recinto->state === 'Disponible')
              <div class="border-top pt-4">
                <h5 class="mb-4 text-primary">
                  <i class="bi bi-calendar-plus me-2"></i>Reservar horario
                </h5>

                <form method="POST" action="{{ route('recintos.pagar', $recinto) }}">
                  @csrf

                  <div class="row g-3 mb-4">
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="date" id="day" name="day"
                          class="form-control @error('day') is-invalid @enderror" min="{{ now()->toDateString() }}"
                          value="{{ old('day') }}" required>
                        <label for="day">Fecha de reserva</label>
                        @error('day')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <select id="hour" name="hour" class="form-select @error('hour') is-invalid @enderror"
                          required>
                          <option value="" disabled selected>Seleccione hora</option>
                          @for ($h = 7; $h <= 21; $h++)
                            @php
                              $val = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
                              $end = str_pad($h + 1, 2, '0', STR_PAD_LEFT) . ':00';
                            @endphp
                            <option value="{{ $val }}" {{ old('hour') == $val ? 'selected' : '' }}>
                              {{ $val }} - {{ $end }}
                            </option>
                          @endfor
                        </select>
                        <label for="hour">Horario</label>
                        @error('hour')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>

                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg py-3">
                      <i class="bi bi-credit-card me-2"></i>Confirmar Reserva - 1€
                    </button>
                  </div>
                </form>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const bookings = @json($bookings);
        const dayInput = document.getElementById('day');
        const hourSelect = document.getElementById('hour');

        const updateAvailability = () => {
          const selectedDate = dayInput.value;
          Array.from(hourSelect.options).forEach(option => {
            option.disabled = false;
            option.classList.remove('text-muted');
          });

          if (bookings[selectedDate]) {
            bookings[selectedDate].forEach(bookedHour => {
              const option = hourSelect.querySelector(`option[value="${bookedHour}"]`);
              if (option) {
                option.disabled = true;
                option.classList.add('text-muted');
              }
            });
          }

          if (hourSelect.selectedOptions[0]?.disabled) hourSelect.value = '';
        };

        dayInput.addEventListener('change', updateAvailability);
        updateAvailability();
      });
    </script>

    <style>
      .object-fit-cover {
        object-fit: cover;
      }

      option:disabled {
        background-color: #f8f9fa !important;
      }
    </style>
  @endpush
@endsection
