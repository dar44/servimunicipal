@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Inscripción en Curso</h1>
                <a href="{{ route('worker.cursos.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Volver
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong class="d-block">Por favor corrige los siguientes errores:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error) 
                            <li>{{ $error }}</li> 
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Curso: {{ $curso->name }}</h5>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('worker.cursos.inscribir', $curso) }}">
                        @csrf

                        <div class="mb-5">
                            <label class="form-label fs-5 fw-medium mb-3">¿El participante tiene cuenta en el sistema?</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="has_account" id="hasAccountYes"
                                    value="yes" {{ old('has_account','yes')==='yes' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="hasAccountYes">
                                    <i class="bi bi-person-check me-2"></i>Sí, ya está registrado
                                </label>

                                <input type="radio" class="btn-check" name="has_account" id="hasAccountNo"
                                    value="no" {{ old('has_account')==='no' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="hasAccountNo">
                                    <i class="bi bi-person-plus me-2"></i>No, crear nueva cuenta
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-floating">
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" 
                                    placeholder="Correo electrónico"
                                    required>
                                <label for="email">Correo electrónico</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div id="newUserFields" class="d-none">
                            <div class="border-top pt-4 mt-4">
                                <h5 class="mb-4 text-primary">Datos del nuevo participante</h5>
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}"
                                                placeholder="Nombre">
                                            <label for="name">Nombre <span class="text-danger">*</span></label>
                                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="surname" id="surname"
                                                class="form-control @error('surname') is-invalid @enderror"
                                                value="{{ old('surname') }}"
                                                placeholder="Apellidos">
                                            <label for="surname">Apellidos <span class="text-danger">*</span></label>
                                            @error('surname')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="dni" id="dni"
                                                class="form-control @error('dni') is-invalid @enderror"
                                                value="{{ old('dni') }}"
                                                placeholder="DNI">
                                            <label for="dni">DNI <span class="text-danger">*</span></label>
                                            @error('dni')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="phone" id="phone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone') }}"
                                                placeholder="Teléfono">
                                            <label for="phone">Teléfono <span class="text-danger">*</span></label>
                                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info mt-4">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Se enviará un correo electrónico al participante para que establezca su contraseña.
                                </div>
                            </div>
                        </div>

                        <div class="border-top pt-4 mt-5 text-end">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="bi bi-check2-circle me-2"></i>Completar Inscripción
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
document.addEventListener('DOMContentLoaded', function() {
    const toggleFields = () => {
        const needsAccount = document.querySelector('input[name="has_account"]:checked').value === 'no';
        const newUserSection = document.getElementById('newUserFields');
        
        newUserSection.classList.toggle('d-none', !needsAccount);
        
        ['name','surname','dni','phone'].forEach(id => {
            const input = document.getElementById(id);
            input.toggleAttribute('required', needsAccount);
        });
    };

    toggleFields();
    document.querySelectorAll('input[name="has_account"]').forEach(radio => {
        radio.addEventListener('change', toggleFields);
    });
});
</script>
@endpush
@endsection