<x-mail::message>
# Cita Médica Confirmada

Hola **{{ $paciente->nombre }} {{ $paciente->apellido }}**,

Su cita médica ha sido confirmada exitosamente.

## Detalles de su cita:
- **Fecha:** {{ \Carbon\Carbon::parse($cita->Fecha)->format('d/m/Y') }}
- **Hora:** {{ \Carbon\Carbon::parse($cita->Hora)->format('h:i A') }}
- **Estado:** Confirmada

<x-mail::button :url="url('/citas')">
Ver Mis Citas
</x-mail::button>

Gracias,<br>
**{{ config('app.name') }}**
</x-mail::message>