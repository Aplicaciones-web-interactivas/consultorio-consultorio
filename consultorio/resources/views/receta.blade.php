<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Receta</title>
</head>
<body>
    <h2> Dr. {{ $doctor->nombre }} {{$doctor->apellido}} </h2>
    <h3> {{ $paciente->nombre }} {{$paciente->apellido}} </h3>
    <hr>
    <p> Fecha: {{ $receta->Fecha }} </p>
    <p>
        {{ $receta->Medicamentos }}
    </p>
</body>
</html>
