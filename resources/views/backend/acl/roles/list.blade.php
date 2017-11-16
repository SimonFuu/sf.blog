@extends('backend.dashboard')
@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Roles</h3>
                        <div class="box-tools"><a href="{{ route('adminAddRoles') }}" class="btn btn-sm btn-info"><strong>Add</strong></a></div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        {{--<div class="search-header">--}}
                            {{--{!! Form::open(['url' => route('adminRoles'), 'method' => '', 'class' => 'form-inline', 'role' => 'form']) !!}--}}
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
                                    <th>Role</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role -> id }}</td>
                                    <td>{{ $role -> roleName }}</td>
                                    <td>{{ $role -> description }}</td>
                                    <td>
                                        <a href="{{ route('adminEditRoles', ['id' => $role -> id]) }}"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('adminDeleteRoles', ['id' => $role -> id]) }}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {{ $roles -> links() }}
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
