@extends('layouts.blog')
@section('main')
    <div class="markdown-body">
        {!! $about -> body !!}
    </div>
    <script>
        var sid = '{{ $about -> sid }}'
    </script>
@endsection