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

        @if (!Auth::user()->last_login)
            <b-modal id="modal-center" centered ok-only :visible="true">
                <template slot="modal-header">
                    <div class="container-fluid text-center">
                        <img src="{{ url('/img/volta-logo.png') }}" width="205" alt="{{ config('app.name') }}">
                    </div>
                </template>
                <h1 class="display-6 text-center">Hello, {{ Auth::user()->name }}!</h1>
                <p class="lead">and welcome to {{ config('app.name', 'Laravel') }}! Thank you so much for your help in
                    testing the first prototype of {{ config('app.name', 'Laravel') }}.</p>
                <p>With the first step - creating your Volta account - done, please navigate to
                    the {{ link_to_route('docs', __('docs.documentation')) }} section to get everything setup for the
                    test.</p>
            </b-modal>
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
