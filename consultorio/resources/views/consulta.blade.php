

<x-layouts.app.header>
    <div class="max-w-lg mx-auto mt-6">

        <flux:heading size="xl" class="mb-2"> Registro de consulta </flux:heading>
        <flux:separator class="mb-4"/>
        <flux:text size="lg"> Crear una nueva receta medica para tus pacientes. </flux:text>

        <form action="{{ route('guardar.receta') }}" method="POST" class=" p-4 mx-auto flex flex-col gap-4">
            @csrf
            <div class="w-full flex flex-row gap-4" style="align-items: end">
                <flux:select placeholder="Selecciona un paciente" required clearable label="Paciente" name="paciente">
                    @foreach ( $pacientes as $paciente )
                    <flux:select.option value="{{ $paciente->id }}"> {{ $paciente->nombre }} {{ $paciente->apellido }} </flux:select.option>
                    @endforeach
                </flux:select>
                <flux:modal.trigger name="nuevo-paciente">
                    <flux:button variant="ghost" class="cursor-pointer" icon="plus" >Nuevo paciente</flux:button>
                </flux:modal.trigger>
            </div>
            <flux:input type="date" name="fecha" max="2999-12-31" label="Fecha"/>
            <flux:textarea label="Medicamentos" name="medicamentos" placeholder="Agregue aqui los medicamentos recetados..."/>
            <div class="flex flex-col gap-4 mt-4">
                <flux:button variant="primary" type="submit" class="cursor-pointer">Guardar</flux:button>
                <flux:checkbox label="Descargar receta" name="descargar" checked/>
            </div>
        </form>
    </div>
    <flux:spacer/>
    @if (session('msg'))
        <flux:callout icon="check-circle" variant="success" inline x-data="{ visible: true }" x-show="visible"  class="max-w-lg mx-auto">
            <flux:callout.heading class="flex gap-2"> {{session('msg')}} </flux:callout.heading>
            <x-slot name="controls">
                <flux:button icon="x-mark" variant="ghost" x-on:click="visible = false" />
            </x-slot>
        </flux:callout>
    @endif
    <flux:modal name="nuevo-paciente">
        <div class="space-y-6">
            <form action="{{ route('guardar.paciente') }}" method="POST">
                @csrf
                <div>
                    <flux:heading size="lg">Nuevo paciente</flux:heading>
                    <flux:text class="mt-2">Crea una nueva cuenta para un paciente.</flux:text>
                </div>
                <flux:input label="Nombre" name="nombre" placeholder="Nombre del paciente" />
                <flux:input label="Apellido(s)" name="apellido" placeholder="Apellido(s) del paciente" />
                <flux:input label="Correo" name="email" placeholder="correo@ejemplo.com" />
                <flux:input label="Contraseña" name="password" placeholder="Contraseña" type="password" viewable />
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Guardar nuevo paciente</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</x-layouts.app.header>
