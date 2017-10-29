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
                                <div class="form-group">
                                    {!! Form::label('name', '名称', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <!--- Url Field --->
                                <div class="form-group">
                                    {!! Form::label('url', 'Url', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('url', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <!--- Icon Field --->
                                <div class="form-group">
                                    {!! Form::label('icon', '图标', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        <button class="btn btn-default btn-sm set-action-icon" type="button" data-toggle="modal" data-target="#setActionIconModal"><i class="fa fa-circle-o" aria-hidden="true"></i></button>
                                        <i class="fa fa-hand-o-left" aria-hidden="true"></i> 请点击选择图标
                                        <input class="set-action-icon-value" type="hidden" name="icon" value="fa-circle-o">
                                    </div>
                                </div>

                                <!--- ParentId Field --->
                                <div class="form-group">
                                    {!! Form::label('parentId', '父级菜单', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('parentId', $menus, null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <!--- Actions Field --->
                                <div class="form-group">
                                    {!! Form::label('Actions', '权限', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::textarea('actions', null, ['class' => 'form-control', 'rows' => 5, 'placeholder' => '菜单权限，一行一个，以"/"开始']) !!}
                                    </div>
                                </div>
                                
                                <!--- Description Field --->
                                <div class="form-group">
                                    {!! Form::label('description', '描述', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 5]) !!}
                                    </div>
                                </div>

                                <!--- Weight Field --->
                                <div class="form-group">
                                    {!! Form::label('weight', '权重', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::number('weight', 100, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
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