@extends('vendor.voyager.master')

@section('page_title', 'Salary Calculation')

@section('datePickerLink')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop

@section('page_header')
    <div class="container-fluid" style="height: 103px;">

        <h1 class="page-title">
            <i class="voyager-dollar"></i> Salary Calculation
        </h1>
    
        {!! Form::open(['method'=>'Post', 'action'=>'SalaryCalculate@calculate']) !!}
        
        <select name="employee" style="height: 28px; margin-right: 5px;" required>
            <option value="">Employee</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
            @endforeach
        </select>

        <select name="year" style="height: 28px; margin-right: 5px;" required>
            <option value="">Year</option>
            <option value="2019">2019</option>
            <option value="2018">2018</option>
        </select>

        <select name="month" style="height: 28px; margin-right: 5px;" required>
            <option value="">Month</option>
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
        </select>

        {!! Form::submit('Calculate', ['class'=>'btn btn-primary pull-right']) !!}

        {!! Form::close() !!}

        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid" style="display: block; margin-top: 50px;">
        @if(!empty($calculatedData[2]))
            <p>Employee Name: {{ $calculatedData[0] }}</p>
            <p>Salary: {{ $calculatedData[1] }}</p>
            <p>Absent Days: {{ $calculatedData[3] }}</p>
            <p>Daily Amount: {{ round($calculatedData[4]) }}</p>
            <p>Reduce Amount: {{ $calculatedData[5] }}</p>
            <p>Net Salary: {{ $calculatedData[6] }}</p>
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