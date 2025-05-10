@component('mail::message')
# ¡Te has inscrito a un evento!

Hola {{ auth()->user()->name }},

Te has inscrito exitosamente al evento **{{ $evento->nombre }}**.

📅 **Fecha:** {{ $evento->fecha }}  
📝 **Descripción:** {{ $evento->descripcion }}

Gracias por participar.

@endcomponent
