@isset($searchInList)
    <form method="get" action="{{ route($searchInList) }}" class="form-inline frmSearchInList float-right">
        <div class="app-search">
            <div class="input-group">
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar...">
                <span class="mdi mdi-magnify"></span>
                <div class="input-group-append">
                    <button class="btn btn-sm btn-primary" type="submit">Buscar</button>
                </div>
            </div>
        </div>

        @include('shared.ui_kit.___popup_roles')

    </form>
@endisset
