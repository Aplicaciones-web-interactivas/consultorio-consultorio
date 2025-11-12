<x-layouts.app :title="__('Dashboard')">
    <flux:heading size="lg" class="mb-5">Exportar archivo</flux:heading>
            <form method="POST" action="{{ route('import_excel') }}" enctype="multipart/form-data">
                @csrf
                <label for="file"></label>
                <input type="file" name="file" id="file" class="border rounded px-2 py-1 mb-4 w-full" require />
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Subir archivo</button>
            </form>
</x-layouts.app>
