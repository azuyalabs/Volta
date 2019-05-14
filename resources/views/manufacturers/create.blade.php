@extends('layouts.default')

@section('page')
@section('title')
    @lang('manufacturers.add_manufacturer')
@endsection
@section('subtitle')
    @lang('manufacturers.add_manufacture_subtitle')
@endsection
@section('page-content')
    {!! Form::open(['url' => '/manufacturers', 'class' => 'form-horizontal']) !!}
    @include ('manufacturers.form', ['submitButtonText' => 'Create'])
    {!! Form::close() !!}
@endsection
@endsection
