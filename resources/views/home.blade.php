@extends('layouts.app')

@section('title')
    @lang('main.home')
@endsection

@section('content')

    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="row">
            <div class="col-4">
                <successrate-pie-chart></successrate-pie-chart>
            </div>
            <div class="col-8">
                <three-d-printer-jobs-heatmap></three-d-printer-jobs-heatmap>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-6">
                <news></news>
            </div>
            <div class="col-md-6">
                <thingiverse-featured></thingiverse-featured>
            </div>
        </div>

        <br>

    </div>
@endsection
