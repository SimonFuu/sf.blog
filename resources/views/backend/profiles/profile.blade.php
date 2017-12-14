@extends('backend.dashboard')
@section('main')
    <section class="content">
        <section class="content-header">
            <h1>
                User Profile
            </h1>
        </section>
        <div class="row">
            <div class="col-xs-4">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{ config('app.cdn') }}/admin/plugins/AdminLTE/img/avatar5.png" alt="User profile avatar">
                        <h3 class="profile-username text-center">{{ Auth::user() -> name }}</h3>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>ID</b> <a class="pull-right">{{ Auth::user() -> id }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Username</b> <a class="pull-right">{{ Auth::user() -> username }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>E-mail</b> <a class="pull-right">{{ Auth::user() -> email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Created at</b> <a class="pull-right">{{ Auth::user() -> createdAt }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Last update</b> <a class="pull-right">{{ Auth::user() -> updateAt }}</a>
                            </li>
                        </ul>
                        <button class="btn btn-primary btn-block edit-profile-btn" type="button"><b>Edit</b></button>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-xs-8">
                <div class="box profile-form-box box-default">
                    <!-- /.box-header -->
                    <div class="box-body box-profile edit-profile">
                        {!! Form::open(['url' => route('storeProfile'), 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                            <!-- class include {'form-horizontal'|'form-inline'} -->
                            <!--- Name Field --->
                            <div class="form-group">
                                {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                                {!! Form::text('name', Auth::user() -> name, ['class' => 'form-control disabled-item', 'disabled']) !!}
                            </div>
                            <!--- Email Field --->
                            <div class="form-group">
                                {!! Form::label('email', 'E-mail', ['class' => 'control-label']) !!}
                                {!! Form::text('email', Auth::user() -> email, ['class' => 'form-control disabled-item', 'disabled']) !!}
                            </div>
                            <!--- Password Field --->
                            <div class="form-group">
                                {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
                                {!! Form::password('password', ['class' => 'form-control disabled-item', 'disabled']) !!}
                            </div>
                            <!--- Password_confirmation Field --->
                            <div class="form-group">
                                {!! Form::label('password_confirmation', 'Reenter password', ['class' => 'control-label']) !!}
                                {!! Form::password('password_confirmation', ['class' => 'form-control disabled-item', 'disabled']) !!}
                            </div>
                            <div class="form-group">
                                <button class="btn btn-sm btn-default disabled-item cancel-edit-profile-btn" disabled type="button">Cancel</button>
                                <button class="pull-right btn btn-sm btn-primary disabled-item" disabled type="submit">Submit</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
