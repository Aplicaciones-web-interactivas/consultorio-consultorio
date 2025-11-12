<?php

namespace App\Http\Controllers;
use App\Imports\UsersImport;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\consultorio;




use Illuminate\Http\Request;

class marvin_controller extends Controller
{
    function import_excel(Request $request){
        Excel::import(new UsersImport, $request->file('file'));

        $coleccion = (new UsersImport)->toArray($request->file('file'));

        foreach ($coleccion[0] as $fila) {
            $user = User::where('email',$fila[3])->first();

            $consultorio = new consultorio();

            $consultorio->IdDoctor = Auth()->id();
            $consultorio->IdPaciente = $user->id;
            $consultorio->save();

            echo "Usuario importado: " . $fila[3] . " Con el ID ". $user->id . "<br>";
        }

    }
}
