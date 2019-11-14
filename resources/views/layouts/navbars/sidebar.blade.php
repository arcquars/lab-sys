<div class="sidebar" data-color="orange">
    <!--
Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

Tip 2: you can also add an image using data-image tag
-->
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="http://www.creative-tim.com" class="simple-text">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>
        <ul class="nav">
            <li class="nav-item @if($activePage == 'dashboard') active @endif">
                <a class="nav-link" href="{{route('home')}}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>Tablero</p>
                </a>
            </li>
            @can('manage-users')
            <li class="nav-item dropdown">
                <a class="nav-link nav-link-clinica dropdown-toggle" data-toggle="collapse" href="#c_admin" @if($activeButton =='adminactiveButton') aria-expanded="true" @endif aria-controls="c_admin" role="button">
                    <i class="fas fa-toolbox"></i>
                    <p>Administracion</p>
                </a>
                <div class="collapse @if($activeButton =='adminactiveButton') show @endif" id="c_admin">
                    <ul class="nav">
                        <li class="nav-item @if($activePage == 'admin_users') active @endif">
                            <a class="nav-link" href="{{route('admin.users.index')}}">
                                <i class="fas fa-users-cog"></i>
                                <p>Gestionar Usuarios</p>
                            </a>
                        </li>
                        <li class="nav-item @if($activePage == 'user-management') active @endif">
                            <a class="nav-link" href="#">
                                <i class="nc-icon nc-circle-09"></i>
                                <p>{{ __("User Management") }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            <li class="nav-item @if($activePage == 'table') active @endif">
                <a class="nav-link" href="#">
                    <i class="nc-icon nc-notes"></i>
                    <p>{{ __("Table List") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'typography') active @endif">
                <a class="nav-link" href="#">
                    <i class="nc-icon nc-paper-2"></i>
                    <p>{{ __("Typography") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'icons') active @endif">
                <a class="nav-link" href="#">
                    <i class="nc-icon nc-atom"></i>
                    <p>{{ __("Icons") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'maps') active @endif">
                <a class="nav-link" href="#">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>{{ __("Maps") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'notifications') active @endif">
                <a class="nav-link" href="#">
                    <i class="nc-icon nc-bell-55"></i>
                    <p>{{ __("Notifications") }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>