<x-layouts.app :title="__('Importar Excel')">
    <div class="col col-span-12 grid grid-cols-1 gap-2 ">
        <div class="p-6 border rounded-lg shadow-md">
            <flux:heading size="lg" class="mb-5">Exportar archivo</flux:heading>
            <form method="POST" action="{{ route('import_excel') }}" enctype="multipart/form-data">
                @csrf
                <label for="file"></label>
                <input type="file" name="file" id="file" class="border rounded px-2 py-1 mb-4 w-full" required />
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Subir archivo</button>
            </form>
        </div>
        <div class="p-6 border rounded-lg shadow-md">
            <flux:heading size="lg" class="mb-5">Subidos:</flux:heading>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellido</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($subidos as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->apellido }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 border rounded-lg shadow-md">
            <flux:heading size="lg" class="mb-5">Mis Pacientes:</flux:heading>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellido</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($mis_pacientes as $paciente)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $paciente->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $paciente->apellido }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $paciente->email}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</x-layouts.app>