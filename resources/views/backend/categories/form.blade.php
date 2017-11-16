@extends('backend.dashboard')
@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box {{ is_null($category) ? 'box-info' : 'box-primary' }}">
                    <div class="box-header">
                        <h3 class="box-title">{{ is_null($category) ? 'Add Category' : 'Edit Category' }}</h3>
                    </div>
                    <!-- /.box-header -->

                {!! Form::open(['url' => route('adminStoreCategory'), 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                <!-- class include {'form-horizontal'|'form-inline'} -->
                    <div class="box-body table-responsive no-padding">
                        <div class="col-xs-8">
                            <!--- Name Field --->
                            <div class="form-group {{ $errors -> has('name') ? 'has-error' : ''}}">
                                {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('name', is_null($category) ? null : $category -> name, ['class' => 'form-control']) !!}
                                    @if($errors -> has('name'))
                                        <span class="help-block"><strong>{{ $errors -> first('name') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!--- Weight Field --->
                            <div class="form-group {{ $errors -> has('weight') ? 'has-error' : ''}}">
                                {!! Form::label('weight', 'Weight', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::number('weight', is_null($category) ? null : $category -> weight, ['class' => 'form-control']) !!}
                                    @if($errors -> has('weight'))
                                        <span class="help-block"><strong>{{ $errors -> first('weight') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <!--- Description Field --->
                            <div class="form-group {{ $errors -> has('description') ? 'has-error' : ''}}">
                                {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::textarea('description', is_null($category) ? null : $category -> description, ['class' => 'form-control', 'rows' => 5]) !!}
                                    @if($errors -> has('description'))
                                        <span class="help-block"><strong>{{ $errors -> first('description') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            @if(!is_null($category))
                                <input type="hidden" name="id" value="{{ $category -> id }}">
                            @endif
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-8">
                            <a href="{{ route('adminCategories') }}" class="btn btn-sm btn-default">Back</a>
                            <button class="pull-right btn btn-sm {{ is_null($category) ? 'btn-info' : 'btn-primary' }}" type="submit">Submit</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection