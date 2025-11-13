@extends('layouts.app')

@section('content')

<div class="container p-4">
    <div class="row gy-2">
        <div class="col-12 p-4 border rounded-lg shadow">
            <h4>Subir archivo:</h4>
            <form method="POST" action="{{ route('import_excel') }}" enctype="multipart/form-data">
                @csrf
                <label for="file"></label>
                <input type="file" name="file" id="file" class="form-control mb-4" required accept=".xlsx"/>
                <button type="submit" class="btn btn-primary">Subir archivo</button>
            </form>
        </div>

        <div class="col-12 p-4 border rounded-lg shadow">
            <h4>Subidos:</h4>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th class="text-start small fw-medium text-muted text-uppercase">Nombre</th>
                        <th class="text-start small fw-medium text-muted text-uppercase">Apellido</th>
                        <th class="text-start small fw-medium text-muted text-uppercase">Correo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subidos as $user)
                    <tr>
                        <td class="text-nowrap">{{ $user->nombre }}</td>
                        <td class="text-nowrap">{{ $user->apellido }}</td>
                        <td class="text-nowrap">{{ $user->email}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(auth()->user()->rol == 'admin')

        <div class="col-12 p-4 border rounded-lg shadow">
            <h4>Doctores:</h4>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th class="text-start small fw-medium text-muted text-uppercase">Nombre</th>
                        <th class="text-start small fw-medium text-muted text-uppercase">Apellido</th>
                        <th class="text-start small fw-medium text-muted text-uppercase">Correo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctores as $doctor)
                    <tr>
                        <td class="text-nowrap">{{ $doctor->nombre }}</td>
                        <td class="text-nowrap">{{ $doctor->apellido }}</td>
                        <td class="text-nowrap">{{ $doctor->email}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-12 p-4 border rounded-lg shadow">
            <h4>Pacientes:</h4>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th class="text-start small fw-medium text-muted text-uppercase">Nombre</th>
                        <th class="text-start small fw-medium text-muted text-uppercase">Apellido</th>
                        <th class="text-start small fw-medium text-muted text-uppercase">Correo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pacientes as $paciente)
                    <tr>
                        <td class="text-nowrap">{{ $paciente->nombre }}</td>
                        <td class="text-nowrap">{{ $paciente->apellido }}</td>
                        <td class="text-nowrap">{{ $paciente->email}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        @if(auth()->user()->rol == 'doctor')
        <div class="col-12 p-4 border rounded-lg shadow">
            <h4>Mis pacientes:</h4>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th class="text-start small fw-medium text-muted text-uppercase">Nombre</th>
                        <th class="text-start small fw-medium text-muted text-uppercase">Apellido</th>
                        <th class="text-start small fw-medium text-muted text-uppercase">Correo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pacientes as $paciente)
                    <tr>
                        <td class="text-nowrap">{{ $paciente->nombre }}</td>
                        <td class="text-nowrap">{{ $paciente->apellido }}</td>
                        <td class="text-nowrap">{{ $paciente->email}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    </div>
</div> 
@endsection