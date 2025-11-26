<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;  // ← Agrega esta línea

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nombre' => 'Test',
            'apellido' => 'Usuario',
            'rol' => 'paciente',
            'email' => 'test@test.com',
            'password' => Hash::make('12345678'),
        ]);
        User::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'rol' => 'doctor',
            'email' => 'doctor@test.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}