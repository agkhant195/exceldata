<?php

namespace App\Exports;

use App\Notice;
use Maatwebsite\Excel\Concerns\FromCollection;

class NoticesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Notice::all();
    }
}
