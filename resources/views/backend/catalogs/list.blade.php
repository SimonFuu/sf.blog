@extends('backend.dashboard')
@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Catalogs</h3>
                        <div class="box-tools"><a href="{{ route('adminAddCatalog') }}" class="btn btn-sm btn-info"><strong>Add</strong></a></div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <div class="search-header">

                        </div>
                        <table class="table table-hover text-center">
                            <tbody>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Blog Menu</th>
                                <th>Index Menu</th>
                                <th>Action</th>
                            </tr>
                            @foreach($catalogs as $catalog)
                                <tr>
                                    <td>{{ $catalog -> id }}</td>
                                    <td>{{ $catalog -> name }}</td>
                                    <td>{{ $catalog -> isLeftSideMenu == 1 ? 'TRUE' : 'FALSE' }}</td>
                                    <td>{{ $catalog -> isIndexMenu == 1 ? 'TRUE' : 'FALSE' }}</td>
                                    <td>
                                        <a href="{{ route('adminEditCatalog', ['id' => $catalog -> id]) }}"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('adminDeleteCatalog', ['id' => $catalog -> id]) }}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {{ $catalogs -> links() }}
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
