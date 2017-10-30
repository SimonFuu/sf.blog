@extends('backend.dashboard')
@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box {{ is_null($action) ? 'box-info' : 'box-primary' }}">
                    <div class="box-header">
                        <h3 class="box-title">{{ is_null($action) ? 'Add Action' : 'Edit Action' }}</h3>
                    </div>
                    <!-- /.box-header -->

                    {!! Form::open(['url' => route('adminStoreActions'), 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                    <!-- class include {'form-horizontal'|'form-inline'} -->
                        <div class="box-body table-responsive no-padding">
                            <div class="col-xs-8">
                                <!--- Name Field --->
                                <div class="form-group {{ $errors -> has('actionName') ? 'has-error' : ''}}">
                                    {!! Form::label('actionName', 'Name', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('actionName', is_null($action) ? null : $action -> actionName, ['class' => 'form-control']) !!}
                                        @if($errors -> has('actionName'))
                                            <span class="help-block"><strong>{{ $errors -> first('actionName') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!--- Url Field --->
                                <div class="form-group {{ $errors -> has('url') ? 'has-error' : ''}}">
                                    {!! Form::label('url', 'Url', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('url', is_null($action) ? null : $action -> url, ['class' => 'form-control']) !!}
                                        @if($errors -> has('url'))
                                            <span class="help-block"><strong>{{ $errors -> first('url') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!--- Icon Field --->
                                <div class="form-group {{ $errors -> has('icon') ? 'has-error' : ''}}">
                                    {!! Form::label('icon', 'Icon', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        <button class="btn btn-default btn-sm set-action-icon" type="button" data-toggle="modal" data-target="#setActionIconModal">
                                            <i class="fa {{ is_null($action) ? 'fa-circle-o' : $action -> icon }}" aria-hidden="true"></i>
                                        </button>
                                        <i class="fa fa-hand-o-left" aria-hidden="true"></i> 请点击选择图标
                                        <input class="set-action-icon-value" type="hidden" name="icon" value="{{ is_null($action) ? 'fa-circle-o' : $action -> icon }}">
                                        @if($errors -> has('icon'))
                                            <span class="help-block"><strong>{{ $errors -> first('icon') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!--- ParentId Field --->
                                <div class="form-group {{ $errors -> has('parentId') ? 'has-error' : ''}}">
                                    {!! Form::label('parentId', 'Parent Menu', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('parentId', $menus, is_null($action) ? null : $action -> parentId, ['class' => 'form-control']) !!}
                                        @if($errors -> has('parentId'))
                                            <span class="help-block"><strong>{{ $errors -> first('parentId') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!--- Actions Field --->
                                <div class="form-group {{ $errors -> has('actions') ? 'has-error' : ''}}">
                                    {!! Form::label('Actions', 'Permissions', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        @if(!is_null($action))
                                            @php
                                                $urls = json_decode($action -> actions, true);
                                                $urls = (implode("\r\n", ($urls ? $urls : [])));
                                            @endphp
                                        @endif
                                        {!! Form::textarea('actions', is_null($action) ? null : $urls, ['class' => 'form-control', 'rows' => 5, 'placeholder' => '菜单权限，一行一个，以"/"开始']) !!}
                                        @if($errors -> has('actions'))
                                            <span class="help-block"><strong>{{ $errors -> first('actions') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!--- Description Field --->
                                <div class="form-group {{ $errors -> has('description') ? 'has-error' : ''}}">
                                    {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::textarea('description', is_null($action) ? null : $action -> description, ['class' => 'form-control', 'rows' => 5]) !!}
                                        @if($errors -> has('description'))
                                            <span class="help-block"><strong>{{ $errors -> first('description') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!--- Weight Field --->
                                <div class="form-group {{ $errors -> has('weight') ? 'has-error' : ''}}">
                                    {!! Form::label('weight', 'weight', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::number('weight', is_null($action) ? 100 : $action -> weight, ['class' => 'form-control']) !!}
                                        @if($errors -> has('weight'))
                                            <span class="help-block"><strong>{{ $errors -> first('weight') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                @if(!is_null($action))
                                    <input type="hidden" name="id" value="{{ $action -> id }}">
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="col-sm-8">
                                <a href="{{ route('adminActions') }}" class="btn btn-sm btn-default">Back</a>
                                <button class="pull-right btn {{ is_null($action) ? 'btn-info' : 'btn-primary' }}" type="submit">Submit</button>
                            </div>
                        </div>
                    {!! Form::close() !!}

                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>

    <script>
        var actionIcons = '{!! $icons !!}';
    </script>
@endsection