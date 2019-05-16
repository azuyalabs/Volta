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
                        <img src="{{ url('/images/volta-logo.png') }}" width="205" alt="{{ config('app.name') }}">
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
            <div class="col-4">
                <successrate-pie-chart></successrate-pie-chart>
            </div>
            <div class="col-8">
                <three-d-printer-jobs-heatmap></three-d-printer-jobs-heatmap>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-5">

            </div>
            <div class="col-md-7">
                <news></news>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-6">
                <thingiverse-featured></thingiverse-featured>
            </div>
            <div class="col-md-6">

            </div>
        </div>

            <div class="row">
                <div class="col-12">
                    <activity-histogram></activity-histogram>
                </div>
            </div>

    </div>
@endsection
