@extends('layouts.default')

@section('page')
@section('title')
    @lang('spools.add_spool')
@endsection
@section('subtitle')
    @lang('spools.add_spool_subtitle')
@endsection
@section('page-content')
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {!! Form::open(['url' => '/spools', 'class' => 'form-horizontal']) !!}
    @include ('spools.form', ['submitButtonText' => __('main.add')])
    {!! Form::close() !!}
@endsection
@endsection