@extends('backend.dashboard')
@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Settings</h3>
                        <div class="box-tools"><a href="{{ route('adminAddActions') }}" class="btn btn-sm btn-info"><strong>Add</strong></a></div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <div class="search-header">
                            {!! Form::open(['url' => route('adminSettings'), 'method' => 'GET', 'class' => 'form-inline', 'role' => 'form']) !!}
                            <!-- class include {'form-horizontal'|'form-inline'} -->
                                <!--- Email Field --->
                                <div class="form-group form-group-sm">
                                    {!! Form::label('words', 'Words', ['class' => 'control-label']) !!}
                                    {!! Form::text('words', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group form-group-sm">
                                    <button class="btn btn-success btn-sm"><strong>Search</strong></button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <table class="table table-hover text-center">
                            <tbody>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Value</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {{ $settings -> links() }}
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
