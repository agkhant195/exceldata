<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Notice extends Model
{
    protected $fillable = [
        'user_id',
        'CalculateDate',
        'DutyIn',
        'DutyOut',
        'InTime',
        'OutTime',
        'WorkingHours',
        'Absent',
        'Late',
    ];
}
