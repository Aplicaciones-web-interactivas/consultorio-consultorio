<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;

class UsersImport implements ToModel, WithSkipDuplicates
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    use Importable;
    public function model(array $row)
    {
        if (User::where('email', $row[2])->exists()) {
            return null;
        }
        return new User([
            'nombre'     => $row[0],
            'apellido'    => $row[1],
            'rol'       => 'paciente',
            'email'    => $row[2],
            'password'    => bcrypt($row[3]),
            
        ]);
    }
}
