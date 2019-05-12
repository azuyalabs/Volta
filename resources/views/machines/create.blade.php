@extends('layouts.default')

@section('page')
@section('title')
    @lang('machines.add_machine')
@endsection
@section('subtitle')
    @lang('machines.add_machine_subtitle')
@endsection
@section('page-content')
    {!! Form::open(['url' => '/machines', 'class' => 'form-horizontal']) !!}
    @include ('machines.form', ['submitButtonText' => 'Create', 'models' => $models])
    {!! Form::close() !!}
@endsection
@endsection
