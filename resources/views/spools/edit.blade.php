@extends('layouts.default')

@section('page')
@section('title')
    {{ $spool->name }}
@endsection
@section('subtitle')
    @lang('spools.update_spool_subtitle', ['manufacturer_name' => $spool->manufacturer->name, 'spool_name' => $spool->name])
@endsection
@section('page-content')
    {!! Form::model($spool, ['method' => 'PATCH', 'class' => 'form-horizontal', 'route' => ['spools.update', $spool->{$spool->getRouteKeyName()}]])  !!}
    @include ('spools.form', ['submitButtonText' => __('main.update')])
    {!! Form::close() !!}
@endsection
@endsection