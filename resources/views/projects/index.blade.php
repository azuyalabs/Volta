@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="display-5">{{ trans_choice('manufacturers.model_name', 2) }}</h1>
                <p class="text-muted" style="font-size: small;text-transform: uppercase">Your stockpile of 3D Printer
                    Filament Spools. Currently you
                    have {{ trans_choice('spools.model_count', 1, ['value' => 1]) }}
                    with a value of @MoneyFormat(2).</p>
            </div>
        </div>

        <div class="row mt-2">

            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        @include('partials.index_actions', ['entity' => 'manufacturers'])

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>@lang('manufacturers.name')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($projects as $item)
                                    <tr>
                                        <td>{{ $item }}</td>
                                        <td><a href="{{ route('projects.show', ['project' => $item]) }}"
                                               title="View more details about Manufacturer {{ $item }}">{{ $item }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
