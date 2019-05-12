@extends('layouts.error')

@section('code', '500')
@section('title', __('Internal Server Error'))

@section('image')
    @svg('500', 'icon-error')
@endsection

@section('message', __('It\'s not you, it is us...Something went topsy-turvy.'))
