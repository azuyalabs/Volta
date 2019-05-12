@extends('layouts.error')

@section('code', '403')
@section('title', __('Forbidden'))

@section('image')
    @svg('403', 'icon-error')
@endsection

@section('message', __('Sorry, this page is off limits.'))
