<?php

namespace App\Imports;

use App\Notice;
use Maatwebsite\Excel\Concerns\ToModel;

class NoticesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Notice([
            'user_id'       => $row[9],
            'CalculateDate' => $row[1],
            'DutyIn'        => $row[2],
            'DutyOut'       => $row[3],
            'InTime'        => $row[4],
            'OutTime'       => $row[5],
            'WorkingHours'  => $row[6],
            'Absent'        => $row[7],
            'Late'          => $row[8],
        ]);
    }
}
