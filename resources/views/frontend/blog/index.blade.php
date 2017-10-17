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
                {{ $amount }} item(s) found.
            </p>
        </div>
    </div>
    <div class="blog-archives">
        @foreach($archives as $archive)
            <div class="blog-archive-block">
                <div class="blog-archive-title">
                    <h2><a href="/blog/archive/{{ $archive -> id }}">{{ $archive -> title }}</a></h2>
                </div>
                <div class="blog-archive-content">
                    <span>{{ $archive -> body }}</span>
                </div>
                <div class="blog-archive-read-more">
                    <a href="/blog/archive/{{ $archive -> id }}">Read more</a>
                </div>
                <div class="blog-archive-category-and-publish text-right">
                    <i>in {{ $archive -> name }} | <span class="numbers">{{ $archive -> publishAt }}</span></i>
                </div>
            </div>
        @endforeach
    </div>

    <section class="blog-pagination text-right">
        {{ $archives -> links() }}
    </section>
@endsection
