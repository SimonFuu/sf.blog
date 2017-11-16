<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ isset($archive) && !(isset($archives)) ? $archive -> title .' - ': ''}}{{ Cache::get('SETTINGS')['SITE_TITLE'] }}</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="{{ Cache::get('SETTINGS')['SITE_KEYWORDS'] }}">
    <meta name="description" content="{{ Cache::get('SETTINGS')['SITE_DESCRIPTION'] }}">
    @if(env('APP_ENV') === 'local')
    <link rel="stylesheet" href="/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/plugins/bootstrap-3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/plugins/github-markdown-css/github-markdown-css.css">
    <link rel="stylesheet" href="/css/style.css?v={{ time() }}">
    @else
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/github-markdown-css/2.8.0/github-markdown.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ config('app.cdn') }}/css/style.css?v={{ env('APP_STATIC_FILE_VERSION') }}">
    @endif

</head>
<body>
@yield('body')
<div class="modal fade" id="loginModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => route('doSignIn'), 'method' => 'POST', 'class' => 'form-horizontal login-form', 'role' => 'form']) !!}
                    <!-- class include {'form-horizontal'|'form-inline'} -->
                    <!--- Username Field --->
                    <div class="form-group">
                        {!! Form::label('username', 'Username', ['class' => 'control-label']) !!}
                        {!! Form::text('username', null, ['class' => 'form-control']) !!}
                    </div>
                    <!--- Password Field --->
                    <div class="form-group">
                        {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group text-right">
                        <button class="btn btn-sm btn-info">Log in</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
@if(env('APP_ENV') === 'local')
<script src="/plugins/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script src="/plugins/jquery.youtube.background.js"></script>
<script src="/js/functions.js?v={{ time() }}"></script>
@else
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{ config('app.cdn') }}/plugins/jquery.youtube.background.js"></script>
<script src="{{ config('app.cdn') }}/js/functions.js?v={{ env('APP_STATIC_FILE_VERSION') }}"></script>
@endif
</body>
</html>