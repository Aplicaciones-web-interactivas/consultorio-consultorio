@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="space-y-4">
        <div class="flex items-center justify-between gap-4">
            <div class="flex-1">
                <flux:heading size="lg">{{ $paciente->nombre }} {{ $paciente->apellido }}</flux:heading>
                <flux:subheading class="text-xs">{{ $paciente->email }}</flux:subheading>
            </div>
            <flux:button
                :href="route('historial.index')"
                wire:navigate
                variant="subtle"
                size="sm"
            >
                Volver
            </flux:button>
        </div>

        @if (session('success'))
            <flux:callout
                icon="check-circle"
                title="Éxito"
                description="{{ session('success') }}"
                color="green"
            />
        @endif

        <div class="space-y-4">
            <div>
                <flux:heading size="lg">Historial Médico</flux:heading>
            </div>

            @if($historials->count() > 0)
                <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 divide-y divide-zinc-200 dark:divide-zinc-700 overflow-hidden">
                    @foreach($historials as $historial)
                        <div class="px-4 py-3">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <p class="font-semibold text-xs text-zinc-900 dark:text-zinc-100">
                                        {{ $historial->Enfermedad ?? 'Sin especificar' }}
                                    </p>
                                    <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-0.5">
                                        {{ $historial->Medicacion ?? 'N/A' }}
                                    </p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                        {{ $historial->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                @if($historial->imagen)
                                    <flux:link :href="Storage::url($historial->imagen)" target="_blank" size="sm" icon="image">
                                        Ver
                                    </flux:link>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <flux:callout
                    icon="inbox"
                    title="Sin registros"
                    description="No hay registros médicos disponibles"
                    color="zinc"
                />
            @endif
        </div>

        <flux:separator />

        <div class="space-y-3">
            <div>
                <flux:heading size="lg">Citas</flux:heading>
            </div>

            @if($citas->count() > 0)
                <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 divide-y divide-zinc-200 dark:divide-zinc-700 overflow-hidden">
                    @foreach($citas as $cita)
                        <div class="px-4 py-3">
                            <div class="flex items-start justify-between gap-4 mb-2">
                                <div class="flex-1">
                                    <p class="font-semibold text-xs text-zinc-900 dark:text-zinc-100">
                                        {{ $cita->Fecha->format('d/m/Y') }} - {{ $cita->Hora }}
                                    </p>
                                    <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-0.5">
                                        Dr/a. {{ $cita->doctor->nombre }} {{ $cita->doctor->apellido }}
                                    </p>
                                </div>
                                @if($cita->Confirmacion)
                                    <flux:badge color="green" size="sm">Confirmada</flux:badge>
                                @else
                                    <flux:badge color="yellow" size="sm">Pendiente</flux:badge>
                                @endif
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="text-xs text-zinc-600 dark:text-zinc-400">
                                    {{ $cita->images && count($cita->images) > 0 ? count($cita->images) : 0 }} imagen(es)
                                </div>
                                <flux:button
                                    :href="route('historial.edit', $cita)"
                                    wire:navigate
                                    size="xs"
                                    variant="subtle"
                                >
                                    Editar
                                </flux:button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <flux:callout
                    icon="inbox"
                    title="Sin citas"
                    description="No hay citas registradas para este paciente"
                    color="zinc"
                />
            @endif
        </div>
    </div>
</div>

@fluxScripts
@endsection
