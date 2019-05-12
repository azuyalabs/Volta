@extends('layouts.default')

@section('page')
@section('title')
    {{ trans_choice('machines.model_name', 2) }}
@endsection

@if ($statistics->count > 0)
@section('subtitle')
    @lang('machines.index_machine_subtitle.part1')@choice('machines.index_machine_subtitle.part2', $statistics->count, ['machine_count' => $statistics->count])
    <strong>@moneyFormat($statistics->value)</strong>.
@endsection
@section('page-content')
    <collection-table-machines/>
@endsection
@else
@section('page-content')
    <div class="d-flex flex-column align-items-center">
        @svg('machine', 'icon-empty')
        <span>There is nothing but an empty workspace here.
            @if (Auth::user()->isAdministrator())
                Add a <a href="{{ URL::route('machines.create') }}">new machine</a> to your arsenal.
            @endif
        </span>
    </div>
@endsection
@endif
@endsection
