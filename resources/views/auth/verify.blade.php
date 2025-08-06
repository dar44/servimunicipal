@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center fw-bold fs-4">
                    {{ __('Verificación de correo electrónico') }}
                </div>

                <div class="card-body p-4 text-center fs-5">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo.') }}
                        </div>
                    @endif

                    <p>{{ __('Antes de continuar, revisa tu correo para el enlace de verificación.') }}</p>
                    <p>{{ __('Si no has recibido el correo') }},</p>

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline fw-bold">
                            {{ __('haz clic aquí para solicitar otro') }}
                        </button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
