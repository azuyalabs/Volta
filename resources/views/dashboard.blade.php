<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
    <title>Dashboard - {{ config('app.name') }}</title>

    <link rel="dns-prefetch" href="//fonts.googleapis.com/">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Montserrat:400,600,900">

    <!-- Styles -->
    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">
</head>
<body>

<dashboard id="dashboard" columns="5" rows="3">
    @for ($i = 0; $i < 6; $i++)
        @php
            $position = $i % 2 == 0 ? 'a' : 'b';
            $position .= (int)($i/2) + 1;
        @endphp

        @if (!empty($machines[$i]))
            <printer position="{{ $position }}" id="{{ $machines[$i] }}"></printer>
        @else
            <placeholder position="{{ $position }}"></placeholder>
        @endif
    @endfor
    <firmware-releases position="c1"></firmware-releases>
    <volta position="c2"></volta>
    <slicer-releases position="c3"></slicer-releases>
    <clock position="d1"></clock>
    <placeholder position="d2"></placeholder>
    <holidays position="d3:e3"></holidays>
    <weather position="e1"></weather>
    <placeholder position="e2"></placeholder>
</dashboard>

<!-- Global Volta Object -->
<script>
    window.Volta = @json($voltaScriptVariables);
</script>

<!-- Scripts -->
<script src="{{ mix('js/dashboard.js') }}"></script>
</body>
</html>