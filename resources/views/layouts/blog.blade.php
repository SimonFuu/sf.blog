@extends('layouts.layouts')
@section('body')
<div class="blog-main">
    <div class="col-md-3 col-sm-3 col-lg-2">
        @include('layouts.left')
    </div>

    <div class="col-md-6 col-sm-6 col-lg-8">
        <section class="blog-right-section">
            @yield('main')
        </section>
        @include('layouts.footer')
    </div>

    <div class="col-md-3 col-sm-3 col-lg-2">
        @include('layouts.right')
    </div>
</div>

@endsection