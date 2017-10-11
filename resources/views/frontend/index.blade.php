@extends('layouts.layouts')
@section('body')
    <div class="overlay dark-2"></div>
    <div class="player" id="player">
        <video id="video-container" preload="auto" loop>
            <source src="/storage/videos/Jack-Broadbent.mp4" type="video/mp4">
            Your browser does not support the <code>video</code> element.
        </video>
    </div>
    <div class="display-table">
        <div class="container">
            <div class="user-info text-right">
                @if(Auth::check())
                    <span><a href="/manage">控制台</a></span>
                    <span>付淑鹏</span> {{--{{ Auth::user() -> name  }}--}}
                    <span><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                @endif
            </div>
            <div class="text-center main-welcome">
                <div class="content">
                    <div class="title m-b-md">
                        Welcome
                    </div>

                    <div class="links">
                        <a href="/blog">Blog</a>
                        <a href="/tail">Lovely Tail</a>
                        @if(!Auth::check())
                            <a href="/login">Login</a>
                        @endif
                    </div>
                    <div class="links contact-me">
                        <a href="http://weibo.com/apenggg" target="_blank"><i class="fa fa-weibo" aria-hidden="true"></i> 微博</a>
                        <a href="javascript:;"><i class="fa fa-wechat" aria-hidden="true"></i> 微信</a>
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
    </div>
    <div class="gfwBlockCheck hidden"></div>
@endsection