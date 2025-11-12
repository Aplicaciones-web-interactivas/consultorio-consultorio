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
        return new User([
            'nombre'     => $row[0],
            'apellido'    => $row[1],
            'rol'    => $row[2],
            'email'    => $row[3],
            'password'    => bcrypt($row[4]),
        ]);
    }
}
