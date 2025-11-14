<?php

namespace App\Http\Controllers;

use App\Models\Consultorio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:users',
            'rol' => 'required',
            'password' => 'required|min:6',
        ]);

        User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'rol' => $request->rol,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email',
            'rol' => 'required',
        ]);

        $data = $request->only(['nombre', 'apellido', 'email', 'rol']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }

    public function creaPaciente(Request $request)
    {
        $paciente = new User();
        $paciente->nombre = $request->nombre;
        $paciente->apellido = $request->apellido;
        $paciente->email = $request->email;
        $paciente->password = bcrypt($request->password);
        $paciente->rol = 'paciente';
        $paciente->save();

        $asignar = new Consultorio;
        $asignar->IdDoctor = auth()->user()->id;
        $asignar->IdPaciente = $paciente->id;
        $asignar->save();

        return redirect()->back()->with('succcess', 'Nuevo usuario creado y asignado');
    }
}
