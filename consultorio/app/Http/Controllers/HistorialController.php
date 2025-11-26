<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cita;
use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HistorialController extends Controller
{
    public function index()
    {
        $pacientes = User::whereIn('id', Historial::distinct()->pluck('IdPaciente'))
            ->orderBy('nombre')
            ->get();

        return view('historial.index', compact('pacientes'));
    }

    public function show(User $paciente)
    {
        $citas = Cita::where('IdPaciente', $paciente->id)
            ->with('doctor')
            ->orderBy('Fecha', 'desc')
            ->get();

        $historials = Historial::where('IdPaciente', $paciente->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('historial.show', compact('paciente', 'historials', 'citas'));
    }

    public function edit(Cita $cita)
    {
        $cita->load('paciente', 'doctor');

        return view('historial.edit', compact('cita'));
    }

    public function update(Request $request, Historial $historial)
    {
        $validated = $request->validate([
            'Enfermedad' => 'nullable|string|max:255',
            'Medicacion' => 'nullable|string|max:500',
            'Fecha' => 'nullable|date',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'nullable|image|max:5120',
            'imagenes_eliminar' => 'nullable|array',
            'imagenes_eliminar.*' => 'nullable|integer',
        ]);

        if ($request->filled('Enfermedad')) {
            $historial->Enfermedad = $validated['Enfermedad'];
        }

        if ($request->filled('Medicacion')) {
            $historial->Medicacion = $validated['Medicacion'];
        }

        if ($request->filled('Fecha')) {
            $historial->Fecha = $validated['Fecha'];
        }

        $imagenes = $historial->imagen ?? [];

        if (is_string($imagenes)) {
            $imagenes = json_decode($imagenes, true) ?? [];
        } elseif (!is_array($imagenes)) {
            $imagenes = [];
        }

        if ($request->has('imagenes_eliminar') && $request->input('imagenes_eliminar')) {
            $indices_eliminar = $request->input('imagenes_eliminar');
            rsort($indices_eliminar);

            foreach ($indices_eliminar as $index) {
                if (isset($imagenes[$index])) {
                    $imagePath = $imagenes[$index];
                    if (Storage::exists($imagePath)) {
                        Storage::delete($imagePath);
                    }
                    unset($imagenes[$index]);
                }
            }

            $imagenes = array_values($imagenes);
        }

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $file) {
                if ($file) {
                    $path = $file->store('historials', 'public');
                    $imagenes[] = $path;
                }
            }
        }

        $historial->imagen = !empty($imagenes) ? $imagenes : null;
        $historial->save();

        return response()->json([
            'success' => true,
            'message' => 'Historial actualizado correctamente',
            'imagenes' => $historial->imagen ?? []
        ]);
    }

    public function deleteImage(Request $request, Historial $historial)
    {
        $imageIndex = $request->input('image_index');
        $imagenes = $historial->imagen ?? [];

        if (is_string($imagenes)) {
            $imagenes = json_decode($imagenes, true) ?? [];
        } elseif (!is_array($imagenes)) {
            $imagenes = [];
        }

        if (isset($imagenes[$imageIndex])) {
            $imagePath = $imagenes[$imageIndex];

            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }

            unset($imagenes[$imageIndex]);

            $imagenes = array_values($imagenes);

            $historial->imagen = !empty($imagenes) ? $imagenes : null;
            $historial->save();

            return response()->json([
                'success' => true,
                'imagenes' => $historial->imagen ?? []
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Imagen no encontrada'], 404);
    }
}
