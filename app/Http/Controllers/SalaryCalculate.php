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
        if($salary >= 300000) {
            $SSD   = 6000;
        } else {
            $SSD   = (($salary/100)*2);
        }
        $dailyAmt  = ($salary/26);
        $hourlyAmt = ($dailyAmt/8);
        $minuteAmt = ($hourlyAmt/60);

        $monthDays = Notice::where('user_id', $sEmployee)->whereBetween('CalculateDate',[$sFDate, $sLDate])->get();
        $workingDays = $monthDays->where('Absent', 0);
        $absentDays  = $monthDays->where('Absent', 1);
        $reduceAmt   = round($dailyAmt*count($absentDays));
        $lateDays    = $workingDays->where('Late', '>', 0);
        $lDaysUn30   = $lateDays->where('Late', '<', 30);
        $lDaysOv30   = $lateDays->where('Late', '>=', 30);
        $lateAmt     = 0;
        $ttLMOv30    = 0;
        
        if(!empty($lDaysUn30)) {
            $lateAmt = (2500 * count($lateDays));
            $reduceAmt += $lateAmt;
        }

        if(!empty($lDaysOv30)) {
            foreach($lDaysOv30 as $lDayOv30) {
                $minuteOv30 = ($lDayOv30->Late-29);
                $ttLMOv30 += $minuteOv30;
            }
            $reduceAmt += ($minuteAmt * $ttLMOv30);
        }

        $netSalary   = ($salary-$reduceAmt);

        $calculatedData = [count($workingDays), $emName, $salary, count($absentDays), $dailyAmt, count($lateDays), count($lDaysUn30), count($lDaysOv30), $lateAmt, $reduceAmt, $netSalary];

        return view('vendor/voyager/salary/browse', compact('employees', 'calculatedData'));

    }
}

