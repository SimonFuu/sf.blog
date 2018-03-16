@extends('layouts.blog')
@section('main')
    <section class="blog-body">
        <div class="blog-archive-detail-title">
            <h2>{{ $archive -> title }}</h2>
            <span class="blog-archive-category-and-publish"><i>in {{ $archive -> name }} | {{ $archive -> createdAt }}</i></span>
        </div>

        <div class="blog-archive-detail-body">
            <div class="markdown-body">
                @if($archive -> thumb)
                    <div class="blog-archive-thumb">
                        <img src="{{ config('app.storage_host') . $archive -> thumb }}" alt="" width="100%">
                    </div>
                @endif
                {!! $archive -> body !!}
            </div>
        </div>

        <div class="blog-archive-detail-addons blog-archive-detail-reword text-center">
            <span class="page-reword-button">
                <strong>赏</strong>
            </span>
        </div>
        @if($archive -> isOriginal)
            <div class="original-declare">
                <p>本文作者： <a href="{{ config('app.url') }}">Simon Fu</a></p>
                <p>本文标题： <a href="{{ config('app.url') . '/archive/' . $archive -> sid }}">{{ $archive -> title }}</a></p>
                <p>本文链接： <a href="{{ config('app.url') . '/archive/' . $archive -> sid }}">{{ config('app.url') . '/archive/' . $archive -> sid }}</a></p>
                <p>发布时间：{{ $archive -> createdAt }}</p>
                <p>版权声明： 本文由 <code>Simon Fu</code> 原创，采用<a rel="license" href="https://creativecommons.org/licenses/by-nc-nd/4.0/deed.zh">知识共享署名-非商业性使用-禁止演绎 4.0 国际许可协议</a>进行许可。
                <p>转载请保留以上声明信息！</p>
            </div>
        @endif
        <div class="blog-archive-detail-addons blog-archive-detail-others">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 text-left">
                    @if(!is_null($archive -> prepArchive))
                        <a href="{{ url('archive', $archive -> prepArchive -> sid) }}">
                            <i class="fa fa-angle-double-left" aria-hidden="true"></i>

                            {{ $archive -> prepArchive -> title }}
                        </a>
                    @endif
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 text-right">
                    @if(!is_null($archive -> nextArchive))
                        <a href="{{ url('archive',$archive -> nextArchive -> sid) }}">
                            {{ $archive -> nextArchive -> title }}
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        @include('frontend.archives.common.comment')
    </section>

    <script>
        var sid = '{{ $archive -> sid }}'
    </script>
@endsection
