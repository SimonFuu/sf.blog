@extends('layouts.layouts')
@section('body')
    <div class="overlay dark-2"></div>
    <div class="player" id="player">
        <video id="video-container" preload="auto" loop>
            <source src="{{ config('app.storage_host') }}/storage/videos/common/Ed Sheeran - Shape Of You ( cover by J.Fla ).mp4" type="video/mp4">
            Your browser does not support the <code>video</code> element.
        </video>
    </div>
    <div class="display-table">
        <div class="user-info text-right">
            @if(Auth::check())
                <span>{{ Auth::user() -> name }}</span>
                <span><a href="{{ route('adminIndex') }}" target="_blank">Dashboard</a></span>
                <span><a href="{{ route('doSignOut') }}"><i class="fa fa-sign-out" aria-hidden="true"></i></a></span>
            @endif
        </div>
        <div class="text-center main-welcome">
            <div class="title m-b-md">
                Welcome
            </div>

            <div class="links">

                @foreach(Cache::get('SITE_CATALOGS')['index'] as $catalog)
                    <a href="{{ url($catalog['action']) }}">{{ $catalog['name'] }}</a>
                @endforeach
                {{--<a href="/tail">Lovely Tail</a>--}}
                @if(!Auth::check())
                    <a href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                @endif
            </div>
            <div class="links contact-me">
                @if(isset(Cache::get('SETTINGS')['SITE_GITHUB']))
                    <a href="{{ Cache::get('SETTINGS')['SITE_GITHUB'] }}" target="_blank">
                        <i class="fa fa-github" aria-hidden="true"></i> GITHUB
                    </a>
                @endif
                @if(isset(Cache::get('SETTINGS')['SITE_WEIBO']))
                    <a href="{{ Cache::get('SETTINGS')['SITE_WEIBO'] }}" target="_blank">
                        <i class="fa fa-weibo" aria-hidden="true"></i> WEIBO
                    </a>
                @endif
                @if(isset(Cache::get('SETTINGS')['SITE_EMAIL']))
                    <a href="mailto:{{ Cache::get('SETTINGS')['SITE_EMAIL'] }}"><i class="fa fa-envelope-o" aria-hidden="true"></i> E-mail</a>
                @endif
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