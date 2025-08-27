@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Gate;

    $filters['filterdata']="";

    $atendidas = \App\Models\Denuncias\_viDDSs::query()->GetDenunciasEstatusAmbitoFilterCount($filters)->where('ambito_dependencia',2)->where('ue_id',17)->count();
    $cerradas = \App\Models\Denuncias\_viDDSs::query()->GetDenunciasEstatusAmbitoFilterCount($filters)->where('ambito_dependencia',2)->where('ue_id',21)->count();
    $tAtCer = $atendidas + $cerradas;

    $rechazadas = \App\Models\Denuncias\_viDDSs::query()->GetDenunciasEstatusAmbitoFilterCount($filters)->where('ambito_dependencia',2)->where('ue_id',20)->count();
    $cerradas_rechazadas = \App\Models\Denuncias\_viDDSs::query()->GetDenunciasEstatusAmbitoFilterCount($filters)->where('ambito_dependencia',2)->where('ue_id',22)->count();
    $tRechCer = $rechazadas + $cerradas_rechazadas;

    $enproceso = \App\Models\Denuncias\_viDDSs::query()->GetDenunciasEstatusAmbitoFilterCount($filters)->where('ambito_dependencia',2)->where('ue_id',19)->count();
    $observadas = \App\Models\Denuncias\_viDDSs::query()->GetDenunciasEstatusAmbitoFilterCount($filters)->where('ambito_dependencia',2)->where('ue_id',18)->count();
    $tProObs = $enproceso + $observadas;

@endphp
    <!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu sidebar-atemun-bg">

    <div class="slimscroll-menu">

        <!-- LOGO -->
        <a href="/home" class="logo text-left pr-2 pl-2 pt-1 pb-1" style="background: #FFF">
            <span class="logo-lg">
                <img src="{{asset('images/web/logo-0.png')}}" alt="">
            </span>
            <span class="logo-sm">
                <img src="{{asset('images/favicon/favicon-114-114.png')}}" width="32" height="32" alt="">
            </span>
        </a>
        @guest()
        @else()
            <!--- Sidemenu -->
            <ul class="metismenu side-nav mb-0">

                @include('shared.ui_kit.__menu_dashboard_static_sidebar')

                @if (Auth::user()->hasRole('Administrator|SysOp|test_admin|SOLICITUDES_V1'))
                    <li class="side-nav-item">
                        <a href="{{route('listDenuncias')}}" class="side-nav-link">
                            @include('.shared.svgs.__solicitudes')
{{--                            @php $filters['filterdata']=""; @endphp--}}
                            <span>Solicitudes</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasRole('Administrator|SysOp|test_admin|APOYOS_SOCIALES'))
                    <li class="side-nav-item">
                        <a href="{{route('listDenunciasAmbito1')}}" class="side-nav-link">
                            @include('.shared.svgs.__apoyos_sociales')
{{--                            @php $filters['filterdata']=""; @endphp--}}
                            @php session(['ambito_dependencia' => 1]); @endphp
                            <span
                                class="badge badge-light float-right">{{\App\Models\Denuncias\_viDDSs::query()->GetDenunciasAmbitoFilterCount($filters)->where('ambito_dependencia',1)->count()}}</span>
                            <span>Apoyos Soc.</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasRole('Administrator|SysOp|test_admin|SERVICIOS_MUNICIPALES'))
                    <li class="side-nav-item">
                        @php session(['ambito_dependencia' => 2]); @endphp
                        <a href="javascript: void(0);" class="side-nav-link">
                            @include('.shared.svgs.__servicios_municipales')
{{--                            @php $filters['filterdata']=""; @endphp--}}
                            <span> Serv. Mun. </span>
                            <span class="badge badge-light float-right mr-3">{{\App\Models\Denuncias\_viDDSs::query()->GetDenunciasAmbitoFilterCount($filters)->where('ambito_dependencia',2)->count()}}</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="side-nav-second-level" aria-expanded="false">
                            <li>
                                <a href="{{route('listDenunciasAmbito2')}}">
{{--                                    @php $filters['filterdata']=""; @endphp--}}
                                    <i class="mdi dripicons-archive"></i>
                                    <span
                                        class="badge badge-light float-right">{{\App\Models\Denuncias\_viDDSs::query()->GetDenunciasAmbitoFilterCount($filters)->where('ambito_dependencia',2)->count()}}</span>
                                    <span>Todas</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('listDenunciasAmbito16')}}">
{{--                                    @php $filters['filterdata']=""; @endphp--}}
                                    <i class="mdi dripicons-archive"></i>
                                    <span
                                        class="badge badge-light float-right">{{\App\Models\Denuncias\_viDDSs::query()->GetDenunciasEstatusAmbitoFilterCount($filters)->where('ambito_dependencia',2)->where('ue_id',16)->count()}}</span>
                                    <span>Recibidas</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{route('listDenunciasAmbito19')}}" >
{{--                                    @php $filters['filterdata']=""; @endphp--}}
                                    <i class="mdi dripicons-archive"></i>
                                    <span>En proceso</span>
                                    <span class="badge badge-light float-right mr-4">{{$tProObs}}</span>
                                    <span class="menu-arrow "></span>
                                </a>
                                <ul class="side-nav-three-level" aria-expanded="false">
                                    <li >
                                        <a href="{{route('listDenunciasAmbito19')}}">
{{--                                            @php $filters['filterdata']=""; @endphp--}}
{{--                                            <i class="mdi dripicons-archive"></i>--}}
                                            <span class="badge badge-light float-right">{{$enproceso}}</span>
                                            <span class="ml-4">En proceso</span>
                                        </a>
                                    </li>
                                    <li >
                                        <a href="{{route('listDenunciasAmbito18')}}">
{{--                                            @php $filters['filterdata']=""; @endphp--}}
{{--                                            <i class="mdi dripicons-archive"></i>--}}
                                            <span
                                                class="badge badge-light float-right">{{$observadas}}</span>
                                            <span class="ml-4">Observadas</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{route('listDenunciasAmbito17')}}">
{{--                                    @php $filters['filterdata']=""; @endphp--}}
                                    <i class="mdi dripicons-archive"></i>
                                    <span>Atendidas</span>
                                    <span class="badge badge-light float-right mr-4">{{$tAtCer}}</span>
                                    <span class="menu-arrow "></span>
                                </a>
                                <ul class="side-nav-three-level" aria-expanded="false">
                                    <li >
                                        <a href="{{route('listDenunciasAmbito17')}}">
{{--                                            @php $filters['filterdata']=""; @endphp--}}
{{--                                            <i class="mdi dripicons-archive"></i>--}}
                                            <span
                                                class="badge badge-light float-right">{{\App\Models\Denuncias\_viDDSs::query()->GetDenunciasEstatusAmbitoFilterCount($filters)->where('ambito_dependencia',2)->where('ue_id',17)->count()}}</span>
                                            <span class="ml-4">Atendidas</span>
                                        </a>
                                    </li>
                                    <li >
                                        <a href="{{route('listDenunciasAmbito21')}}">
{{--                                            @php $filters['filterdata']=""; @endphp--}}
{{--                                            <i class="mdi dripicons-archive"></i>--}}
                                            <span class="badge badge-light float-right">{{$cerradas}}</span>
                                            <span class="ml-4">Cerradas</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{route('listDenunciasAmbito20')}}">
{{--                                    @php $filters['filterdata']=""; @endphp--}}
                                    <i class="mdi dripicons-archive"></i>
                                    <span class="badge badge-light float-right mr-4">{{ $tRechCer }}</span>
                                    <span class="menu-arrow "></span>
                                    <span>Rechazadas</span>
                                </a>
                                <ul class="side-nav-three-level" aria-expanded="false">
                                    <li >
                                        <a href="{{route('listDenunciasAmbito20')}}">
{{--                                            @php $filters['filterdata']=""; @endphp--}}
{{--                                            <i class="mdi dripicons-archive"></i>--}}
                                            <span
                                                class="badge badge-light float-right">{{ $rechazadas }}</span>
                                            <span class="ml-4">Rechazadas</span>
                                        </a>
                                    </li>
                                    <li >
                                        <a href="{{route('listDenunciasAmbito22')}}">
{{--                                            @php $filters['filterdata']=""; @endphp--}}
{{--                                            <i class="mdi dripicons-archive"></i>--}}
                                            <span class="badge badge-light float-right">{{$cerradas_rechazadas}}</span>
                                            <span class="ml-4">Cerradas P/R</span>
                                        </a>
                                    </li>
                                </ul>

                            </li>
                        </ul>
                    </li>
                @endif


                @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                    <li class="side-nav-item">
                        <a href="javascript: void(0);" class="side-nav-link">
                            @include('.shared.svgs.__estructura')
                            <span> Estructura </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="side-nav-second-level" aria-expanded="false">
                            @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                                <li>
                                    <a href="{{route('listDependencias')}}">
                                        <i class="mdi mdi-account-multiple-outline"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Dependencia::count()}}</span>--}}
                                        <span>Unidades Administrativas</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator|SysOp'))
                                <li>
                                    <a href="{{route('listAreas')}}">
                                        <i class="mdi mdi-account-group"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Area::count()}}</span>--}}
                                        <span>Áreas</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator|SysOp'))
                                <li>
                                    <a href="{{route('listSubareas')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Subarea::count()}}</span>--}}
                                        <span>Subareas</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                                <li>
                                    <a href="{{route('listEstatus')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Estatu::count()}}</span>--}}
                                        <span>Status</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator|SysOp'))
                                <li>
                                    <a href="{{route('listMedidas')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Medida::count()}}</span>--}}
                                        <span>Medidas</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                                <li>
                                    <a href="{{route('listOrigenes')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Origen::count()}}</span>--}}
                                        <span>Fuentes de Captación</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                                <li>
                                    <a href="{{route('listPrioridades')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Prioridad::count()}}</span>--}}
                                        <span>Prioridades</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                                <li>
                                    <a href="{{route('listServicios')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Servicio::count()}}</span>--}}
                                        <span>Servicios</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator|SysOp|test_admin'))
                                <li>
                                    <a href="{{route('listServiciosCategorias')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                                <span class="badge badge-light float-right">{{\App\Models\Catalogos\ServicioCategoria::count()}}</span>--}}
                                        <span>Categorías de Servicios</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                @if(Gate::check('all') || Gate::check('test_admin'))
                    <li class="side-nav-item">
                        <a href="javascript: void(0);" class="side-nav-link">
                            @include('.shared.svgs.__domicilio')
                            <span> Domicilios </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="side-nav-second-level" aria-expanded="false">
                            @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                                <li>
                                    <a href="{{route('listCalles')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Calle::count()}}</span>--}}
                                        <span>Calles</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                                <li>
                                    <a href="{{route('listCiudades')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Ciudad::count()}}</span>--}}
                                        <span>Ciudad</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator'))
                                <li>
                                    <a href="{{route('listLocalidades')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Localidad::count()}}</span>--}}
                                        <span>Localidades</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator'))
                                <li>
                                    <a href="{{route('listMunicipios')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Municipio::count()}}</span>--}}
                                        <span>Municipios</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator'))
                                <li>
                                    <a href="{{route('listEstados')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Estado::count()}}</span>--}}
                                        <span>Estados</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                                <li>
                                    <a href="{{route('listCodigopostales')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Codigopostal::count()}}</span>--}}
                                        <span>Códigos Postales</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator'))
                                <li>
                                    <a href="{{route('listTipocomunidades')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Tipocomunidad::count()}}</span>--}}
                                        <span>Tipo Comunidades</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                                <li>
                                    <a href="{{route('listComunidades')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Comunidad::count()}}</span>--}}
                                        <span>Comunidades</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                                <li>
                                    <a href="{{route('listColonias')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Colonia::count()}}</span>--}}
                                        <span>Colonias</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                                <li>
                                    <a href="{{route('listUbicaciones')}}">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{--                            <span class="badge badge-light float-right">{{\App\Models\Catalogos\Domicilios\Ubicacion::count()}}</span>--}}
                                        <span>Ubicaciones</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
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

                @if (Auth::user()->hasRole('Administrator|SysOp|test_admin') || Auth::user()->can('asignar_roles'))
                    <li class="side-nav-item">
                        <a href="javascript: void(0);" class="side-nav-link">
                            <i class="fas fa-users"></i>
                            <span> Asignaciones</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="side-nav-second-level" aria-expanded="false">
                            <li>
                                <a href="{{route('asignaRoleList',['Id'=>0])}}">
                                    <i class="fas fa-users-cog"></i>
                                    {{--                                <span class="badge badge-light float-right">{{\App\Role::count()}}</span>--}}
                                    <span>Roles</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('asignaPermissionList',['Id'=>0])}}">
                                    <i class="fas fa-user-cog"></i>
                                    {{--                                <span class="badge badge-light float-right">{{\App\Permission::count()}}</span>--}}
                                    <span>Permisos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('asignaDependenciaList',['Id'=>0])}}">
                                    <i class="fas fa-user-cog"></i>
                                    {{--                                <span class="badge badge-light float-right">{{\App\Models\Catalogos\Dependencia::count()}}</span>--}}
                                    <span>Unidades Administrativas</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('asignaEstatusList',['Id'=>0])}}">
                                    <i class="fas fa-user-cog"></i>
                                    {{--                                <span class="badge badge-light float-right">{{\App\Models\Catalogos\Estatu::count()}}</span>--}}
                                    <span>Estatus</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('asignaServCatList',['Id'=>0])}}">
                                    <i class="fas fa-user-cog"></i>
                                    {{--                                <span class="badge badge-light float-right">{{\App\Models\Catalogos\ServicioCategoria::count()}}</span>--}}
                                    <span>Categoría de Servicios</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('asignaOrigenesList',['Id'=>0])}}">
                                    <i class="fas fa-user-cog"></i>
                                    {{--                                <span class="badge badge-light float-right">{{\App\Models\Catalogos\Origen::count()}}</span>--}}
                                    <span>Fuentes de Captación</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('asignaPrioridadesList',['Id'=>0])}}">
                                    <i class="fas fa-user-cog"></i>
                                    <span>Prioridades</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('asignaServiciosList',['Id'=>0])}}">
                                    <i class="fas fa-user-cog"></i>
                                    <span>Servicios</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li class="side-nav-item">
                    <a href="javascript: void(0);" class="side-nav-link">
                        @include('.shared.svgs.__configuraciones')
                        <span> Configuraciones </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="side-nav-second-level" aria-expanded="false">
                        @if (Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE'))
                            <li>
                                <a href="{{route('listUsers')}}">

                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20"
                                         height="18"
                                         viewBox="0 0 141.7 141.7" style="enable-background:new 0 0 141.7 141.7;"
                                         xml:space="preserve">
                                    <g id="Capa_1">
                                        <path fill="#948550" d="M1,131v-30.6c0-4.1,1-7.9,2.9-11.2c1.9-3.4,4.5-5.9,7.9-7.5c7.7-3.8,14.6-6.5,20.8-8.1c6.2-1.7,12.5-2.5,19.1-2.5
                                            s12.9,0.8,19,2.5c6.1,1.7,13,4.4,20.7,8.1c3.4,1.7,6,4.2,8,7.5c2,3.4,2.9,7.1,2.9,11.2V131H1z M111.9,131v-30.6
                                            c0-7.4-1.7-13.5-5.1-18.3c-3.4-4.8-7.8-8.6-13.3-11.6c7.3,0.9,14.1,2.3,20.6,4.2c6.4,1.8,11.7,3.9,15.7,6.3c3.5,2.2,6.2,5,8.2,8.3
                                            s3,7,3,11.2V131H111.9z M51.7,60.2c-7,0-12.7-2.5-17.1-7.4s-6.7-11.3-6.7-19.1s2.2-14.2,6.7-19.1s10.1-7.4,17.1-7.4
                                            s12.7,2.5,17.1,7.4s6.7,11.3,6.7,19.1s-2.2,14.2-6.7,19.1S58.6,60.2,51.7,60.2z M108.7,33.6c0,7.8-2.2,14.2-6.7,19.1
                                            s-10.1,7.4-17.1,7.4c-1.2,0-2.5-0.1-3.9-0.3c-1.4-0.2-2.7-0.5-3.9-1c2.5-3,4.5-6.6,5.8-10.9s2-9.1,2-14.4s-0.7-10-2-14.1
                                            s-3.2-7.8-5.8-11.2c1.2-0.4,2.5-0.6,3.9-0.9c1.4-0.2,2.7-0.4,3.9-0.4c7,0,12.7,2.5,17.1,7.4S108.7,25.8,108.7,33.6z M10.5,123.4
                                            h82.4v-23c0-1.9-0.5-3.7-1.5-5.5s-2.2-3-3.7-3.7c-7.6-3.8-14-6.3-19.2-7.6s-10.8-1.9-16.8-1.9S40,82.2,34.8,83.5
                                            s-11.6,3.8-19.2,7.6c-1.5,0.7-2.7,1.9-3.6,3.7s-1.4,3.6-1.4,5.5V123.4z M51.7,49.6c4.1,0,7.5-1.5,10.2-4.5c2.7-3,4-6.8,4-11.4
                                            s-1.3-8.4-4-11.4c-2.7-3-6.1-4.5-10.2-4.5s-7.5,1.5-10.2,4.5c-2.7,3-4,6.8-4,11.4s1.3,8.4,4,11.4C44.2,48,47.6,49.6,51.7,49.6z"/>
                                    </g>
                                        <g id="Capa_2"></g>
                                </svg>
                                    {{--                                <span class="badge badge-success float-right">{{\App\User::count()}}</span>--}}
                                    <span>Usuarios</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->hasRole('Administrator|test_admin'))
                            <li>
                                <a href="{{route('archivosConfig')}}">
                                    <i class="fas fa-file-excel"></i>
                                    <span>Formatos y datos abiertos</span>
                                </a>
                            </li>
                        @endif
                    </ul>

                </li>

                @if (Auth::user()->hasRole('Administrator|SysOp|USER_MOBILE_BASIC|USER_MOBILE_ADMIN') )
                    <li class="side-nav-item">
                        <a href="{{ url('listDenunciasMobile') }}" class="side-nav-link">
                            @include('.shared.svgs.__mobile')
                            <span
                                class="badge badge-light float-right">{{ \App\Models\Mobiles\Denunciamobile::count() }}</span>
                            <span>Mobile</span>
                        </a>
                    </li>
                @endif


            </ul>
            <div class="clearfix"></div>
            @include('partials.aviso-privacidad-panel')
            <div class="clearfix"></div>
            <div class="help-box text-white text-center">
                <img src="/assets/images/help-icon.svg" height="50" alt="Limpiar cache">
                <a href="https://www.hostinet.com/formacion/navegadores/como-vaciar-la-cache-en-chrome-edge-y-firefox-2022/"
                   target="_blank" class="btn btn-outline-light btn-sm mt-1">Limpiar cache</a>
            </div>
        @endguest
    </div>


</div>
