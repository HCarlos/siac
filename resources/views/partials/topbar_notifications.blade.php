@php
    $IsEnlace = Session::get('IsEnlace');
    $DependenciaIdArray = Session::get('DependenciaIdArray');
    $Dependencias = App\Models\Catalogos\Dependencia::all()->whereIn('id',$DependenciaIdArray,false)->sortBy('dependencia')->pluck('id')->toJson();
@endphp
@if( $IsEnlace )
<li class="dropdown notification-list drop-notification-list" id="getNotificationDependencias*{{ $Dependencias }}" >
    <a class="nav-link dropdown-toggle nav-user arrow-none mr-0 bgc-success" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
       aria-expanded="false" style="background-color: darkseagreen">
        <i class="fa fa-bell text-lg text-white icon-animated-bell mr-lg-2" style="font-size: 24px"></i>
        <span id="id-navbar-badge1" class="badge badge-lg bgc-warning text-white radius-round border-1 brc-success-tp5" style="background-color: palevioletred; font-size: 16px"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-lg dropdown-menu-animated brc-primary-m3 " id="dropMenu" >
{{--        <a href="#" class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary" style="background-color: thistle">--}}
{{--            <div>--}}
{{--                <span class="text-primary-m1 font-bolder">Alex:</span>--}}
{{--                <span class="text-grey text-90">Ciao sociis natoque penatibus et auctor ...</span>--}}
{{--                <br />--}}
{{--                <span class="text-grey-m1 text-85">--}}
{{--                    <i class="far fa-clock"></i>--}}
{{--                    a moment ago--}}
{{--                </span>--}}
{{--            </div>--}}
{{--        </a>--}}
    </div>
</li>
@endif
