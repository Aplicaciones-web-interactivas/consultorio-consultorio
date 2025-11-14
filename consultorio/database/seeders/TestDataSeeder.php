<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Historial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $doctor1 = User::create([
            'nombre' => 'Dr. Juan',
            'apellido' => 'Pérez',
            'rol' => 'Doctor',
            'email' => 'doctor1@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $doctor2 = User::create([
            'nombre' => 'Dra. María',
            'apellido' => 'García',
            'rol' => 'Doctor',
            'email' => 'doctor2@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $paciente1 = User::create([
            'nombre' => 'Carlos',
            'apellido' => 'López',
            'rol' => 'Paciente',
            'email' => 'paciente1@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $paciente2 = User::create([
            'nombre' => 'Ana',
            'apellido' => 'Martínez',
            'rol' => 'Paciente',
            'email' => 'paciente2@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $paciente3 = User::create([
            'nombre' => 'Roberto',
            'apellido' => 'Sánchez',
            'rol' => 'Paciente',
            'email' => 'paciente3@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        Historial::create([
            'IdPaciente' => $paciente1->id,
            'Enfermedad' => 'Hipertensión',
            'Medicacion' => 'Losartán 50mg',
            'Fecha' => Carbon::now()->subMonths(6),
            'imagen' => null,
        ]);

        Historial::create([
            'IdPaciente' => $paciente1->id,
            'Enfermedad' => 'Diabetes Tipo 2',
            'Medicacion' => 'Metformina 850mg',
            'Fecha' => Carbon::now()->subMonths(3),
            'imagen' => null,
        ]);

        Historial::create([
            'IdPaciente' => $paciente1->id,
            'Enfermedad' => 'Migraña Crónica',
            'Medicacion' => 'Sumatriptán 50mg',
            'Fecha' => Carbon::now()->subWeeks(2),
            'imagen' => null,
        ]);

        Historial::create([
            'IdPaciente' => $paciente2->id,
            'Enfermedad' => 'Colesterol Alto',
            'Medicacion' => 'Atorvastatina 20mg',
            'Fecha' => Carbon::now()->subMonths(4),
            'imagen' => null,
        ]);

        Historial::create([
            'IdPaciente' => $paciente2->id,
            'Enfermedad' => 'Asma',
            'Medicacion' => 'Salbutamol inhaler',
            'Fecha' => Carbon::now()->subMonths(1),
            'imagen' => null,
        ]);

        Historial::create([
            'IdPaciente' => $paciente3->id,
            'Enfermedad' => 'Dermatitis',
            'Medicacion' => 'Crema hidratante + corticosteroide',
            'Fecha' => Carbon::now()->subWeeks(1),
            'imagen' => null,
        ]);
    }
}
