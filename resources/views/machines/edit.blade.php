@extends('layouts.default')

@section('page')
@section('title')
    {{ $machine->name }}
@endsection
@section('subtitle')
    @lang('machines.update_machine_subtitle', ['manufacturer_name' => $machine->model->manufacturer->name ?? 'Unknown', 'model_name' => $machine->model->name ?? 'Unknown'])
@endsection
@section('page-content')
    {!! Form::model($machine, ['method' => 'PATCH', 'class' => 'form-horizontal', 'route' => ['machines.update', $machine->id]])  !!}
    @include ('machines.form', ['submitButtonText' => 'Update', 'models' => $models])
    {!! Form::close() !!}
@endsection
@endsection
