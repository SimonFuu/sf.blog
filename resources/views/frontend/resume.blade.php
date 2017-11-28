@extends('layouts.blog')
@section('main')
    <div class="markdown-body">
        {!! $resume -> body !!}
    </div>
    <script>
        var sid = '{{ $resume -> sid }}'
    </script>
@endsection