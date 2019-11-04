<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\UploadFile;

class UsersImportExport extends Controller
{
    /* User Export */
    public function export() {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    /* User UploadCSV */
    public function upload() {
        return view('vendor/voyager/users/import');
    }

    /* User Import */
    public function import(UploadFile $request) {
        Excel::import(new UsersImport,request()->file('file'));           
        return redirect('admin/users');
    }
}
