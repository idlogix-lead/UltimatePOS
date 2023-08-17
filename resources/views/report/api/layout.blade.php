<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css?v='.$asset_v) }}">
    @include('layouts.partials.css')
</head>
<body>
    @yield('content')
    {{-- @include("report.partials.api.style") --}}
</body>
</html>
