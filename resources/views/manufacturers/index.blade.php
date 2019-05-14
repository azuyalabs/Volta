@extends('layouts.default')

@section('page')
@section('title')
    {{ trans_choice('manufacturers.model_name', 2) }}
@endsection

@if ($statistics->count > 0)
@section('subtitle')
    @lang('manufacturers.index_manufacturer_subtitle')
@endsection
@section('page-content')
    <manufacturers-table/>
@endsection
@else
@section('page-content')
    <div class="d-flex flex-column align-items-center">
        @svg('machine', 'icon-empty')
        <span>There is nothing but an empty space here.
            @role('experimental')
                Add a <a href="{{ URL::route('manufacturers.create') }}">new manufacturer</a> to Volta.
            @endrole
        </span>
    </div>
@endsection
@endif
@endsection
