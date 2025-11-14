@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Mis Citas Médicas</h2>
        <span class="badge bg-info fs-6">{{ $citas->count() }} cita(s)</span>
    </div>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filtro por fecha --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('doctor.citas') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="fecha" class="form-label">Filtrar por fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control"
                           value="{{ request('fecha') }}">
                </div>
                <div class="col-md-8 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                    <a href="{{ route('doctor.citas') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Listado de citas --}}
    @if($citas->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            No tienes citas programadas{{ request('fecha') ? ' para la fecha seleccionada' : '' }}.
        </div>
    @else
        <div class="row">
            @foreach($citas as $cita)
                <div class="col-md-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center
                                    {{ $cita->Confirmacion ? 'bg-success text-white' : 'bg-warning' }}">
                            <h5 class="mb-0">
                                <i class="bi bi-calendar-event"></i>
                                {{ $cita->Fecha->format('d/m/Y') }}
                            </h5>
                            <span class="badge {{ $cita->Confirmacion ? 'bg-light text-success' : 'bg-dark' }}">
                                {{ $cita->Confirmacion ? 'Confirmada' : 'Pendiente' }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong><i class="bi bi-person-fill"></i> Paciente:</strong>
                                <div class="ms-4">
                                    {{ $cita->paciente->nombre }} {{ $cita->paciente->apellido }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong><i class="bi bi-clock-fill"></i> Hora:</strong>
                                <div class="ms-4">
                                    {{ date('g:i A', strtotime($cita->Hora)) }}
                                </div>
                            </div>
                            @if($cita->paciente->email)
                            <div class="mb-3">
                                <strong><i class="bi bi-envelope-fill"></i> Contacto:</strong>
                                <div class="ms-4">
                                    <small>{{ $cita->paciente->email }}</small>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="card-footer bg-light">
                            <div class="d-flex gap-2">
                                @if(!$cita->Confirmacion)
                                    <form action="{{ route('doctor.citas.confirmar', $cita->id) }}"
                                          method="POST" class="flex-grow-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="bi bi-check-circle"></i> Confirmar
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-success w-50" disabled>
                                        <i class="bi bi-check-circle-fill"></i> Confirmada
                                    </button>
                                @endif

                                <form action="{{ route('doctor.citas.cancelar', $cita->id) }}"
                                      method="POST"
                                      class="flex-grow-1"
                                      onsubmit="return confirm('¿Estás seguro de cancelar esta cita?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-x-circle"></i> Cancelar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
