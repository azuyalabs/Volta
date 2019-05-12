@extends('layouts.default')

@section('page')
@section('title')
    @lang('preferences.section')
@endsection
@section('subtitle')
    @lang('preferences.subtitle')
@endsection

@section('page-content')
    <div class="alert alert-info mb-5" role="alert">
        @lang('preferences.refresh_note')
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-2" id="preferences-navigation">
                <ul>
                    @foreach ($index as $key => $element)
                        @if (count($element['parts']) !== 0 && $element['enabled'])
                            <li>
                                <b-link href="#" v-b-toggle.{{ $key }}>{{ $element['name'] }}</b-link>
                                <b-collapse id="{{ $key }}"
                                            accordion="preferences" {{ $component === $key ? 'visible' : '' }}>
                                    <ul>
                                        @foreach ($element['parts'] as $p)
                                            <li>{{ link_to($p['url'], $p['name']) }}</li>
                                        @endforeach
                                    </ul>
                                </b-collapse>
                            </li>
                        @endif
                    @endforeach
                </ul>

            </div>
            <div class="col">
                <h3>@lang('preferences.' . $part.'.name')</h3>
                <p class="text-muted">@lang('preferences.'.$part.'.text')</p>
                @yield('preference_content')
            </div>
        </div>
    </div>
@endsection
@endsection
