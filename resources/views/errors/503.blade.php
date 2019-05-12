@extends('layouts.error')

@section('code', '503')
@section('title', __('Service Unavailable'))

@section('image')
    @svg('503', 'icon-error')
@endsection

@section('message', __('Sorry, we are doing some maintenance. Please check back soon.'))
