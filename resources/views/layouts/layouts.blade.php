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
    @if(env('APP_ENV') === 'local')
    <link rel="stylesheet" href="/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css?v={{ time() }}">
    @else
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ env('APP_CDN_HOST') }}/css/style.css?v={{ env('APP_STATIC_FILE_VERSION') }}">
    @endif

</head>
<body>
    @yield('body')

<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
@if(env('APP_ENV') === 'local')
<script src="/js/bootstrap.min.js"></script>
<script src="/plugins/jquery.youtube.background.js"></script>
<script src="/js/functions.js?v={{ time() }}"></script>
@else
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{ env('APP_CDN_HOST') }}/plugins/jquery.youtube.background.js"></script>
<script src="{{ env('APP_CDN_HOST') }}/js/functions.js?v={{ env('APP_STATIC_FILE_VERSION') }}"></script>
@endif
</body>
</html>