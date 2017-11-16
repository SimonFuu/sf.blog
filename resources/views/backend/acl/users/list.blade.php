@extends('backend.dashboard')
@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Users</h3>
                        <div class="box-tools"><a href="{{ route('adminAddUsers') }}" class="btn btn-sm btn-info"><strong>Add</strong></a></div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        {{--<div class="search-header">--}}
                            {{--{!! Form::open(['url' => route('adminUsers'), 'method' => '', 'class' => 'form-inline', 'role' => 'form']) !!}--}}
                            {{--<!-- class include {'form-horizontal'|'form-inline'} -->--}}
                                {{--<!--- Email Field --->--}}
                                {{--<div class="form-group form-group-sm">--}}
                                    {{--{!! Form::label('email', 'Email:', ['class' => 'control-label']) !!}--}}
                                    {{--{!! Form::email('email', null, ['class' => 'form-control']) !!}--}}
                                {{--</div>--}}

                                {{--<div class="form-group form-group-sm">--}}
                                    {{--<button class="btn btn-success btn-sm"><strong>Search</strong></button>--}}
                                {{--</div>--}}
                            {{--{!! Form::close() !!}--}}
                            {{--<hr>--}}
                        {{--</div>--}}
                        <table class="table table-hover text-center">
                            <tbody>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user -> id }}</td>
                                        <td>{{ $user -> username }}</td>
                                        <td>{{ $user -> name }}</td>
                                        <td>{{ $user -> email }}</td>
                                        <td>
                                            <a href="{{ route('adminEditUsers', ['id' => $user -> id]) }}"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('adminDeleteUsers', ['id' => $user -> id]) }}"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {{ $users -> links() }}
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
