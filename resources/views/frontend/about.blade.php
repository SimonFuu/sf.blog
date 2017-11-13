@extends('layouts.blog')
@section('main')
    <div class="markdown-body">
        {!! $about -> body !!}
    </div>
@endsection