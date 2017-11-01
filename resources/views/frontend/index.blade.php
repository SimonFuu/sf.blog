@extends('layouts.layouts')
@section('body')
    <div class="overlay dark-2"></div>
    <div class="player" id="player">
        <video id="video-container" preload="auto" loop>
            <source src="{{ config('app.storage_host') }}/storage/videos/Jack-Broadbent.mp4" type="video/mp4">
            Your browser does not support the <code>video</code> element.
        </video>
    </div>
    {{--<section class="display-table">--}}
        {{--<div class="container">--}}
            {{--<div class="user-info text-right">--}}
                {{--@if(Auth::check())--}}
                    {{--<span>{{ Auth::user() -> name }}</span>--}}
                    {{--<span><a href="{{ route('adminIndex') }}" target="_blank">Dashboard</a></span>--}}
                    {{--<span><a href="{{ route('doSignOut') }}"><i class="fa fa-sign-out" aria-hidden="true"></i></a></span>--}}
                {{--@endif--}}
            {{--</div>--}}
            {{--<div class="main text-center" style="height:50%;margin-top: 150px">--}}
                {{--dsada--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="video-volume text-center">--}}
            {{--<a href="javascript:;" id="video-volume" data-volume="0" data-video-id="i-lA5nAZvII">--}}
                {{--<i class="fa fa-volume-off" aria-hidden="true"></i>--}}
            {{--</a>--}}
        {{--</div>--}}
    {{--</section>--}}
    <div class="display-table">
        <div class="container">
            <div class="user-info text-right">
                @if(Auth::check())
                    <span>{{ Auth::user() -> name }}</span>
                    <span><a href="{{ route('adminIndex') }}" target="_blank">Dashboard</a></span>
                    <span><a href="{{ route('doSignOut') }}"><i class="fa fa-sign-out" aria-hidden="true"></i></a></span>
                @endif
            </div>
            <div class="text-center main-welcome">
                <div class="content">
                    <div class="title m-b-md">
                        Welcome
                    </div>

                    <div class="links">
                        <a href="/blog">Blog</a>
                        <a href="/resume">Resume</a>
                        {{--<a href="/tail">Lovely Tail</a>--}}
                        @if(!Auth::check())
                            <a href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                        @endif
                    </div>
                    <div class="links contact-me">
                        <a href="https://github.com/simonfuu" target="_blank"><i class="fa fa-github" aria-hidden="true"></i> GITHUB</a>
                        <a href="http://weibo.com/apenggg" target="_blank"><i class="fa fa-weibo" aria-hidden="true"></i> WEIBO</a>
                        <a href="mailto:contact@fushupeng.com"><i class="fa fa-envelope-o" aria-hidden="true"></i> E-mail</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="video-volume text-center">
            <a href="javascript:;" id="video-volume" data-volume="0" data-video-id="i-lA5nAZvII">
                <i class="fa fa-volume-off" aria-hidden="true"></i>
            </a>
        </div>
        <div class="footer text-center">
            @include('layouts.footer')
        </div>
    </div>
    <div class="gfwBlockCheck hidden"></div>
@endsection