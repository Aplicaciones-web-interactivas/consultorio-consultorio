@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Gestión de Doctores y Pacientes</h2>

    <!-- Botón Crear -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#crearModal">Nuevo Usuario</button>

    <!-- Tabla -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->apellido }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ ucfirst($usuario->rol) }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarModal{{ $usuario->id }}">Editar</button>
                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Eliminar usuario?')">Eliminar</button>
                    </form>
                </td>
            </tr>

            <!-- Modal Editar -->
            <div class="modal fade" id="editarModal{{ $usuario->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title">Editar Usuario</h5>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="nombre" value="{{ $usuario->nombre }}" class="form-control mb-2" required>
                                <input type="text" name="apellido" value="{{ $usuario->apellido }}" class="form-control mb-2" required>
                                <input type="email" name="email" value="{{ $usuario->email }}" class="form-control mb-2" required>
                                <select name="rol" class="form-select mb-2" required>
                                    <option value="doctor" @selected($usuario->rol == 'doctor')>Doctor</option>
                                    <option value="paciente" @selected($usuario->rol == 'paciente')>Paciente</option>
                                </select>
                                <input type="password" name="password" placeholder="Nueva contraseña (opcional)" class="form-control mb-2">
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success">Guardar cambios</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Crear -->
<div class="modal fade" id="crearModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Nuevo Usuario</h5>
                </div>
                <div class="modal-body">
                    <input type="text" name="nombre" placeholder="Nombre" class="form-control mb-2" required>
                    <input type="text" name="apellido" placeholder="Apellido" class="form-control mb-2" required>
                    <input type="email" name="email" placeholder="Correo electrónico" class="form-control mb-2" required>
                    <select name="rol" class="form-select mb-2" required>
                        <option value="">Seleccione un rol</option>
                        <option value="doctor">Doctor</option>
                        <option value="paciente">Paciente</option>
                    </select>
                    <input type="password" name="password" placeholder="Contraseña" class="form-control mb-2" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
