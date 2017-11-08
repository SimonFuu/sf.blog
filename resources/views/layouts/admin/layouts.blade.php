<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Backend - {{ Cache::get('SETTINGS')['SITE_TITLE'] }}</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(env('APP_ENV') === 'local')
    <link rel="stylesheet" href="/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/plugins/bootstrap-3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/admin/plugins/AdminLTE/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/admin/plugins/AdminLTE/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="/admin/plugins/jQuery-File-Upload-9.19.0/css/jquery.fileupload.css">
    <link rel="stylesheet" href="/admin/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/admin/plugins/bootstrap-fileinput-4.4.5/css/fileinput.min.css">
    <link rel="stylesheet" href="/admin/plugins/bootstrap-datetimepicker-4.17.47/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="/admin/css/style.css?v={{ time() }}">
    @else
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://cdn.bootcss.com/admin-lte/2.4.2/css/AdminLTE.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/admin-lte/2.4.2/css/skins/_all-skins.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/blueimp-file-upload/9.19.0/css/jquery.fileupload.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/css/fileinput.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ config('app.cdn') }}/admin/css/style.css?v={{ env('APP_STATIC_FILE_VERSION') }}">
    @endif
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
@yield('body')
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
@if(env('APP_ENV') === 'local')
<script type="text/javascript" src="/plugins/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/admin/plugins/moment.min.js"></script>
<script type="text/javascript" src="/admin/plugins/AdminLTE/js/adminlte.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script type="text/javascript" src="/admin/plugins/jQuery-File-Upload-9.19.0/js/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script type="text/javascript" src="/admin/plugins/jQuery-File-Upload-9.19.0/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script type="text/javascript" src="/admin/plugins/jQuery-File-Upload-9.19.0/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="/admin/plugins/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="/admin/plugins/bootstrap-fileinput-4.4.5/js/fileinput.js"></script>
<script type="text/javascript" src="/admin/plugins/bootstrap-fileinput-4.4.5/themes/fa/theme.min.js"></script>
<script type="text/javascript" src="/admin/plugins/bootstrap-datetimepicker-4.17.47/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/admin/js/functions.js?v={{ time() }}"></script>
@else
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/moment.min.js"></script>
<script src="https://cdn.bootcss.com/admin-lte/2.4.2/js/adminlte.min.js"></script>
<script src="https://cdn.bootcss.com/blueimp-file-upload/9.19.0/js/vendor/jquery.ui.widget.min.js"></script>
<script src="https://cdn.bootcss.com/blueimp-file-upload/9.19.0/js/jquery.iframe-transport.min.js"></script>
<script src="https://cdn.bootcss.com/blueimp-file-upload/9.19.0/js/jquery.fileupload.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.5/themes/fa/theme.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{ config('app.cdn') }}/jsadmin/functions.js?v={{ env('APP_STATIC_FILE_VERSION') }}"></script>
@endif
</body>
</html>