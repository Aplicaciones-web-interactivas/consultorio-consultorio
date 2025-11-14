<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Consultorio;
use App\Models\Receta;

use Dompdf\Dompdf;

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

        if ($request->descargar){
            ConsultasController::imprimirReceta($receta);
        }

        return redirect()->back()->with(['msg' => 'La receta fue guardada correctamente']);
    }

    public function imprimirReceta($receta){
        $doctor = User::find($receta->IdDoctor);
        $paciente = User::find($receta->IdPaciente);
        $dompdf = new Dompdf();
        $html = view('receta', compact('receta', 'doctor', 'paciente'));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream('receta.pdf');
    }

    public function generatePDF($id){
        $task = Task::find($id);
        $dompdf = new Dompdf();
        #$html = "<h1>" . $task->name . "</h1>";
        $html = view('task', compact('task'));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream('tarea-' . $task->id .'.pdf');
    }
}
