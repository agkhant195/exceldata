<?php

namespace App\Exports;

use App\Notice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NoticesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Notice::get([
            'user_id',
            'CalculateDate',
            'DutyIn',
            'DutyOut',
            'InTime',
            'OutTime',
            'WorkingHours',
            'Absent',
            'Late',
        ]);
    }

    public function headings(): array
    {
        return [
            'Worker ID',
            'Calculate Date',
            'Duty In',
            'Duty Out',
            'In Time',
            'Out Time',
            'Working Hours',
            'Absent',
            'Late',
        ];
    }
}
