<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Consultorio;
use App\Models\Receta;

/**
 * Controlador para las recetas de los pacientes
 * ~ Jacobo Rodriguez Torres
 */
class ConsultasController extends Controller
{
    /**
     * Retorna los datos necesarios a la vista de consulta.
     */
    public function index(){
        // $pacientes = User::all();
        $pacientes = DB::table('users')
            ->join('consultorios', 'consultorios.IdPaciente', '=', 'users.id')
            ->where('consultorios.IdDoctor', auth()->user()->id)
            ->select('users.*')
            ->distinct()->get();

        return view('consulta', compact('pacientes'));
    }

    public function guardarReceta(REQUEST $request){
        $receta = new Receta();
        $receta->IdPaciente = $request->paciente;
        $receta->IdDoctor = auth()->user()->id;
        $receta->Medicamentos = $request->medicamentos;
        $receta->Fecha = $request->fecha;
        $receta->save();

        if ($request->imprimible){
            // Imprimir receta.
        }

        return redirect()->back()->with(['msg' => 'La receta fue guardada correctamente']);
    }
}
