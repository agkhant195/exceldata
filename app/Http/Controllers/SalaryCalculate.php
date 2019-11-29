<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Notice;
use DateTime;

class SalaryCalculate extends Controller
{
    public function index() {
        $employees = User::where('role_id', 3)->get();
        return view('vendor/voyager/salary/browse', compact('employees'));
    }

    public function calculate(Request $request) {
        $employees = User::where('role_id', 3)->get();

        $sEmployee = $request->employee;
        $sDate1    = new DateTime($request->year.'-'.$request->month);
        $sDate2    = new DateTime($request->year.'-'.$request->month);
        $sFDate    = $sDate1->modify("first day of");
        $sLDate    = $sDate2->modify("last day of");

        $sData     = [$sEmployee, $request->year, $request->month];

        $employee  = User::findOrFail($sEmployee);
        $emName    = $employee->name;
        $salary    = $employee->salary;
        $SSB       = 0;

        if($employee->SSB == 1) {
            if($salary >= 300000) {
                $SSB   = 6000;
            } else {
                $SSB   = (($salary/100)*2);
            }
        }

        $dailyAmt  = ($salary/26);
        $hourlyAmt = ($dailyAmt/8);
        $minuteAmt = ($hourlyAmt/60);

        $monthDays = Notice::where('user_id', $sEmployee)->whereBetween('CalculateDate',[$sFDate, $sLDate])->get();
        $workingDays = $monthDays->where('WorkingHours', '!=', null);
        $absentDays  = $monthDays->where('Absent', 1);
        $leaveDays   = $absentDays->where('Leave', 1);
        $reduceAmt   = round(($dailyAmt*( count($absentDays)-count($leaveDays)) ) + $SSB);
        $dutyOut     = $workingDays->first()->DutyOut;
        $earlyDays   = $workingDays->where('OutTime', '<', $dutyOut);
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
                if($lDayOv30->Late < 180) {
                    $minuteOv30 = ($lDayOv30->Late-30);
                    $ttLMOv30 += $minuteOv30;
                } else {
                    $laMn = $lDayOv30->Late - 179;
                    if($laMn > 60) {
                        $minuteOv30 = ($lDayOv30->Late-90);
                        $ttLMOv30 += $minuteOv30;
                    } else {
                        $minuteOv30 = ($lDayOv30->Late-(30+$laMn));
                        $ttLMOv30 += $minuteOv30;
                    }
                }
            }
            $reduceAmt += ($minuteAmt * $ttLMOv30);
        }

        if(!empty($earlyDays)) {
            $earlyMinutes = 0;
            foreach($earlyDays as $earlyDay) {
                $dTOMi = intval(substr($earlyDay->DutyOut, 3, 2));
                $tMOMi = intval(substr($earlyDay->OutTime, 3, 2));
                $earlyHour = (intval($earlyDay->DutyOut) - intval($earlyDay->OutTime)) - 1;
                if($earlyHour < 5) {
                    $earlyMinutes += $earlyHour * 60;
                    if($dTOMi == 0) {
                        $earlyMinute = ( 60 - $tMOMi );
                        if($earlyMinute > 0) {
                            $earlyMinutes += $earlyMinute;
                        }
                    } else {
                        if($dTOMi >= $tMOMi) {
                            $earlyMinute = $dTOMi - $tMOMi;
                            if($earlyMinute > 0) {
                                $earlyMinutes += $earlyMinute;
                            }
                        } else {
                            $earlyMinute = ($dTOMi + 60) - $tMOMi;
                            if($earlyMinute > 0) {
                                $earlyMinutes += $earlyMinute;
                            }
                        }
                    }
                } elseif($earlyHour == 5) {
                    $earlyMinutes += 300;
                } else {
                    $earlyMinutes += $earlyHour * 60;
                    if($dTOMi == 0) {
                        $earlyMinute = ( 60 - $tMOMi );
                        if($earlyMinute > 0) {
                            $earlyMinutes += $earlyMinute;
                        }
                    } else {
                        if($dTOMi >= $tMOMi) {
                            $earlyMinute = $dTOMi - $tMOMi;
                            if($earlyMinute > 0) {
                                $earlyMinutes += $earlyMinute;
                            }
                        } else {
                            $earlyMinute = ($dTOMi + 60) - $tMOMi;
                            if($earlyMinute > 0) {
                                $earlyMinutes += $earlyMinute;
                            }
                        }
                    }
                    $earlyMinutes -= 60;
                }                
            }
            $reduceAmt += ($minuteAmt * $earlyMinutes);
        }

        $netSalary   = ($salary-$reduceAmt);

        $calculatedData = [count($workingDays), $emName, $salary, count($absentDays), count($leaveDays), $dailyAmt, count($lateDays), count($lDaysUn30), count($lDaysOv30), $lateAmt, $SSB, round($reduceAmt), round($netSalary, -2), $sData, count($earlyDays)];

        return view('vendor/voyager/salary/browse', compact('employees', 'calculatedData', 'sData'));

    }
}

