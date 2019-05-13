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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">@lang('machines.section')</div>

                    <div class="card-body">
                        <equipment-statistics
                                :currency="'{{ Auth::user()->profile->currency }}'"></equipment-statistics>
                    </div>
                </div>
            </div>

            @if (Auth::user()->isAdministrator())
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">@choice('spools.model_name', 2)</div>

                        <div class="card-body">
                            <filament-statistics
                                    :currency="'{{ Auth::user()->profile->currency }}'"></filament-statistics>
                        </div>

                    </div>
                </div>
            @endif

        </div>
        <br>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Slicers
                        <h6 class="card-subtitle mt-1 text-muted" style="font-size: x-small">The latest releases of your
                            favourite slicer software</h6>
                    </div>

                    <div class="card-body">
                        <slicer-releases></slicer-releases>
                    </div>
                </div>
            </div>


        </div>

    </div>
@endsection
