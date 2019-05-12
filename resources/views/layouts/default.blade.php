@extends('layouts.app')

@section('content')
    <b-container fluid class="container">
        <div class="row">
            <div class="col-md-12 d-flex">
                <h1 class="display-5">@yield('title')</h1>
                @if (Request::is(['*create', '*edit']))
                    <div class="ml-auto">
                        @include('partials.edit_actions')
                    </div>
                @endif
            </div>
            <p class="col-md-12 text-muted text-uppercase small">
                @yield('subtitle')
            </p>
        </div>
        <div class="mb-4">
            @yield('metrics')
        </div>
        <div class="card-collection card">
            <div class="card-body">
                @yield('page-content')
            </div>
        </div>
    </b-container>
@endsection
