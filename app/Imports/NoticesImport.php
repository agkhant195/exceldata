<?php

namespace App\Imports;

use App\User;
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
            $users = User::all();
            $user_id_list = [];
            foreach($users as $user) {
                array_push($user_id_list, $user->id);
            }
            $user_id_check = in_array ( intval($row[0]), $user_id_list);
            if($user_id_check) {
                return new Notice($importData);
            }
        } else {
            $notice = Notice::where('user_id', '=', intval($row[0]))->where('CalculateDate', '=', date("Y-m-d", strtotime($row[2])))->first();
            $notice = Notice::findOrFail($notice->id);
            $notice->DutyIn       = date("H:i:s", strtotime($row[3]));
            $notice->DutyOut      = date("H:i:s", strtotime($row[4]));
            $notice->InTime       = date("H:i:s", strtotime($row[5]));
            $notice->OutTime      = date("H:i:s", strtotime($row[6]));
            $notice->WorkingHours = strval($row[7]);
            $notice->Absent       = intval($row[9]);
            $notice->Late         = intval($row[10]);
            $notice->save();
        }
    }

    public function startRow(): int
    {
        return 3;
    }
}
