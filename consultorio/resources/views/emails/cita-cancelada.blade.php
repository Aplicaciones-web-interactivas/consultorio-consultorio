<x-mail::message>
# Cita Médica Cancelada

Hola **{{ $paciente->nombre }} {{ $paciente->apellido }}**,

Su cita médica ha sido cancelada.

## Detalles de la cita cancelada:
- **Fecha:** {{ \Carbon\Carbon::parse($cita->Fecha)->format('d/m/Y') }}
- **Hora:** {{ \Carbon\Carbon::parse($cita->Hora)->format('h:i A') }}
- **Médico:** Dr. {{ $doctor->nombre ?? 'Médico asignado' }} {{ $doctor->apellido ?? '' }}

<x-mail::button :url="url('/citas')">
Agendar Nueva Cita
</x-mail::button>

Gracias,<br>
**{{ config('app.name') }}**
</x-mail::message>