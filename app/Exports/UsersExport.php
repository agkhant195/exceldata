<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::get([
            'id',
            'name',
            'email',
            'department_id',
            'position',
            'salary',
            'debt',
            'birthday',
            'hiredate',
            'shiftcode'
        ]);
    }

    public function headings(): array
    {
        return [
            'Worker ID',
            'Name',
            'Email',
            'Department ID',
            'Position',
            'Salary',
            'Debt',
            'Birthday',
            'Hiredate',
            'Shiftcode'
        ];
    }
}
