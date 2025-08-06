@extends('layouts.app')

@section('content')
  <div class="container">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="mb-4">
      <a href="{{ route('worker.recintos.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver al listado
      </a>
    </div>

    <div class="card shadow-lg overflow-hidden">
      <div class="row g-0">
        <div class="col-md-6 position-relative" style="height: 500px;">
          <img
            src="{{ $recinto->image ? asset('storage/' . $recinto->image) : asset('storage/images/default-recinto.png') }}"
            class="img-fluid h-100 w-100 object-fit-cover" alt="{{ $recinto->name }}" style="object-position: center">
          <div class="position-absolute bottom-0 start-0 p-3 bg-dark bg-opacity-75 text-white w-100">
            <h2 class="h4 mb-0">{{ $recinto->name }}</h2>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card-body h-100 d-flex flex-column p-4" style="overflow-y: auto">
            <div class="d-flex justify-content-between align-items-start mb-3">
              <div>
                <span
                  class="badge 
                                @switch($recinto->state)
                                    @case('Disponible') bg-success @break
                                    @case('Bloqueado') bg-danger @break
                                    @default bg-secondary
                                @endswitch fs-6">
                  {{ $recinto->state }}
                </span>
                <div class="text-muted mt-1">
                  <small>{{ $recinto->ubication }}, {{ $recinto->province }} ({{ $recinto->postal_code }})</small>
                </div>
              </div>
              <div class="text-end">
                <h3 class="h5 text-primary mb-0">1€/hora</h3>
                <small class="text-muted">Precio por hora</small>
              </div>
            </div>

            <hr class="my-4">

            <form method="POST" action="{{ route('worker.recintos.reservar', $recinto) }}" class="flex-grow-1">
              @csrf

              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label for="day" class="form-label fw-medium">Fecha</label>
                  <input type="date" id="day" name="day" min="{{ now()->toDateString() }}"
                    class="form-control @error('day') is-invalid @enderror" value="{{ old('day') }}" required>
                  @error('day')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label for="hour" class="form-label fw-medium">Hora</label>
                  <select id="hour" name="hour" class="form-select @error('hour') is-invalid @enderror" required>
                    <option value="" disabled selected>Seleccionar hora</option>
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
                  @error('hour')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-medium">Tipo de usuario</label>
                <div class="btn-group w-100 shadow-sm" role="group">
                  <input type="radio" class="btn-check" name="has_account" id="hasAccYes" value="yes"
                    {{ old('has_account', 'yes') === 'yes' ? 'checked' : '' }}>
                  <label class="btn btn-outline-primary" for="hasAccYes">
                    <i class="bi bi-person-check me-2"></i>Usuario existente
                  </label>

                  <input type="radio" class="btn-check" name="has_account" id="hasAccNo" value="no"
                    {{ old('has_account') === 'no' ? 'checked' : '' }}>
                  <label class="btn btn-outline-primary" for="hasAccNo">
                    <i class="bi bi-person-plus me-2"></i>Nuevo usuario
                  </label>
                </div>
              </div>

              <div class="mb-4">
                <div class="form-floating">
                  <input type="email" id="email" name="email"
                    class="form-control @error('email') is-invalid @enderror" placeholder="correo@ejemplo.com"
                    value="{{ old('email') }}" required>
                  <label for="email">Correo electrónico</label>
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div id="newUserFields" class="{{ old('has_account') === 'no' ? '' : 'd-none' }}">
                <div class="border-top pt-4">
                  <h6 class="mb-3 text-primary">Datos del nuevo usuario</h6>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" id="name" name="name"
                          class="form-control @error('name') is-invalid @enderror" placeholder="Nombre"
                          value="{{ old('name') }}">
                        <label for="name">Nombre</label>
                        @error('name')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" id="surname" name="surname"
                          class="form-control @error('surname') is-invalid @enderror" placeholder="Apellidos"
                          value="{{ old('surname') }}">
                        <label for="surname">Apellidos</label>
                        @error('surname')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" id="dni" name="dni"
                          class="form-control @error('dni') is-invalid @enderror" placeholder="DNI"
                          value="{{ old('dni') }}">
                        <label for="dni">DNI</label>
                        @error('dni')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" id="phone" name="phone"
                          class="form-control @error('phone') is-invalid @enderror" placeholder="Teléfono"
                          value="{{ old('phone') }}">
                        <label for="phone">Teléfono</label>
                        @error('phone')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>

                  <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle me-2"></i>
                    Se enviará un correo para establecer la contraseña
                  </div>
                </div>
              </div>

              <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-success w-100 py-3 fw-medium">
                  <i class="bi bi-calendar-check me-2"></i>Confirmar Reserva
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const toggleUserFields = () => {
          const newUserFields = document.getElementById('newUserFields');
          const isNewUser = document.querySelector('input[name="has_account"]:checked').value === 'no';

          newUserFields.classList.toggle('d-none', !isNewUser);

          const fields = ['name', 'surname', 'dni', 'phone'];
          fields.forEach(field => {
            const input = document.getElementById(field);
            if (input) {
              input.required = isNewUser;
              input.closest('.form-floating').classList.toggle('required-field', isNewUser);
            }
          });
        };

        document.querySelectorAll('input[name="has_account"]').forEach(radio => {
          radio.addEventListener('change', toggleUserFields);
        });
        toggleUserFields();

        const bookings = @json($bookings);
        const dayInput = document.getElementById('day');
        const hourSelect = document.getElementById('hour');

        const updateTimeSlots = () => {
          const selectedDate = dayInput.value;
          Array.from(hourSelect.options).forEach(option => option.disabled = false);

          if (bookings[selectedDate]) {
            bookings[selectedDate].forEach(bookedHour => {
              const option = hourSelect.querySelector(`option[value="${bookedHour}"]`);
              if (option) option.disabled = true;
            });
          }

          if (hourSelect.selectedOptions[0]?.disabled) hourSelect.value = '';
        };

        dayInput.addEventListener('change', updateTimeSlots);
        updateTimeSlots();
      });
    </script>

    <style>
      .required-field label::after {
        content: "*";
        color: #dc3545;
        margin-left: 3px;
      }

      .object-fit-cover {
        object-fit: cover;
      }
    </style>
  @endpush
@endsection
