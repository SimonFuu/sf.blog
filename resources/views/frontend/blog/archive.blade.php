@extends('layouts.blog')
@section('main')
    <section class="blog-body">
        <div class="blog-archive-detail-title">
            <h1>{{ $archive -> title }}</h1>
            <span class="blog-archive-category-and-publish"><i>in {{ $archive -> name }} | {{ $archive -> publishAt }}</i></span>
        </div>

        <div class="blog-archive-detail-body">
            {!! $archive -> body !!}
        </div>

        <div class="blog-archive-detail-addons blog-archive-detail-others">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 text-left">
                    @if(!is_null($archive -> prepArchive))
                        <a href="/blog/archive/{{ $archive -> prepArchive -> id }}">
                            <i class="fa fa-angle-double-left" aria-hidden="true"></i>

                            {{ $archive -> prepArchive -> title }}
                        </a>
                    @else
                        Null
                    @endif
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 text-right">
                    @if(!is_null($archive -> nextArchive))
                        <a href="/blog/archive/{{ $archive -> nextArchive -> id }}">
                            {{ $archive -> nextArchive -> title }}
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        </a>
                    @else
                        Null
                    @endif
                </div>
            </div>
        </div>

        <div class="blog-archive-detail-addons blog-archive-detail-reword text-center">
            <span class="page-reword-button">
                <strong>赏</strong>
            </span>
        </div>
    </section>
@endsection
