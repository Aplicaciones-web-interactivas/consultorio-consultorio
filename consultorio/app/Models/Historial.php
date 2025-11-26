<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $fillable = [
        'IdPaciente',
        'Enfermedad',
        'Medicacion',
        'Fecha',
        'imagen',
    ];

    protected $casts = [
        'Fecha' => 'date',
        'imagen' => 'array',
    ];

    public function paciente()
    {
        return $this->belongsTo(User::class, 'IdPaciente', 'id');
    }
}
