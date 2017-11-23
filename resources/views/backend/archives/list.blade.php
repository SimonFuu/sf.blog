@extends('backend.dashboard')
@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Archives</h3>
                        <div class="box-tools"><a href="{{ route('adminAddArchive') }}" class="btn btn-sm btn-info"><strong>Add</strong></a></div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <div class="search-header">
                            {!! Form::open(['url' => route('adminArchives'), 'method' => 'GET', 'class' => 'form-inline', 'role' => 'form']) !!}
                            <!-- class include {'form-horizontal'|'form-inline'} -->
                                <!--- Email Field --->
                                <div class="form-group form-group-sm">
                                    {!! Form::label('words', 'Title or Sid ', ['class' => 'control-label']) !!}
                                    {!! Form::text('words', null, ['class' => 'form-control']) !!}
                                </div>

                                <!--- Catalog Field --->
                                <div class="form-group">
                                    {!! Form::label('Catalog', 'Catalog:', ['class' => 'control-label']) !!}
                                    {!! Form::select('catalog', $catalogs, null, ['class' => 'form-control']) !!}
                                </div>

                                <!--- Category Field --->
                                <div class="form-group">
                                    {!! Form::label('Category', 'Category:', ['class' => 'control-label']) !!}
                                    {!! Form::select('category', $categories, null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    <label for="publish">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right date-range-picker" readonly="" name="publish" id="publish">
                                    </div>
                                    <!-- /.input group -->
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
                                <th>Title</th>
                                <th>Catalog</th>
                                <th>Category</th>
                                <th>PV(Page view)</th>
                                <th>UV(Unique View)</th>
                                <th>Sid</th>
                                <th>Publish</th>
                                <th>Action</th>
                            </tr>
                            @foreach($archives as $archive)
                                <tr class="{{ $archive -> isTop ? 'bg-teal color-palette' : ''}}">
                                    <td>{{ $archive -> id }}</td>
                                    <td><a href="{{ route('archive', ['sid' => $archive -> sid]) }}" target="_blank">{{ $archive -> title }}</a></td>
                                    <td>{{ $archive -> catalog }}</td>
                                    <td>{{ $archive -> category }}</td>
                                    <td>{{ $archive -> pv }}</td>
                                    <td>{{ $archive -> uv }}</td>
                                    <td>{{ $archive -> sid }}</td>
                                    <td>{{ $archive -> publishAt }}</td>
                                    <td>
                                        <a href="{{ route('adminEditArchive', ['id' => $archive -> id]) }}"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('adminDeleteArchive', ['id' => $archive -> id]) }}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {{ $archives -> appends(is_null($search) ? [] : $search) -> links() }}
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <script>
        var dateRange = '{{ !is_null($search) && isset($search['publish']) ? $search['publish'] : '' }}';
    </script>
@endsection
