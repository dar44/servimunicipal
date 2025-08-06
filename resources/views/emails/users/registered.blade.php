@component('mail::message')
# Hola {{ $user->name }}

¡Gracias por registrarte en nuestra aplicación ServiMunicipal!

@component('mail::button', ['url' => config('app.url')])
Ir a la aplicación
@endcomponent

Si tienes cualquier pregunta, no dudes en contactar con nosotros.

Gracias,<br>
{{ config('app.name') }}
@endcomponent
