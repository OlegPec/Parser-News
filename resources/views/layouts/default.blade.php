<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

{{--    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@19.8.0/dist/css/suggestions.min.css" rel="stylesheet">--}}
    <link rel="icon" type="image/ico" href="{{asset('images/favicon.ico')}}">
{{--    <style>
        .card-columns {
            column-count: 2;
        }
    </style>--}}
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">




</head>

<body>
    <div class="wrapper">
        @yield('content')
    </div>
</body>
</html>

