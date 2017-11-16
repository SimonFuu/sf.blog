@extends('layouts.blog')
@section('main')
    <div class="markdown-body">
        {!! $resume -> body !!}
    </div>
@endsection