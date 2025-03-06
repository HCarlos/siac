@foreach($menu as $m)
    @if ($m->index === 0 && Auth::user()->isPermission('all|dashboard_servicios_monitoreados') )
        <button class="{{ $m->clase }}" onclick="window.location.href='{{ $m->url }}'">{{ $m->title_menu }}</button>
    @endif
    @if ($m->index === 1 && Auth::user()->isPermission('all|dashboard_general') )
        <button class="{{ $m->clase }}" onclick="window.location.href='{{ $m->url }}'">{{ $m->title_menu }}</button>
    @endif
    @if ($m->index === 2 && Auth::user()->isPermission('all|dashboard_alumbrado') )
        <button class="{{ $m->clase }}" onclick="window.location.href='{{ $m->url }}'">{{ $m->title_menu }}</button>
    @endif
    @if ($m->index === 3 && Auth::user()->isPermission('all|dashboard_espacios_publicos') )
        <button class="{{ $m->clase }}" onclick="window.location.href='{{ $m->url }}'">{{ $m->title_menu }}</button>
    @endif
    @if ($m->index === 4 && Auth::user()->isPermission('all|dashboard_limpia') )
        <button class="{{ $m->clase }}" onclick="window.location.href='{{ $m->url }}'">{{ $m->title_menu }}</button>
    @endif
    @if ($m->index === 5 && Auth::user()->isPermission('all|dashboard_obras_publicas') )
        <button class="{{ $m->clase }}" onclick="window.location.href='{{ $m->url }}'">{{ $m->title_menu }}</button>
    @endif
    @if ($m->index === 6 && Auth::user()->isPermission('all|dashboard_sas') )
        <button class="{{ $m->clase }}" onclick="window.location.href='{{ $m->url }}'">{{ $m->title_menu }}</button>
    @endif
@endforeach


