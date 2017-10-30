@extends('backend.dashboard')
@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box {{ is_null($role) ? 'box-info' : 'box-primary' }}">
                    <div class="box-header">
                        <h3 class="box-title">{{ is_null($role) ? 'Add Role' : 'Edit Role' }}</h3>
                    </div>
                    <!-- /.box-header -->

                    {!! Form::open(['url' => route('adminStoreRoles'), 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                    <!-- class include {'form-horizontal'|'form-inline'} -->
                        <div class="box-body table-responsive no-padding">
                            <div class="col-xs-8">
                                <!--- Name Field --->
                                <div class="form-group {{ $errors -> has('roleName') ? 'has-error' : ''}}">
                                    {!! Form::label('roleName', '名称', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('roleName', is_null($role) ? null : $role -> roleName, ['class' => 'form-control']) !!}
                                        @if($errors -> has('roleName'))
                                            <span class="help-block"><strong>{{ $errors -> first('roleName') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                
                                @if(!is_null($role))
                                    <input type="hidden" name="id" value="{{ $role -> id }}">
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="col-sm-8">
                                <a href="{{ route('adminRoles') }}" class="btn btn-sm btn-default">Back</a>
                                <button class="pull-right btn {{ is_null($role) ? 'btn-info' : 'btn-primary' }}" type="submit">Submit</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection