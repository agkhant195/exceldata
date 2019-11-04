<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'id'            => $row[0],
            'role_id'       => $row[1],
            'name'          => $row[2],
            'email'         => $row[3],
            'password'      => 123,
            'department_id' => $row[8],
            'salary'        => $row[9],
            'debt'          => $row[10],
            'position'      => $row[11],
            'birthday'      => $row[12],
            'hiredate'      => $row[13],
            'shiftcode'     => $row[14],
        ]);
    }
}
