@extends('backend.dashboard')
@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box {{ is_null($user) ? 'box-info' : 'box-primary' }}">
                    <div class="box-header">
                        <h3 class="box-title">{{ is_null($user) ? 'Add User' : 'Edit User' }}</h3>
                    </div>
                    <!-- /.box-header -->

                {!! Form::open(['url' => route('adminStoreUsers'), 'method' => 'POST', 'class' => 'form-horizontal', 'user' => 'form']) !!}
                <!-- class include {'form-horizontal'|'form-inline'} -->
                    <div class="box-body table-responsive no-padding">
                        <div class="col-xs-8">
                            <!--- Username Field --->
                            <div class="form-group {{ $errors -> has('username') ? 'has-error' : ''}}">
                                {!! Form::label('username', 'Username', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('username', is_null($user) ? null : $user -> username, ['class' => 'form-control']) !!}
                                    @if($errors -> has('username'))
                                        <span class="help-block"><strong>{{ $errors -> first('username') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!--- Name Field --->
                            <div class="form-group {{ $errors -> has('name') ? 'has-error' : ''}}">
                                {!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('name', is_null($user) ? null : $user -> name, ['class' => 'form-control']) !!}
                                    @if($errors -> has('name'))
                                        <span class="help-block"><strong>{{ $errors -> first('name') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!--- Email Field --->
                            <div class="form-group {{ $errors -> has('email') ? 'has-error' : ''}}">
                                {!! Form::label('email', 'E-mail', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::email('email', is_null($user) ? null : $user -> email, ['class' => 'form-control']) !!}
                                    @if($errors -> has('email'))
                                        <span class="help-block"><strong>{{ $errors -> first('email') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!--- Password Field --->
                            <div class="form-group {{ $errors -> has('password') ? 'has-error' : ''}}">
                                {!! Form::label('password', 'Password', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                    @if($errors -> has('password'))
                                        <span class="help-block"><strong>{{ $errors -> first('password') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!--- Password Field --->
                            <div class="form-group {{ $errors -> has('password') ? 'has-error' : ''}}">
                                {!! Form::label('password_conformation', 'Reenter password', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <!--- Roles Field --->
                            <div class="form-group {{ $errors -> has('roles') ? 'has-error' : ''}}">
                                {!! Form::label('roles', 'Roles', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    <div class="user-roles-list">
                                        @foreach($roles as $role)
                                            <div class="col-sm-4">
                                                <table class="table table-bordered table-condensed user-roles-list-table">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <label>
                                                                @if(is_null($user))
                                                                    <input type="checkbox" name="roles[]" value="{{ $role -> id }}">&nbsp;&nbsp;{{ $role -> roleName }}
                                                                @else
                                                                    <input type="checkbox" name="roles[]" value="{{ $role -> id }}" {{ isset($user -> rid[$role -> id]) ? 'checked' : ''}}>&nbsp;&nbsp;{{ $role -> roleName }}
                                                                @endif
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($errors -> has('roles'))
                                        <span class="help-block"><strong>{{ $errors -> first('roles') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            @if(!is_null($user))
                                <input type="hidden" name="id" value="{{ $user -> id }}">
                            @endif
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-8">
                            <a href="{{ route('adminRoles') }}" class="btn btn-sm btn-default">Back</a>
                            <button class="pull-right btn {{ is_null($user) ? 'btn-info' : 'btn-primary' }}" type="submit">Submit</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection