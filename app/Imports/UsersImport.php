<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UsersImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user_id = !(User::where('id', '=', intval($row[0]))->exists());
        $importData = [
            'id'            => intval($row[0]),
            'name'          => strval($row[1]),
            'email'         => strval($row[2]),
            'password'      => \Hash::make('123456'),
            'department_id' => intval($row[3]),
            'position'      => strval($row[4]),
            'salary'        => intval($row[5]),
            'debt'          => intval($row[6]),
            'birthday'      => date("Y-m-d", strtotime($row[7])),
            'hiredate'      => date("Y-m-d", strtotime($row[8])),
            'shiftcode'     => strval($row[9]),
        ];
        if($user_id) {
            return new User($importData);
        } else {
            $user = User::findOrFail(intval($row[0]));
            $user->name          = strval($row[1]);
            $user->email         = strval($row[2]);
            $user->department_id = intval($row[3]);
            $user->position      = strval($row[4]);
            $user->salary        = intval($row[5]);
            $user->debt          = intval($row[6]);
            $user->birthday      = date("Y-m-d", strtotime($row[7]));
            $user->hiredate      = date("Y-m-d", strtotime($row[8]));
            $user->shiftcode     = strval($row[9]);
            $user->save();
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
