@extends('layouts.default')

@section('page')
@section('title')
    {{ trans_choice('spools.model_name', 2) }}
@endsection
@section('subtitle')
    @lang('spools.index_spool_subtitle.part1')@choice('spools.index_spool_subtitle.part2', $statistics->count, ['spool_count' => $statistics->count])
    <strong>@moneyFormat($statistics->value)</strong>.
@endsection
@section('page-content')
    <collection-table-filamentspools/>
@endsection
@endsection
