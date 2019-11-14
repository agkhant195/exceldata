@extends('vendor.voyager.master')

@section('page_title', 'Salary Calculation')

@section('datePickerLink')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop

@section('page_header')
    <div class="container-fluid" style="height: 103px;">

        <h1 class="page-title">
            <i class="voyager-dollar"></i> Salary Calculate
        </h1>
    
        {!! Form::open(['method'=>'Post', 'action'=>'SalaryCalculate@calculate']) !!}
        
        <select name="employee" style="height: 28px; margin-right: 5px;" required>
            <option value="">Employee</option>
            @if(!empty($sData))
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ $sData[0] ==  $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                @endforeach
            @else
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            @endif
        </select>

        <select name="year" style="height: 28px; margin-right: 5px;" required>
            <option value="">Year</option>
            @if(!empty($sData))
                <option value="{{ now()->year }}" {{ $sData[1] ==  now()->year ? 'selected' : '' }}>{{ now()->year }}</option>
                <option value="{{ now()->year - 1 }}" {{ $sData[1] ==  now()->year - 1 ? 'selected' : '' }}>{{ now()->year - 1 }}</option>
            @else
                <option value="{{ now()->year }}">{{ now()->year }}</option>
                <option value="{{ now()->year - 1 }}">{{ now()->year - 1 }}</option>
            @endif
        </select>

        <select name="month" style="height: 28px; margin-right: 5px;" required>
            <option value="">Month</option>
            @if(!empty($sData))
                <option value="1" {{ $sData[2] ==  1 ? 'selected' : '' }}>Jan</option>
                <option value="2" {{ $sData[2] ==  2 ? 'selected' : '' }}>Feb</option>
                <option value="3" {{ $sData[2] ==  3 ? 'selected' : '' }}>Mar</option>
                <option value="4" {{ $sData[2] ==  4 ? 'selected' : '' }}>Apr</option>
                <option value="5" {{ $sData[2] ==  5 ? 'selected' : '' }}>May</option>
                <option value="6" {{ $sData[2] ==  6 ? 'selected' : '' }}>Jun</option>
                <option value="7" {{ $sData[2] ==  7 ? 'selected' : '' }}>Jul</option>
                <option value="8" {{ $sData[2] ==  8 ? 'selected' : '' }}>Aug</option>
                <option value="9" {{ $sData[2] ==  9 ? 'selected' : '' }}>Sep</option>
                <option value="10" {{ $sData[2] ==  10 ? 'selected' : '' }}>Oct</option>
                <option value="11" {{ $sData[2] ==  11 ? 'selected' : '' }}>Nov</option>
                <option value="12" {{ $sData[2] ==  12 ? 'selected' : '' }}>Dec</option>
            @else
                <option value="1">Jan</option>
                <option value="2">Feb</option>
                <option value="3">Mar</option>
                <option value="4">Apr</option>
                <option value="5">May</option>
                <option value="6">Jun</option>
                <option value="7">Jul</option>
                <option value="8">Aug</option>
                <option value="9">Sep</option>
                <option value="10">Oct</option>
                <option value="11">Nov</option>
                <option value="12">Dec</option>
            @endif
        </select>

        {!! Form::submit('Calculate', ['class'=>'btn btn-primary pull-right salary-calculate']) !!}

        {!! Form::close() !!}

        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid" style="display: block; margin-top: 50px;">
        @if(!empty($calculatedData[0]))
            <p>Employee Name: {{ $calculatedData[1] }}</p>
            <p>Salary: {{ $calculatedData[2] }}</p>
            <p>Absent Days: {{ $calculatedData[3] }}</p>
            <p>Daily Amount: {{ round($calculatedData[4]) }}</p>
            <p>Late Days: {{ $calculatedData[5] }}</p>
            <p>Under30Mins: {{ $calculatedData[6] }} | Over30Mins: {{ $calculatedData[7] }}</p>
            <p>Late Amount: {{ $calculatedData[8] }}</p>
            <p>SSB: {{ $calculatedData[9] }}</p>
            <p>Total Reduce Amount: {{ $calculatedData[10] }}</p>
            <p>Net Salary: {{ $calculatedData[11] }}</p>
        @else
            <p>Results Not Found!</p>
        @endif
    </div>
@stop

@section('datePickerScript')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
            });
        } );
    </script>
@stop