@php use Illuminate\Support\Facades\Auth; @endphp
@if (
    (Auth::user()->hasRole('Administrator|SysOp|test_admin')) ||
    (Gate::check('all') || Gate::check('dashboard'))
     )
    @php
        $url = "home";
        if (Auth::user()->isPermission('all|dashboard_servicios_monitoreados')) {
            $url = 'dashboard-statistics-servicios-principales';
        }elseif (Auth::user()->isPermission('all|dashboard_general')) {
            $url = 'dashboard-statistics-general';
        }elseif (Auth::user()->isPermission('all|dashboard_alumbrado')) {
            $url = 'dashboard-statistics-custom-unity/46';
        }elseif (Auth::user()->isPermission('all|dashboard_espacios_publicos')) {
            $url = 'dashboard-statistics-custom-unity/49';
        }elseif (Auth::user()->isPermission('all|dashboard_limpia')) {
            $url = 'dashboard-statistics-custom-unity/50';
        }elseif (Auth::user()->isPermission('all|dashboard_obras_publicas')) {
            $url = 'dashboard-statistics-custom-unity/48';
        }elseif (Auth::user()->isPermission('all|dashboard_sas')) {
            $url = 'dashboard-statistics-custom-unity/47';
        }else $url = "home";
    @endphp
    <li class="side-nav-item">
        <a href="{{ url($url) }}" class="side-nav-link">
            {{--                        <a href="{{ url('dashboard-statistics-general') }}" class="side-nav-link">--}}
            @include('.shared.svgs.__dashboard')
            <span class="badge badge-light float-right"></span>
            <span>Dashboard</span>
        </a>
    </li>
@endif
