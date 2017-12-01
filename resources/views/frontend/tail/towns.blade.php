@extends('layouts.blog')
@section('main')
    <table class="table">
        @foreach($towns as $town)
            <tr>
                <td><b>{{ $town['name'] }}</b></td>
                <td></td>
            </tr>
            @if($town['subs'])
                @foreach($town['subs'] as $subs)
                    <tr>
                        <td></td>
                        <td>{{ $subs['name'] }}</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
    </table>
@endsection