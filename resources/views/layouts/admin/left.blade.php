<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ config('app.cdn') }}/admin/plugins/AdminLTE/img/avatar5.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>admin.name</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
                <!-- Optionally, you can add icons to the links -->
                <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>
                <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#">Link in level 2</a></li>
                        <li><a href="#">Link in level 2</a></li>
                    </ul>
                </li>
            <!-- Optionally, you can add icons to the links -->
            {{--@foreach($menus as $menu)--}}
                {{--@if($menu -> children)--}}
                    {{--<li class="treeview {{ $menu -> active ? 'active' : '' }}">--}}
                        {{--<a href="{{ $menu -> url }}"><i class="fa {{ $menu -> icon }}"></i> <span>{{ $menu -> name }}</span>--}}
                            {{--<span class="pull-right-container">--}}
                                {{--<i class="fa fa-angle-left pull-right"></i>--}}
                            {{--</span>--}}
                        {{--</a>--}}
                        {{--<ul class="treeview-menu">--}}
                            {{--@foreach($menu -> children as $child)--}}
                                {{--<li class="{{ $child -> active ? 'active' : '' }}"><a href="{{ $child -> url }}">{{ $child -> name }}</a></li>--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--@else--}}
                    {{--<li class="{{ $menu -> active ? 'active' : '' }}">--}}
                        {{--<a href="{{ $menu -> url }}">--}}
                            {{--<i class="fa {{ $menu -> icon }}"></i> <span>{{ $menu -> name }}</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--@endif--}}
            {{--@endforeach--}}
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>