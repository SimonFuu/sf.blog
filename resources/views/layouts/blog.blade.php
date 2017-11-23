@extends('layouts.layouts')
@section('body')
<div class="logined-user-info text-right">
    @if(Auth::check())
        <span>{{ Auth::user() -> name }}</span>
        <span><a href="{{ route('adminIndex') }}" target="_blank">Dashboard</a></span>
        <span><a href="{{ route('doSignOut') }}"><i class="fa fa-sign-out" aria-hidden="true"></i></a></span>
    @endif
</div>
<div class="blog-main">
    <div class="col-md-3 col-sm-3 col-lg-2">
        @include('layouts.left')
    </div>

    <div class="col-md-9 col-sm-9 col-lg-8">
        <section class="blog-right-section">
            @yield('main')
        </section>
        <hr>
        @include('layouts.footer')
    </div>

    <div class="col-lg-2 archive-detail-right">123
        @include('layouts.right')
    </div>
</div>

<!-- reword Modal -->
<div class="modal fade" id="rewordModal" tabindex="-1" role="dialog" aria-labelledby="rewordModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="reword-header text-center">
                    <i class="fa fa-quote-left fa-2x" aria-hidden="true"></i>
                    <span>&nbsp;&nbsp;Thank you!&nbsp;&nbsp;</span>
                    <i class="fa fa-quote-right fa-2x" aria-hidden="true"></i>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <div><img src="{{ config('app.storage_host') }}/storage/images/common/qr-alipay.png" width="200" alt=""></div>
                        <div class="reword-options"><img src="{{ config('app.storage_host') }}/storage/images/common/alipay.png" height="50" alt=""></div>
                    </div>
                    <div class="col-sm-6 text-center">
                        <div><img src="{{ config('app.storage_host') }}/storage/images/common/qr-wechat.png" width="200" alt=""></div>
                        <div class="reword-options"><img src="{{ config('app.storage_host') }}/storage/images/common/wechat-pay.png" height="50" alt=""></div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection