@extends('backend.dashboard')
@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box {{ is_null($setting) ? 'box-info' : 'box-primary' }}">
                    <div class="box-header">
                        <h3 class="box-title">{{ is_null($setting) ? 'Add Setting' : 'Edit Setting' }}</h3>
                    </div>
                    <!-- /.box-header -->

                {!! Form::open(['url' => route('adminStoreSetting'), 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                <!-- class include {'form-horizontal'|'form-inline'} -->
                    <div class="box-body table-responsive no-padding">
                        <div class="col-xs-8">
                            <!--- Name Field --->
                            <div class="form-group {{ $errors -> has('key') ? 'has-error' : ''}}">
                                {!! Form::label('key', 'Key', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('key', is_null($setting) ? null : $setting -> key, ['class' => 'form-control', is_null($setting) ? '' : 'readonly']) !!}
                                    @if($errors -> has('key'))
                                        <span class="help-block"><strong>{{ $errors -> first('key') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!--- Name Field --->
                            <div class="form-group {{ $errors -> has('value') ? 'has-error' : ''}}">
                                {!! Form::label('value', 'Value', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('value', is_null($setting) ? null : $setting -> value, ['class' => 'form-control']) !!}
                                    @if($errors -> has('value'))
                                        <span class="help-block"><strong>{{ $errors -> first('value') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!--- Description Field --->
                            <div class="form-group {{ $errors -> has('description') ? 'has-error' : ''}}">
                                {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::textarea('description', is_null($setting) ? null : $setting -> description, ['class' => 'form-control', 'rows' => 5]) !!}
                                    @if($errors -> has('description'))
                                        <span class="help-block"><strong>{{ $errors -> first('description') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            @if(!is_null($setting))
                                <input type="hidden" name="id" value="{{ $setting -> id }}">
                            @endif
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-8">
                            <a href="{{ route('adminSettings') }}" class="btn btn-sm btn-default">Back</a>
                            <button class="pull-right btn btn-sm {{ is_null($setting) ? 'btn-info' : 'btn-primary' }}" type="submit">Submit</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection