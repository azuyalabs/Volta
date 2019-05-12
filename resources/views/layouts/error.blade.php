<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link href="{{ asset('css/error.css') }}" rel="stylesheet">
</head>
<body>
<div class="full-height flex-center">
    <a href="/">
        <div class="logo" title="{{ config('app.name') }}"></div>
    </a>
    <div class="content">
        @yield('image')
        <div class="title">
            @yield('message')
        </div>
    </div>
</div>
</body>
</html>
