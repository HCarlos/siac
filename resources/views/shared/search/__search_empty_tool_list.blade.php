@isset($searchEmptyTool)
<form method="get" action="{{ route($searchEmptyTool) }}" class="form-inline frmSearchInList float-right">
    <div class="app-search">
        <div class="input-group">
            <input type="search" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar...">
            <span class="mdi mdi-magnify"></span>
            <div class="input-group-append">
                <button class="btn btn-sm btn-primary" type="submit">Buscar--</button>
            </div>
            <input type="hidden" name="role_user" id="role_user" value="{{ $role_user }}"/>
        </div>
    </div>
</form>
@endisset
