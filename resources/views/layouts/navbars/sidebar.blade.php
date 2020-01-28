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
            @can('manage-admin')
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
                <li class="nav-item @if($activePage == 'instituciones') active @endif">
                    <a class="nav-link" href="{{route('institucion.home')}}">
                        <i class="fas fa-book-medical"></i>
                        <p>Instituciones</p>
                    </a>
                </li>
                <li class="nav-item @if($activePage == 'doctores') active @endif">
                    <a class="nav-link" href="{{route('doctores.home')}}">
                        <i class="fas fa-user-md"></i>
                        <p>Doctores</p>
                    </a>
                </li>
            @endcan
            @can('manage-users')
                <li class="nav-item @if($activePage == 'clients') active @endif">
                    <a class="nav-link" href="{{route('clients.index')}}">
                        <i class="nc-icon nc-notes"></i>
                        <p>Clientes</p>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link nav-link-clinica dropdown-toggle" data-toggle="collapse" href="#c_reportes" @if($activeButton =='reporteActiveButton') aria-expanded="true" @endif aria-controls="c_reportes" role="button">
                        <i class="fas fa-poll"></i>
                        <p>Reportes</p>
                    </a>
                    <div class="collapse @if($activeButton =='reporteActiveButton') show @endif" id="c_reportes">
                        <ul class="nav">
                            <li class="nav-item @if($activePage == 'admin_reporte_diario') active @endif">
                                <a class="nav-link" href="{{route('reporte.reporte.diario')}}">
                                    <i class="fas fa-receipt"></i>
                                    <p>Informe Diario</p>
                                </a>
                            </li>
                            <li class="nav-item @if($activePage == 'admin_reporte') active @endif">
                                <a class="nav-link" href="{{route('reporte.reporte1')}}">
                                    <i class="fas fa-receipt"></i>
                                    <p>Cobros x Dia</p>
                                </a>
                            </li>
                            @can('edit-users')
                                <li class="nav-item @if($activePage == 'admin_reporte2') active @endif">
                                    <a class="nav-link" href="{{route('reporte.reporte2')}}">
                                        <i class="fas fa-receipt"></i>
                                        <p>Reporte Administrador</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcan
            @can('manage-users-dr')
                <li class="nav-item @if($activePage == 'analisis') active @endif">
                    <a class="nav-link" href="{{route('analisis.index')}}">
                        <i class="fas fa-notes-medical fa-lg"></i>
                        <p>Analisis</p>
                    </a>
                </li>
            @endcan
            @cannot('manage-users-no-tecnico')
            <li class="nav-item @if($activePage == 'reportetecnico') active @endif">
                <a class="nav-link" href="{{route('analisis.listatecnico')}}">
                    <i class="nc-icon nc-notes"></i>
                    <p>Analisis Tecnico</p>
                </a>
            </li>
            @endcannot
            @can('manage-users-only-secretaria')
            <li class="nav-item @if($activePage == 'reportetecnico') active @endif">
                <a class="nav-link" href="{{route('analisis.listatecnico')}}">
                    <i class="fas fa-cash-register"></i>
                    <p>Caja Chica</p>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</div>