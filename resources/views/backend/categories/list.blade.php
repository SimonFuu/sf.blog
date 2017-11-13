@extends('backend.dashboard')
@section('main')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Categories</h3>
                        <div class="box-tools"><a href="{{ route('adminAddCategory') }}" class="btn btn-sm btn-info"><strong>Add</strong></a></div>
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
                                <th>Description</th>
                                <th>Weight</th>
                                <th>Action</th>
                            </tr>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category -> id }}</td>
                                    <td>{{ $category -> name }}</td>
                                    <td>{{ $category -> description }}</td>
                                    <td>{{ $category -> weight }}</td>
                                    <td>
                                        <a href="{{ route('adminEditCategory', ['id' => $category -> id]) }}"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('adminDeleteCategory', ['id' => $category -> id]) }}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {{ $categories -> links() }}
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
