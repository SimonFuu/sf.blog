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
                            {{----}}
                            {{--<!--- Type Field --->--}}
                            {{--<div class="form-group {{ $errors -> has('key') ? 'has-error' : ''}}">--}}
                                {{--{!! Form::label('type', 'Type', ['class' => 'col-sm-2 control-label']) !!}--}}
                                {{--<div class="col-sm-8">--}}
                                    {{--<div class="radio">--}}
                                        {{--<label>--}}
                                            {{--<input type="radio" name="type" id="type" value="1" checked="">--}}
                                            {{--TEXT--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="radio">--}}
                                        {{--<label>--}}
                                            {{--<input type="radio" name="type" id="type" value="2" checked="">--}}
                                            {{--FILE--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

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

                            {{--<!--- Logo File Field --->--}}
                            {{--<div class="form-group">--}}
                                {{--{!! Form::label('file', 'File', ['class' => 'col-sm-2 control-label']) !!}--}}
                                {{--<div class="col-sm-8">--}}
                                    {{--<!-- The fileinput-button span is used to style the file input field as button -->--}}
                                    {{--<span class="btn btn-success fileinput-button">--}}
                                    {{--<i class="fa fa-plus"></i>--}}
                                    {{--<span>Upload File</span>--}}
                                    {{--<!-- The file input field used as target for the file upload widget -->--}}
                                    {{--<input id="file" type="file" name="file" multiple--}}
                                           {{--data-url="{{ env('APP_BACKEND_PREFIX') }}/upload"--}}
                                           {{--data-sequential-uploads="true"--}}
                                           {{--data-form-data='{"_token": "{{ csrf_token() }}"}'--}}
                                    {{-->--}}
                                    {{--</span>--}}
                                    {{--<span class="btn btn-danger remove-customization-file">--}}
                                        {{--<i class="fa fa-minus"></i>--}}
                                        {{--<span>Remove File</span>--}}
                                    {{--</span>--}}

                                    {{--<small class="text-muted block" style="margin-top: 10px">Formats: AI/CDR/EPS/PDF/SVG, Max size: 10Mb</small>--}}
                                    {{--<!-- The global progress bar -->--}}
                                    {{--<div id="progress" class="progress">--}}
                                        {{--<div class="progress-bar progress-bar-success"></div>--}}
                                        {{--<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>--}}
                                    {{--</div>--}}
                                    {{--<!-- The container for the uploaded files -->--}}
                                    {{--<div id="file-name-container" class="file-name-container">--}}

                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
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