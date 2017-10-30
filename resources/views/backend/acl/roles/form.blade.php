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
                                    {!! Form::label('roleName', 'Name', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::text('roleName', is_null($role) ? null : $role -> roleName, ['class' => 'form-control']) !!}
                                        @if($errors -> has('roleName'))
                                            <span class="help-block"><strong>{{ $errors -> first('roleName') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!--- Description Field --->
                                <div class="form-group {{ $errors -> has('description') ? 'has-error' : ''}}">
                                    {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::textarea('description', is_null($role) ? null : $role -> description, ['class' => 'form-control', 'rows' => 5]) !!}
                                        @if($errors -> has('description'))
                                            <span class="help-block"><strong>{{ $errors -> first('description') }}</strong></span>
                                        @endif
                                    </div>
                                </div>


                                <!--- Permissions Field --->
                                <div class="form-group {{ $errors -> has('actions') ? 'has-error' : ''}}">
                                    {!! Form::label('actions', 'Permissions', ['class' => 'col-sm-2 control-label']) !!}
                                    <div class="col-sm-10">
                                        <div class="role-actions-list">
                                            @foreach($actions as $action)
                                                <div class="col-sm-4">
                                                    <table class="table table-bordered table-condensed role-actions-list-table">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <label>
                                                                    @if(is_null($role))
                                                                        <input type="checkbox" name="actions[]" class="parentRoleAction" value="{{ $action['id'] }}">&nbsp;&nbsp;{{ $action['actionName'] }}
                                                                    @else
                                                                        <input type="checkbox" name="actions[]" class="parentRoleAction" value="{{ $action['id'] }}" {{ in_array($action['id'], $role -> aid) ? 'checked' : ''}}>&nbsp;&nbsp;{{ $action['actionName'] }}
                                                                    @endif
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        @if($action['children'])
                                                            @foreach($action['children'] as $children)
                                                                <tr>
                                                                    <td>
                                                                        <label class="child-role-action-label">
                                                                            @if(is_null($role))
                                                                                <input type="checkbox" name="actions[]" class="childRoleAction" value="{{ $children['id'] }}">&nbsp;&nbsp;{{ $children['actionName'] }}
                                                                            @else
                                                                                <input type="checkbox" name="actions[]" class="childRoleAction" value="{{ $children['id'] }}" {{ in_array($children['id'], $role -> aid) ? 'checked' : ''}}>&nbsp;&nbsp;{{ $children['actionName'] }}
                                                                            @endif
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($errors -> has('actions'))
                                            <span class="help-block"><strong>{{ $errors -> first('actions') }}</strong></span>
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