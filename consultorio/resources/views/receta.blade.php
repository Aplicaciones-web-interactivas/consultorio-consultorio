<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Elms+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <title>Receta Médica</title>
    <style>
        * {
            font-family: 'Elms Sans', sans-serif;
            margin: 0;
        }
        body {
            overflow: hidden;
            box-sizing: border-box;
            padding: 5mm;
        }

        header{
            display: flex;
            flex-direction: row;
            margin-bottom: 4mm;
        }

        .info {
            display: flex;
            flex-direction: column;
            gap: 1mm;
            margin-bottom: 4mm;

            span {
                display: flex;
                flex-direction: row;
            }
        }
        div {
            height: 50mm;
            margin-bottom: 2mm;
            border-bottom: 0.5mm dashed black;
        }
    </style>
</head>
<body>
    <header>
        <h1>Receta Médica</h1>
    </header>
    <section class="info">
        <span>
            <p> <strong> Doctor(a): </strong> {{ $doctor->nombre }} {{ $doctor->apellido }} </p>
        </span>
        <span>
            <p> <strong> Paciente: </strong>{{ $paciente->nombre }} {{ $paciente->apellido }} </p>
        </span>
        <span>
            <p> <strong> Fecha: </strong>{{ $receta->Fecha }} </p>
        </span>
    </section>
    <section class="medicamentos">
        <h3>Medicamentos recetados:</h3>
        <span>
            {{ $receta->Medicamentos }}
        </span>
    </section>
    <div></div>
    <header>
        <h1>Receta Médica</h1>
    </header>
    <section class="info">
        <span>
            <p> <strong> Doctor(a): </strong> {{ $doctor->nombre }} {{ $doctor->apellido }} </p>
        </span>
        <span>
            <p> <strong> Paciente: </strong>{{ $paciente->nombre }} {{ $paciente->apellido }} </p>
        </span>
        <span>
            <p> <strong> Fecha: </strong>{{ $receta->Fecha }} </p>
        </span>
    </section>
    <section class="medicamentos">
        <h3>Medicamentos recetados:</h3>
        <span>
            {{ $receta->Medicamentos }}
        </span>
    </section>
</body>
</html>
