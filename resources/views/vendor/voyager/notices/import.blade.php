@extends('voyager::master')

@section('page_title', 'Notices Import')

@section('page_header')
    <div class="container-fluid" style="height: 103px;">
        <h1 class="page-title">
            <i class="voyager-double-down" style="font-size: 25px;"></i> Notices Import
        </h1>
    </div>
@stop

@section('content')

@if ($errors->any())
      <div class="alert alert-danger" style="margin: 0 59px;">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
@endif

    <div class="container">
        {!! Form::open(['method'=>'Post', 'action'=>'NoticesImportExport@import', 'files'=>true]) !!}
        <div class="form-group">
            {!! Form::label('file', 'File:') !!}
            {!! Form::file('file', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Import', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop
