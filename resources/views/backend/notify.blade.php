@extends('backend.dashboard')
@section('main')
    <div class="container">
        <a href="{{ redirect() -> back() -> getTargetUrl() }}" class="btn btn-default">Back</a>
    </div>
@endsection