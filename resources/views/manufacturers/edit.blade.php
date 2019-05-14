@extends('layouts.default')

@section('page')
@section('title')
    @lang('manufacturers.edit_manufacturer')
@endsection
@section('subtitle')
    @lang('manufacturers.edit_manufacture_subtitle', ['manufacturer_name' => $manufacturer->name])
@endsection
@section('page-content')
    {!! Form::model($manufacturer, ['method' => 'PATCH', 'class' => 'form-horizontal', 'route' => ['manufacturers.update', $manufacturer->{$manufacturer->getRouteKeyName()}]])  !!}
    @include ('manufacturers.form', ['submitButtonText' => __('main.update')])
    {!! Form::close() !!}
@endsection
@endsection