@extends('backend.dashboard')
@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box {{ is_null($archive) ? 'box-info' : 'box-primary' }}">
                    <div class="box-header">
                        <h3 class="box-title">{{ is_null($archive) ? 'Add Archive' : 'Edit Archive' }}</h3>
                    </div>
                    <!-- /.box-header -->

                {!! Form::open(['url' => route('adminStoreArchive'), 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                <!-- class include {'form-horizontal'|'form-inline'} -->
                    <div class="box-body table-responsive no-padding">
                        <div class="col-md-8">
                            <!--- Title Field --->
                            <div class="form-group {{ $errors -> has('title') ? 'has-error' : ''}}">
                                {!! Form::label('title', 'Title', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-10">
                                    {!! Form::text('name', is_null($archive) ? null : $archive -> title, ['class' => 'form-control']) !!}
                                    @if($errors -> has('title'))
                                        <span class="help-block"><strong>{{ $errors -> first('title') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('thumb', 'Thumb', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-10">
                                    <div class="file-loading">
                                        <input id="" class="file-uploader" type="file" name="uploadFile" multiple accept="image/*" data-file="{{ is_null($archive) ? '#' : env('APP_STORAGE_HOST') . $archive -> thumb }}" data-uploader="{{ route('adminUploadFile') }}" data-type="thumb">
{{--                                        <input class="file-uploader" type="file" multiple accept="image/*" data-file="{{ env('APP_STORAGE_HOST') . '/storage/images/20171108/5Ll7IHeLDKQ4iFvJXOay6xF0cWk6kWs9EnORf2HH.png' }}" data-uploader="{{ route('adminUploadFile') }}" data-type="thumb">--}}
                                    </div>
                                </div>
                                <input type="hidden" name="file" value="{{ is_null($archive) ? '' : env('APP_STORAGE_HOST') . $archive -> thumb }}">
                            </div>

                            <!--- Content Field --->
                            <div class="form-group">
                                {!! Form::label('content', 'Content', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-10">
                                    {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 20]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!--- Catalog Field --->
                            <div class="form-group col-md-12">
                                {!! Form::label('catalog', 'Catalog', ['class' => 'control-label']) !!}
                                {!! Form::select('catalog', $catalogs, null, ['class' => 'form-control']) !!}
                            </div>
                            <!--- Category Field --->
                            <div class="form-group col-md-12">
                                {!! Form::label('category', 'Category:', ['class' => 'control-label']) !!}
                                {!! Form::select('category', $categories, null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-12">
                                <label for="dateTimePicker">Publish</label>
                                <div class="input-group date date-time-picker" data-value="{{ is_null($archive) ? date('Y-m-d H:i:s') : $archive -> publishAt }}">
                                    <input type='text' class="form-control" name="publish" id="dateTimePicker" />
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group col-md-12">
                                <label>Stick top</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="isTop" value="0" {{ is_null($archive) ? 'checked' : $archive -> isTop == 0 ? 'checked' : '' }}>
                                        FALSE
                                    </label>
                                    <label>
                                        <input type="radio" name="isTop" value="1" {{ is_null($archive) ? '' : $archive -> isTop == 1 ? 'checked' : '' }}>
                                        TRUE
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-xs-8">
                            <a href="{{ route('adminArchives') }}" class="btn btn-sm btn-default">Back</a>
                            <button class="pull-right btn btn-sm {{ is_null($archive) ? 'btn-info' : 'btn-primary' }}" type="submit">Submit</button>
                        </div>
                    </div>
                    @if(!is_null($archive))
                        <input type="hidden" name="id" value="{{ $archive -> id }}">
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection