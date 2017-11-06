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
                        <div class="col-xs-8">
                            <!--- Name Field --->
                            <div class="form-group {{ $errors -> has('name') ? 'has-error' : ''}}">
                                {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('name', is_null($archive) ? null : $archive -> name, ['class' => 'form-control']) !!}
                                    @if($errors -> has('name'))
                                        <span class="help-block"><strong>{{ $errors -> first('name') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!--- Action Field --->
                            <div class="form-group {{ $errors -> has('action') ? 'has-error' : ''}}">
                                {!! Form::label('action', 'Action', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('action', is_null($archive) ? null : $archive -> action, ['class' => 'form-control']) !!}
                                    @if($errors -> has('action'))
                                        <span class="help-block"><strong>{{ $errors -> first('action') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!--- Weight Field --->
                            <div class="form-group {{ $errors -> has('weight') ? 'has-error' : ''}}">
                                {!! Form::label('weight', 'Weight', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::number('weight', is_null($archive) ? null : $archive -> weight, ['class' => 'form-control']) !!}
                                    @if($errors -> has('weight'))
                                        <span class="help-block"><strong>{{ $errors -> first('weight') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!--- isBlogMenu Field --->
                            <div class="form-group {{ $errors -> has('isLeftSideMenu') ? 'has-error' : ''}}">
                                {!! Form::label('isLeftSideMenu', 'Blog Menu', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-8">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="isLeftSideMenu" id="isLeftSideMenu" value="1" {{ is_null($archive) ? 'checked' : $archive -> isLeftSideMenu == 1 ? 'checked' : '' }}>
                                            TRUE
                                        </label>
                                        <label>
                                            <input type="radio" name="isLeftSideMenu" id="isLeftSideMenu" value="0" {{ is_null($archive) ? '' : $archive -> isLeftSideMenu == 0 ? 'checked' : '' }}>
                                            FALSE
                                        </label>
                                    </div>
                                    @if($errors -> has('isLeftSideMenu'))
                                        <span class="help-block"><strong>{{ $errors -> first('isLeftSideMenu') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!--- isIndexMenu Field --->
                            <div class="form-group {{ $errors -> has('isIndexMenu') ? 'has-error' : ''}}">
                                {!! Form::label('isIndexMenu', 'Index Menu', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-8">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="isIndexMenu" id="isIndexMenu" value="1" {{ is_null($archive) ? 'checked' : $archive -> isIndexMenu == 1 ? 'checked' : '' }}>
                                            TRUE
                                        </label>
                                        <label>
                                            <input type="radio" name="isIndexMenu" id="isIndexMenu" value="0" {{ is_null($archive) ? '' : $archive -> isIndexMenu == 0 ? 'checked' : '' }}>
                                            FALSE
                                        </label>
                                    </div>
                                    @if($errors -> has('isIndexMenu'))
                                        <span class="help-block"><strong>{{ $errors -> first('isIndexMenu') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!--- Description Field --->
                            <div class="form-group {{ $errors -> has('description') ? 'has-error' : ''}}">
                                {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::textarea('description', is_null($archive) ? null : $archive -> description, ['class' => 'form-control', 'rows' => 5]) !!}
                                    @if($errors -> has('description'))
                                        <span class="help-block"><strong>{{ $errors -> first('description') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            @if(!is_null($archive))
                                <input type="hidden" name="id" value="{{ $archive -> id }}">
                            @endif
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-8">
                            <a href="{{ route('adminArchives') }}" class="btn btn-sm btn-default">Back</a>
                            <button class="pull-right btn btn-sm {{ is_null($archive) ? 'btn-info' : 'btn-primary' }}" type="submit">Submit</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection