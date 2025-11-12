<?php

namespace App\Http\Controllers;
use App\Imports\UsersImport;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\consultorio;


use Illuminate\Http\Request;

class marvin_controller extends Controller
{
    public function importar_excel(){
        $mis_pacientes = user::whereIn('id', consultorio::where('IdDoctor',Auth()->id())->pluck('IdPaciente'))->get();
        $subidos = [];

        return view('importar_excel', compact('mis_pacientes', 'subidos'));
    }



    function import_excel(Request $request){
        Excel::import(new UsersImport, $request->file('file'));

        $coleccion = (new UsersImport)->toArray($request->file('file'));
        $subidos = [];

        foreach ($coleccion[0] as $fila) {
            if(consultorio::where('IdDoctor', Auth()->id())->where('IdPaciente', User::where('email', $fila[2])->first()->id)->exists()){
                continue;
            }
            
            $consultorio = new consultorio();

            $consultorio->IdDoctor = Auth()->id();
            $consultorio->IdPaciente = User::where('email', $fila[2])->first()->id;

            $consultorio->save();
            $subidos[] = User::where('email', $fila[2])->first();
            
        }

        $mis_pacientes = user::whereIn('id', consultorio::where('IdDoctor',Auth()->id())->pluck('IdPaciente'))->get();

        
        return view('importar_excel', compact('mis_pacientes', 'subidos'));
    }
}
