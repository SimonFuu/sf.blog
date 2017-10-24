@extends('layouts.admin.layouts')
@section('body')
<body class="skin-blue sidebar-mini">
    <div class="wrapper">
    @include('layouts.admin.header')
    @include('layouts.admin.left')
    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                @include('layouts.admin.notice')
                @yield('main')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('layouts.admin.footer')
    </div>
    <!-- ./wrapper -->
</body>
@endsection