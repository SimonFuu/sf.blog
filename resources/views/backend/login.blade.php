@extends('layouts.admin.layouts')
@section('body')
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ route('index') }}" target="_blank"><b>Simon's</b> Blog</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                @if (session('success'))
                    <div class="form-group">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">
                                &times;
                            </button>
                            {!! session('success') !!}
                        </div>
                    </div>
                @elseif (session('error'))
                    <div class="form-group">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">
                                &times;
                            </button>
                            {{ session('error') }}
                        </div>
                    </div>
                @else
                    <p class="login-box-msg">Sign in to start your session</p>
                @endif
                <form action="{{ route('doSignIn') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group has-feedback {{ $errors -> has('username') ? 'has-error' : '' }}">
                        <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}">
                        <span class="fa fa-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback {{ $errors -> has('username') ? 'has-error' : '' }}">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <span class="fa fa-lock form-control-feedback"></span>
                        @if($errors -> has('username'))
                            <span class="help-block">
                                <strong>{{ $errors -> first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-xs-8">

                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
    </body>
@endsection