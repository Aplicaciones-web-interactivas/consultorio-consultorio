

<x-layouts.app.header>
    <div class="max-w-lg mx-auto mt-6">

        <flux:heading size="xl" class="mb-2"> Registro de consulta </flux:heading>
        <flux:separator class="mb-4"/>
        <flux:text size="lg"> Crear una nueva receta medica para tus pacientes. </flux:text>

        <form action="" method="POST" class=" p-4 mx-auto flex flex-col gap-4">
            <div class="w-full flex flex-row gap-4" style="align-items: end">
                <flux:select placeholder="Selecciona un paciente" clearable label="Paciente" name="paciente">
                    <flux:select.option value="id">Jaime</flux:select.option>
                    <flux:select.option value="id">Pedro</flux:select.option>
                    <flux:select.option value="id">Antonio</flux:select.option>
                    <flux:select.option value="id">Carlos</flux:select.option>
                    <flux:select.option value="id">Juan</flux:select.option>
                </flux:select>

                <flux:modal.trigger name="edit-profile">
                    <flux:button variant="ghost" class="cursor-pointer" icon="plus" >Nuevo paciente</flux:button>
                </flux:modal.trigger>

                <flux:modal name="nuevo-paciente">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Nuevo paciente</flux:heading>
                            <flux:text class="mt-2">Crea una nueva cuenta para un paciente.</flux:text>
                        </div>
                        <flux:input label="Nombre" name="nombre" placeholder="Nombre del paciente" />
                        <flux:input label="Apellido(s)" name="apellido" placeholder="Apellido(s) del paciente" />
                        <flux:input label="Correo" name="correo" placeholder="correo@ejemplo.com" />
                        <flux:input label="Contraseña" name="password" placeholder="Contraseña" type="password" viewable />
                        <flux:input name="rol" value="paciente" readonly class="hidden"/>
                        <div class="flex">
                            <flux:spacer />
                            <flux:button type="submit" variant="primary">Guardar nuevo paciente</flux:button>
                        </div>
                    </div>
                </flux:modal>
            </div>
            <flux:input type="date" name="fecha" max="2999-12-31" label="Fecha"/>
            <flux:textarea label="Sintomas" name="sintomas" placeholder="Agregue aqui los sintomas..."/>
            <div class="flex flex-col gap-4 mt-4">
                <flux:button variant="primary" type="submit" class="cursor-pointer">Guardar</flux:button>
                <flux:checkbox label="Descargar receta" name="descargar" checked/>
            </div>
        </form>
    </div>
</x-layouts.app.header>
