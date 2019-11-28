<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\NoticesExport;
use App\Exports\NoticesFilterExport;
use App\Imports\NoticesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\UploadFile;
use App\User;

class NoticesImportExport extends Controller
{
    /* Notice Export */
    public function export() {
        return Excel::download(new NoticesExport, 'notices.xlsx');
    }

    /* Notice UploadCSV */
    public function upload() {
        return view('vendor/voyager/notices/import');
    }

    /* Notice Import */
    public function import(UploadFile $request) {
        Excel::import(new NoticesImport,request()->file('file'));
        return redirect('admin/notices');
    }
}
