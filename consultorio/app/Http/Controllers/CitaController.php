<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    // Mostrar la vista de citas del paciente
    public function index()
    {
        $paciente = Auth::user();
        
        // Obtener la cita activa del paciente (la más reciente)
        $cita = Cita::where('IdPaciente', $paciente->id)
                    ->orderBy('Fecha', 'desc')
                    ->orderBy('Hora', 'desc')
                    ->first();
        
        // Obtener todos los doctores para el formulario
        $doctores = User::where('rol', 'doctor')->get();
        
        return view('citas.index', compact('cita', 'doctores'));
    }

    // Crear nueva cita
    public function store(Request $request)
    {
        $request->validate([
            'IdDoctor' => 'required|exists:users,id',
            'Fecha' => 'required|date|after_or_equal:today',
            'Hora' => 'required',
        ], [
            'Fecha.after_or_equal' => 'La fecha debe ser hoy o posterior',
            'IdDoctor.required' => 'Debes seleccionar un doctor',
        ]);

        Cita::create([
            'IdPaciente' => Auth::id(),
            'IdDoctor' => $request->IdDoctor,
            'Fecha' => $request->Fecha,
            'Hora' => $request->Hora,
            'Confirmacion' => false, // Pendiente por defecto
        ]);

        return redirect()->route('citas.index')->with('success', 'Cita agendada exitosamente');
    }

    // Cancelar cita
    public function destroy(Cita $cita)
    {
        // Verificar que la cita pertenece al usuario actual
        if ($cita->IdPaciente !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $cita->delete();

        return redirect()->route('citas.index')->with('success', 'Cita cancelada exitosamente');
    }
}