@extends('frontend.layouts.layouts')
@section('body')
    <div class="overlay dark-5"><!-- dark overlay [0 to 9 opacity] --></div>
    <div class="slider-video">
        <video preload="auto" loop autoplay muted>
            <source src="/storage/files/videos/Jack-Broadbent.mp4" type="video/mp4">
            Your browser does not support the <code>video</code> element.
        </video>
    </div>
    <div class="display-table">
        <div class="container">
            <div class="text-center">
                <div class="content">
                    <div class="title m-b-md">
                        Welcome
                    </div>

                    <div class="links">
                        <a href="/blog">Blog</a>
                        <a href="http://weibo.com/apenggg" target="_blank"><i class="fa fa-weibo" aria-hidden="true"></i> 微博</a>
                        <a href="javascript:;"><i class="fa fa-wechat" aria-hidden="true"></i> 微信</a>
                        <a href="mailto:contact@fushupeng.com"><i class="fa fa-envelope-o" aria-hidden="true"></i> E-mail</a>
                        <a href="/tail">Lovely Tail</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="video-volume text-center">
            <a href="javascript:;" id="video-volume" data-volume="0">
                <i class="fa fa-volume-off" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection