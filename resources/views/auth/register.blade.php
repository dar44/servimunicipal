@vite(['resources/js/password.js'])

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center fw-bold fs-4">
                    {{ __('Crear cuenta') }}
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fs-5">{{ __('Nombre') }}</label>
                                <input id="name" type="text"
                                       class="form-control fs-5 @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" autofocus>
                                @error('name')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="surname" class="form-label fs-5">{{ __('Apellidos') }}</label>
                                <input id="surname" type="text"
                                       class="form-control fs-5 @error('surname') is-invalid @enderror"
                                       name="surname" value="{{ old('surname') }}">
                                @error('surname')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dni" class="form-label fs-5">{{ __('DNI') }}</label>
                                <input id="dni" type="text"
                                       class="form-control fs-5 @error('dni') is-invalid @enderror"
                                       name="dni" value="{{ old('dni') }}">
                                @error('dni')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fs-5">{{ __('Teléfono') }}</label>
                                <input id="phone" type="text"
                                       class="form-control fs-5 @error('phone') is-invalid @enderror"
                                       name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fs-5">{{ __('Correo electrónico') }}</label>
                                <input id="email" type="email"
                                       class="form-control fs-5 @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fs-5">{{ __('Contraseña') }}</label>
                                <div class="input-group">
                                    <input id="password" type="password"
                                           class="form-control fs-5 @error('password') is-invalid @enderror"
                                           name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="image" class="form-label fs-5">{{ __('Imagen de perfil (opcional)') }}</label>
                                <input id="image" type="file"
                                       class="form-control fs-5 @error('image') is-invalid @enderror"
                                       name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fs-5">
                                {{ __('Registrarse') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
