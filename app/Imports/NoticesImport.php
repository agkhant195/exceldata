<?php

namespace App\Imports;

use App\Notice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class NoticesImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user_id = !(Notice::where('user_id', '=', intval($row[0]))->exists());
        $CalculateDate = !(Notice::where('CalculateDate', '=', date("Y-m-d", strtotime($row[2])))->exists());
        $importData = [
            'user_id'       => intval($row[0]),
            'CalculateDate' => date("Y-m-d", strtotime($row[2])),
            'DutyIn'        => date("H:i:s", strtotime($row[3])),
            'DutyOut'       => date("H:i:s", strtotime($row[4])),
            'InTime'        => date("H:i:s", strtotime($row[5])),
            'OutTime'       => date("H:i:s", strtotime($row[6])),
            'WorkingHours'  => strval($row[7]),
            'Absent'        => intval($row[9]),
            'Late'          => intval($row[10]),
        ];
        if($user_id || $CalculateDate) {
            return new Notice($importData);
        }
    }

    public function startRow(): int
    {
        return 3;
    }
}
