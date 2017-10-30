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

                    {!! Form::open(['url' => route('adminStoreUsers'), 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                    <!-- class include {'form-horizontal'|'form-inline'} -->
                        <div class="box-body table-responsive no-padding">
                            <div class="col-xs-8">
                                <!--- Name Field --->
                                <div class="form-group {{ $errors -> has('userName') ? 'has-error' : ''}}">
                                    {!! Form::label('userName', '名称', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('userName', is_null($user) ? null : $user -> userName, ['class' => 'form-control']) !!}
                                        @if($errors -> has('userName'))
                                            <span class="help-block"><strong>{{ $errors -> first('userName') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!--- Url Field --->
                                <div class="form-group {{ $errors -> has('url') ? 'has-error' : ''}}">
                                    {!! Form::label('url', 'Url', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('url', is_null($user) ? null : $user -> url, ['class' => 'form-control']) !!}
                                        @if($errors -> has('url'))
                                            <span class="help-block"><strong>{{ $errors -> first('url') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!--- Icon Field --->
                                <div class="form-group {{ $errors -> has('icon') ? 'has-error' : ''}}">
                                    {!! Form::label('icon', '图标', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        <button class="btn btn-default btn-sm set-user-icon" type="button" data-toggle="modal" data-target="#setUserIconModal">
                                            <i class="fa {{ is_null($user) ? 'fa-circle-o' : $user -> icon }}" aria-hidden="true"></i>
                                        </button>
                                        <i class="fa fa-hand-o-left" aria-hidden="true"></i> 请点击选择图标
                                        <input class="set-user-icon-value" type="hidden" name="icon" value="{{ is_null($user) ? 'fa-circle-o' : $user -> icon }}">
                                        @if($errors -> has('icon'))
                                            <span class="help-block"><strong>{{ $errors -> first('icon') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!--- ParentId Field --->
                                <div class="form-group {{ $errors -> has('parentId') ? 'has-error' : ''}}">
                                    {!! Form::label('parentId', '父级菜单', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('parentId', $menus, is_null($user) ? null : $user -> parentId, ['class' => 'form-control']) !!}
                                        @if($errors -> has('parentId'))
                                            <span class="help-block"><strong>{{ $errors -> first('parentId') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!--- Users Field --->
                                <div class="form-group {{ $errors -> has('users') ? 'has-error' : ''}}">
                                    {!! Form::label('Users', '权限', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        @if(!is_null($user))
                                            @php
                                                $urls = json_decode($user -> users, true);
                                                $urls = (implode("\r\n", ($urls ? $urls : [])));
                                            @endphp
                                        @endif
                                        {!! Form::textarea('users', is_null($user) ? null : $urls, ['class' => 'form-control', 'rows' => 5, 'placeholder' => '菜单权限，一行一个，以"/"开始']) !!}
                                        @if($errors -> has('users'))
                                            <span class="help-block"><strong>{{ $errors -> first('users') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!--- Description Field --->
                                <div class="form-group {{ $errors -> has('description') ? 'has-error' : ''}}">
                                    {!! Form::label('description', '描述', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::textarea('description', is_null($user) ? null : $user -> description, ['class' => 'form-control', 'rows' => 5]) !!}
                                        @if($errors -> has('description'))
                                            <span class="help-block"><strong>{{ $errors -> first('description') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!--- Weight Field --->
                                <div class="form-group {{ $errors -> has('weight') ? 'has-error' : ''}}">
                                    {!! Form::label('weight', '权重', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::number('weight', is_null($user) ? 100 : $user -> weight, ['class' => 'form-control']) !!}
                                        @if($errors -> has('weight'))
                                            <span class="help-block"><strong>{{ $errors -> first('weight') }}</strong></span>
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
                                <a href="{{ route('adminUsers') }}" class="btn btn-sm btn-default">Back</a>
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