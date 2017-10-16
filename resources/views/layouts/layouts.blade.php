<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="stylesheet" href="{{ env('APP_STATIC_FILE_SERVER') }}/css/app.css">
    <link rel="stylesheet" href="{{ env('APP_STATIC_FILE_SERVER') }}/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ env('APP_STATIC_FILE_SERVER') }}/css/style.css?v={{ env('APP_DEBUG') ? time() : env('APP_STATIC_FILE_VERSION') }}">
    <script src="{{ env('APP_STATIC_FILE_SERVER') }}/js/app.js"></script>
    <script src="/plugins/jquery.youtube.background.js"></script>
</head>
<body>
    @yield('body')
<script src="{{ env('APP_STATIC_FILE_SERVER') }}/js/functions.js?v={{ env('APP_DEBUG') ? time() : env('APP_STATIC_FILE_VERSION') }}"></script>
</body>
</html>