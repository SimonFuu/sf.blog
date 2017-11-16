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

    <!-- Modals -->
    <!-- set-actions-modal -->
    <div class="modal fade" id="setActionIconModal" tabindex="-1" role="dialog" aria-labelledby="setActionIconModalLabel">
        <div class="modal-dialog  modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="setActionIconModalLabel">Font Awesome Icons</h4>
                </div>
                <div class="modal-body set-actions-icons-list-modal">
                    <table class="set-actions-icons-list">
                        <thead>
                        <tr>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary disabled set-actions-previous" data-previous="-1">
                                    <i class="fa fa-arrow-left"></i>
                                </button>
                            </td>
                            <td class="text-center set-actions-page-info" colspan="5"> 1 / 0 </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary set-actions-next" data-next="-1">
                                    <i class="fa fa-arrow-right"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <label class="set-actions-icon-label">
                                    <input type="text" class="form-control set-actions-icon-name" placeholder="search icon">
                                </label>
                            </td>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.set-actions-modal -->
    <!-- /.Modals -->
</body>
@endsection