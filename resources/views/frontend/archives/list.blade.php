@extends('layouts.blog')
@section('main')
    <div class="jumbotron blog-category-header">
        <div class="blog-categories-header">
            <h3>
                <code>
                    {{ $header }}
                </code>
            </h3>
            <p>
                <code>Notice: {{ count($archives) }} item(s) found.</code>
            </p>
        </div>
    </div>
    <div class="blog-archives">
        @foreach($archives as $archive)
            <div class="blog-archive-block">
                <div class="blog-archive-title">
                    @if($archive -> isTop)
                        <span><i class="glyphicon glyphicon-pushpin" aria-hidden="true"></i></span>
                    @endif
                    <span class="archives-list-title"><a href="{{ url('archive', $archive -> sid) }}">{{ $archive -> title }}</a></span>                </div>
                <div class="blog-archive-content">
                    @if($archive -> thumb)
                        <div class="blog-archive-thumb">
                            <img src="{{ config('app.storage_host') . $archive -> thumb }}" alt="" width="100%">
                        </div>
                    @endif
                    <span>{{ $archive -> body }}</span>
                </div>
                <div class="blog-archives-list-archive-footer row">
                    <div class="col-sm-6 text-left">
                        <a class="archive-read-more" href="{{ url('archive', $archive -> sid) }}">Read more &gt;&gt;</a>
                    </div>
                    <div class="col-sm-6 text-right">
                        <i>in {{ $archive -> name }} | <span class="numbers">{{ $archive -> createdAt }}</span></i>
                    </div>
                </div>
                <div class="blog-archive-read-more">

                </div>
                <div class="blog-archive-category-and-publish">
                </div>
            </div>
        @endforeach
    </div>

    <section class="blog-pagination text-right">
        {{ $archives -> links() }}
    </section>
@endsection
