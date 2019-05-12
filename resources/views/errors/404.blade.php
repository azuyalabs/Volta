@extends('layouts.error')

@section('code', '404')
@section('title', __('Page Not Found'))

@section('image')
    @svg('404', 'icon-error')
@endsection

@section('message', __('Sorry, the page you are looking for seems to be lost.'))
