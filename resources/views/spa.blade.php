<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{mix('css/app.css')}}" rel="stylesheet">

    <title>{{ config('app.name') }}</title>
</head>
<body class="h-full">
<div id="app">
    @yield('content')
</div>

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast fade hide" role="alert" id="toastAlertSuccess" aria-live="assertive" aria-atomic="true">
        <div class="toast-body"></div>
    </div>

    <div class="toast fade hide" role="alert" id="toastAlertInfo" aria-live="assertive" aria-atomic="true">
        <div class="toast-body"></div>
    </div>

    <div class="toast fade hide" role="alert" id="toastAlertDanger" aria-live="assertive" aria-atomic="true">
        <div class="toast-body"></div>
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
