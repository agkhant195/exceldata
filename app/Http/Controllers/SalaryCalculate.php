<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Notice;
use DateTime;

class SalaryCalculate extends Controller
{
    public function index() {
        $employees = User::where('role_id', 2)->get();
        return view('vendor/voyager/salary/browse', compact('employees'));
    }

    public function calculate(Request $request) {
        $employees = User::where('role_id', 2)->get();

        $sEmployee = $request->employee;
        $sDate1    = new DateTime($request->year.'-'.$request->month);
        $sDate2    = new DateTime($request->year.'-'.$request->month);
        $sFDate    = $sDate1->modify("first day of");
        $sLDate    = $sDate2->modify("last day of");

        $employee  = User::findOrFail($sEmployee);
        $emName    = $employee->name;
        $salary    = $employee->salary;
        $dailyAmt  = ($salary/26);

        $monthDays = Notice::where('user_id', $sEmployee)->whereBetween('CalculateDate',[$sFDate, $sLDate])->get();
        $workingDays = count($monthDays->where('Absent', 0));
        $absentDays  = count($monthDays->where('Absent', 1));
        $reduceAmt   = round($dailyAmt*$absentDays);

        $netSalary   = ($salary-$reduceAmt);

        $calculatedData = [$emName, $salary, $workingDays, $absentDays, $dailyAmt, $reduceAmt, $netSalary];

        return view('vendor/voyager/salary/browse', compact('employees', 'calculatedData'));

    }
}

