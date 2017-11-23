@extends('layouts.blog')
@section('main')
    <div class="markdown-body">
        {!! $resume -> body !!}
    </div>
    <script>
        var sid = '{{ $about -> sid }}'
    </script>
@endsection