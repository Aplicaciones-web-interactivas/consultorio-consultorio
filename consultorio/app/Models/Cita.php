<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';
    protected $fillable = [
        'IdPaciente',
        'IdDoctor',
        'Fecha',
        'Hora',
        'Confirmacion',
    ];

    protected $casts = [
        'Fecha' => 'date',
        'Confirmacion' => 'boolean',
    ];

    // Relación con el paciente (usuario)
    public function paciente()
    {
        return $this->belongsTo(User::class, 'IdPaciente', 'id');
    }

    // Relación con el doctor (usuario)
    public function doctor()
    {
        return $this->belongsTo(User::class, 'IdDoctor', 'id');
    }
}