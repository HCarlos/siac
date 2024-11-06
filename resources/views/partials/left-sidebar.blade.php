<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu sidebar-atemun-bg" >

    <div class="slimscroll-menu">

        <!-- LOGO -->
        <a href="/home" class="logo text-left pr-2 pl-2 pt-1 pb-1"  style="background: #FFF">
            <span class="logo-lg">
                <img src="{{asset('images/web/logo-0.png')}}" alt="" >
            </span>
            <span class="logo-sm">
                <img src="{{asset('images/logo_sm.png')}}" alt="" >
            </span>
        </a>
    @guest()
    @else()
        <!--- Sidemenu -->
        <ul class="metismenu side-nav mb-0">
            @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_ADMIN|USER_SAS_CAP|USER_SAS_ADMIN|USER_DIF_CAP|USER_DIF_ADMIN|ENLACE') )
                <li class="side-nav-item">
                    @if (Auth::user()->hasRole('Administrator|SysOp|test_admin') )
                        <a href="{{ url('dashboard-statistics') }}" class="side-nav-link">
                    @else
                        <a href="{{ url(Auth::user()->hasRole('ENLACE') ? 'dashboard_enlace' : 'dashboard_enlace') }}" class="side-nav-link">
                    @endif
                        <i class="mdi dripicons-meter"></i>
                        <span class="badge badge-light float-right"></span>
                        <span>Dashboard</span>
                        </a>
                </li>
            @endif
            <li class="side-nav-item">
                <a href="{{route('listDenuncias')}}" class="side-nav-link">
                    <i class="mdi dripicons-archive"></i>
                    @php $filters['filterdata']=""; @endphp
                    <span class="badge badge-light float-right">{{\App\Models\Denuncias\Denuncia::query()->GetDenunciasFilterCount($filters)->count()}}</span>
                    <span>Solicitudes</span>
                </a>
            </li>

            @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
            <li class="side-nav-item">
                <a href="{{route('listDenunciasAmbito1')}}" class="side-nav-link">
                    <i class="mdi dripicons-archive"></i>
                    @php $filters['filterdata']=""; @endphp
                    <span class="badge badge-light float-right">{{\App\Models\Denuncias\_viDDSs::query()->where('ambito_dependencia',1)->count()}}</span>
                    <span>Apoyos Soc.</span>
                </a>
            </li>
            @endif

            @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                <li class="side-nav-item">
                    <a href="{{route('listDenunciasAmbito2')}}" class="side-nav-link">
                        <i class="mdi dripicons-archive"></i>
                        @php $filters['filterdata']=""; @endphp
                        <span class="badge badge-light float-right">{{\App\Models\Denuncias\_viDDSs::query()->where('ambito_dependencia',2)->count()}}</span>
                        <span>Servicios Mun.</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="dripicons-browser"></i>
                    <span> Estructura </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                    <li>
                        <a href="{{route('listDependencias')}}">
                            <i class="mdi mdi-account-multiple-outline"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Dependencia::count()}}</span>
                            <span>Unidades Administrativas</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp'))
                    <li>
                        <a href="{{route('listAreas')}}">
                            <i class="mdi mdi-account-group"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Area::count()}}</span>
                            <span>Áreas</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp'))
                    <li>
                        <a href="{{route('listSubareas')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Subarea::count()}}</span>
                            <span>Subareas</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                    <li>
                        <a href="{{route('listEstatus')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Estatu::count()}}</span>
                            <span>Status</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp'))
                    <li>
                        <a href="{{route('listMedidas')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Medida::count()}}</span>
                            <span>Medidas</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                    <li>
                        <a href="{{route('listOrigenes')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Origen::count()}}</span>
                            <span>Origenes</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                    <li>
                        <a href="{{route('listPrioridades')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Prioridad::count()}}</span>
                            <span>Prioridades</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                    <li>
                        <a href="{{route('listServicios')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Servicio::count()}}</span>
                            <span>Servicios</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp'))
                    <li>
                        <a href="{{route('listAfiliaciones')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Afiliacion::count()}}</span>
                            <span>Afiliaciones</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp'))
                    <li>
                        <a href="{{route('listTipoasentamientos')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Tipoasentamiento::count()}}</span>
                            <span>Tipo Asentamientos</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp'))
                    <li>
                        <a href="{{route('listAsentamientos')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Asentamiento::count()}}</span>
                            <span>Asentamientos</span>
                        </a>
                    </li>
                    @endif

                </ul>
            </li>
            @endif
            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="fa fa-folder"></i>
                    <span> Domicilios </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                    <li>
                        <a href="{{route('listCalles')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Calle::count()}}</span>
                            <span>Calles</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                    <li>
                        <a href="{{route('listCiudades')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Ciudad::count()}}</span>
                            <span>Ciudad</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator'))
                    <li>
                        <a href="{{route('listLocalidades')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Localidad::count()}}</span>
                            <span>Localidades</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator'))
                    <li>
                        <a href="{{route('listMunicipios')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Municipio::count()}}</span>
                            <span>Municipios</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator'))
                    <li>
                        <a href="{{route('listEstados')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Estado::count()}}</span>
                            <span>Estados</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                    <li>
                        <a href="{{route('listCodigopostales')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Codigopostal::count()}}</span>
                            <span>Códigos Postales</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator'))
                    <li>
                        <a href="{{route('listTipocomunidades')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Tipocomunidad::count()}}</span>
                            <span>Tipo Comunidades</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                    <li>
                        <a href="{{route('listComunidades')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Comunidad::count()}}</span>
                            <span>Comunidades</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                    <li>
                        <a href="{{route('listColonias')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Colonia::count()}}</span>
                            <span>Colonias</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                    <li>
                        <a href="{{route('listUbicaciones')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Ubicacion::count()}}</span>
                            <span>Ubicaciones</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>

            @if(Gate::check('all') || Gate::check('unificar'))
            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="fa fa-folder"></i>
                    <span> Unificar </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN'))
                        <li>
                            <a href="{{route('unicomunidad')}}">
                                <i class="fas fa-money-check-alt"></i>
                                <span class="badge badge-light float-right"></span>
                                <span>Comunidad</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN'))
                        <li>
                            <a href="{{route('unicolonia')}}">
                                <i class="fas fa-money-check-alt"></i>
                                <span class="badge badge-light float-right"></span>
                                <span>Colonia</span>
                            </a>
                        </li>
                    @endif
                                        @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN'))
                    <li>
                        <a href="{{route('unicolcom')}}">
                            <i class="fas fa-money-check-alt"></i>
                            <span class="badge badge-light float-right"></span>
                            <span>Colonias a Comunidad </span>
                        </a>
                    </li>
                                        @endif
                </ul>
            </li>
            @endif

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="fas fa-cog"></i>
                    <span> Configuraciones </span>
                    <span class="menu-arrow"></span>
                </a>

                <ul class="side-nav-second-level" aria-expanded="false">
                    @if (Auth::user()->hasRole('Administrator|SysOp'))
                    <li>
                        <a href="{{route('listCategorias')}}">
                            <i class="fas fa-user-tag"></i>
                            <span class="badge badge-light float-right">{{\App\Models\Users\Categoria::count()}}</span>
                            <span>Categorias Usuario</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                    <li>
                        <a href="{{route('listUsers')}}">
                            <i class="fas fa-users"></i>
                            <span class="badge badge-success float-right">{{\App\User::count()}}</span>
                            <span>Usuarios</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|test_admin') || Auth::user()->can('asignar_roles'))
                    <li>
                        <a href="{{route('asignaRoleList',['Id'=>0])}}">
                            <i class="fas fa-users-cog"></i>
                            <span class="badge badge-light float-right">{{\App\Role::count()}}</span>
                            <span>Roles</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|test_admin') || Auth::user()->can('asignar_permisos'))
                    <li>
                        <a href="{{route('asignaPermissionList',['Id'=>0])}}">
                            <i class="fas fa-user-cog"></i>
                            <span class="badge badge-light float-right">{{\App\Permission::count()}}</span>
                            <span>Permisos</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|test_admin') || Auth::user()->can('asignar_dependencias'))
                        <li>
                            <a href="{{route('asignaDependenciaList',['Id'=>0])}}">
                                <i class="fas fa-user-cog"></i>
                                <span class="badge badge-light float-right">{{\App\Models\Catalogos\Dependencia::count()}}</span>
                                <span>Dependencias</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                    <li>
                        <a href="{{route('archivosConfig')}}">
                            <i class="fas fa-file-excel"></i>
                            <span>Formatos Excel</span>
                        </a>
                    </li>
                    @endif
                </ul>

            </li>

            @if (Auth::user()->hasRole('Administrator|SysOp|USER_MOBILE_BASIC|USER_MOBILE_ADMIN') )
                <li class="side-nav-item">
                    <a href="{{ url('listDenunciasMobile') }}" class="side-nav-link">
                        <i class="mdi dripicons-device-mobile"></i>
                        <span class="badge badge-light float-right">{{ \App\Models\Mobiles\Denunciamobile::count() }}</span>
                        <span>Mobile</span>
                    </a>
                </li>
            @endif



        </ul>
        <div class="clearfix"></div>
        @include('partials.aviso-privacidad-panel')
        <div class="clearfix"></div>
    @endguest
    </div>
</div>
