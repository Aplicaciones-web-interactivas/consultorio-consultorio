@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6">
            <h1 class="mb-2">Registro de consulta</h1>
            <hr class="mb-4">
            <p class="fs-5 mb-4">Crear una nueva receta médica para tus pacientes.</p>

            <form action="{{ route('guardar.receta') }}" method="POST" class="p-4 border rounded">
                @csrf

                <div class="row g-3 mb-3 align-items-end">
                    <div class="col">
                        <label for="paciente" class="form-label">Paciente</label>
                        <select class="form-select" id="paciente" name="paciente" required>
                            <option value="">Selecciona un paciente</option>
                            @foreach ($pacientes as $paciente)
                            <option value="{{ $paciente->id }}">{{ $paciente->nombre }} {{ $paciente->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#nuevoPacienteModal">
                            <i class="bi bi-plus"></i> Nuevo paciente
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha"
                           min="{{ date('Y-m-d') }}"
                           value="{{ date('Y-m-d') }}"
                           max="2999-12-31" required>
                </div>

                <div class="mb-3">
                    <label for="medicamentos" class="form-label">Medicamentos</label>
                    <textarea class="form-control" id="medicamentos" name="medicamentos" rows="4" placeholder="Agregue aquí los medicamentos recetados..." required></textarea>
                </div>

                <div class="d-grid gap-3 mt-4">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="descargar" name="descargar" checked>
                        <label class="form-check-label" for="descargar">
                            Descargar receta
                        </label>
                    </div>
                </div>
            </form>

            @if (session('msg'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>{{ session('msg') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Nuevo Paciente -->
<div class="modal fade" id="nuevoPacienteModal" tabindex="-1" aria-labelledby="nuevoPacienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('guardar.paciente') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoPacienteModalLabel">Nuevo paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-4">Crea una nueva cuenta para un paciente.</p>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del paciente" required>
                    </div>

                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido(s)</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido(s) del paciente" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="correo@ejemplo.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar nuevo paciente</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
