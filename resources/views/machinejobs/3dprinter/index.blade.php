@extends('layouts.default')

@section('page')
@section('title')
    {{ trans_choice('machinejobs/3dprinterjobs.model_name', 2) }}
@endsection
@section('subtitle')
    @lang('machinejobs/3dprinterjobs.index_3dprinterjob_subtitle')

@endsection
@section('metrics')
    <div>
        <div class="row">
            <div class="col-4">
                <pie-chart></pie-chart>
            </div>
            <div class="col-8">
                <heat-map></heat-map>
            </div>
        </div>
    </div>
@endsection
@section('page-content')
    <three-d-printer-jobs/>
@endsection
@endsection
