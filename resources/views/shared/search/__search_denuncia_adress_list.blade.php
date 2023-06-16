@isset($titulo_catalogo)
    <h4 class="page-title-box pt-3 float-left">
        {{$titulo_catalogo}}
        <small>
            @isset($titulo_header)
                {{$titulo_header}}
            @endisset
        </small>
    </h4>
@endisset
@isset($searchAdressDenuncia)
<form method="get" action="{{ route($searchAdressDenuncia) }}" class="form-inline frmGetItems float-right">
    <div class="app-search">
        <div class="input-group">
            <input type="search" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por: Solicitud, Referencia, Calle, Colonia, Localidad" title="Buscar por: Solicitud, Referencia, Calle, Colonia, Localidad">
            <span class="mdi mdi-magnify"></span>
            <div class="input-group-append">
                <button class="btn btn-sm btn-primary" type="submit">Buscar</button>
            </div>
        </div>
    </div>
</form>
@endisset
