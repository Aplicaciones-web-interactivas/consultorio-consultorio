@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Mis Citas Médicas</h2>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($cita)
        {{-- Mostrar cita existente --}}
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tu Próxima Cita</h5>
                <span class="badge {{ $cita->Confirmacion ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ $cita->Confirmacion ? 'Confirmada' : 'Pendiente' }}
                </span>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Doctor:</strong> Dr. {{ $cita->doctor->nombre }} {{ $cita->doctor->apellido }}
                </div>
                <div class="mb-3">
                    <strong>Fecha:</strong> {{ $cita->Fecha->format('d/m/Y') }}
                </div>
                <div class="mb-3">
                    <strong>Hora:</strong> {{ date('g:i A', strtotime($cita->Hora)) }}
                </div>

                <form action="{{ route('citas.destroy', $cita->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de cancelar esta cita?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Cancelar Cita</button>
                </form>
            </div>
        </div>

    @else
        {{-- Formulario para agendar nueva cita --}}
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Agendar Nueva Cita</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('citas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="IdDoctor" class="form-label">Seleccionar Doctor</label>
                        <select name="IdDoctor" id="IdDoctor" class="form-select @error('IdDoctor') is-invalid @enderror" required>
                            <option value="">-- Selecciona un doctor --</option>
                            @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('IdDoctor') == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->nombre }} {{ $doctor->apellido }}
                                </option>
                            @endforeach
                        </select>
                        @error('IdDoctor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Fecha" class="form-label">Fecha</label>
                        <input type="date" name="Fecha" id="Fecha" class="form-control @error('Fecha') is-invalid @enderror" 
                               min="{{ date('Y-m-d') }}" value="{{ old('Fecha') }}" required>
                        @error('Fecha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Hora" class="form-label">Hora</label>
                        <input type="time" name="Hora" id="Hora" class="form-control @error('Hora') is-invalid @enderror" 
                               value="{{ old('Hora') }}" required>
                        @error('Hora')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Agendar Cita</button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection