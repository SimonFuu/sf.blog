@extends('layouts.blog')
@section('main')
    <table class="table table-hover">
        @foreach($towns as $town)
            <tr>
                <td width="200"><b>{{ $town['name'] }}</b></td>
                <td width="400"></td>
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