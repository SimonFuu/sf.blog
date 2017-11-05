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
                <p>{{ Auth::user() -> name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        @if(session('adminMenus'))
            <ul class="sidebar-menu" data-widget="tree">
                <!-- Optionally, you can add icons to the links -->
                @foreach(session('adminMenus') as $menu)
                    @if($menu['children'])
                        <li class="treeview">
                            <a href="#"><i class="fa {{ $menu['icon'] }}"></i> <span>{{ $menu['actionName'] }}</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @foreach($menu['children'] as $child)
                                    @php
                                        $relativeUri = str_replace(env('APP_BACKEND_PREFIX'), '', $uri);
                                        $urls = json_decode($child['actions'], true);
                                    @endphp
                                    <li class="{{ $uri == $child['url'] || in_array($relativeUri, $urls) ? 'active' : '' }}">
                                        <a href="{{ env('APP_BACKEND_PREFIX') . $child['url']}}"><i class="fa {{ $child['icon'] }}"></i>
                                            <span>{{ $child['actionName'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        @php
                            $relativeUri = str_replace(env('APP_BACKEND_PREFIX'), '', $uri);
                            $urls = json_decode($menu['actions'], true);
                        @endphp
                        <li class="{{ ($relativeUri == $menu['url']) || in_array($relativeUri, $urls) ? 'active' : '' }}">
                            <a href="{{ env('APP_BACKEND_PREFIX') . $menu['url']}}"><i class="fa {{ $menu['icon'] }}"></i>
                                <span>{{ $menu['actionName'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>