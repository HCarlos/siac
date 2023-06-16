<h4 class="page-title">{{$titulo_catalogo}} <small>{{$titulo_header}}</small></h4>
<div class="mt-1 mb-1"></div>
<div class="row">

    <div class="col-md-4">
        <div class="card bg-light text-dark {{$altoPanelIzq}}">
            <div class="card-body">
                <strong class="panel-title">@isset($titleLeft0) {{ $titleLeft0 }} @endisset</strong>
                @isset($list0) {{ $list0 }} @endisset
                <span class="text-dark">Lista de Elementos <strong> @isset($countListEle) {{ $countListEle  }} @endisset </strong></span>
            </div>
        </div> <!-- end card-->
    </div><!-- end col -->

    <div class="col-md-2">
        <!-- Portlet card -->
        <div class="card bg-default text-white {{$altoPanelCen}} " >
            <div class="card-body">
                <div class="position-ref full-height" style="padding-top: 30vh">
                    @if ( Auth::User()->hasRole('Administrator|SysOp') || Auth::user()->can(['asignar','desasignar']) )
                        @isset($urlAsigna)
                            <button type="button" class="btn btn-block btn-primary btn-rounded btnAsign0" id="{{$urlAsigna.'-'.$urlRegresa}}">
                                Agregar <i class="fas fa-chevron-right"></i>
                            </button>
                        @endisset
                        @isset($urlElimina)
                            <button type="button" class="btn btn-block btn-sm btn-info btn-rounded btnUnasign0" id="{{$urlElimina.'-'.$urlRegresa}}">
                                <i class="fas fa-chevron-left"></i> Quitar
                            </button>
                        @endisset
                    @endif
                </div>
            </div>
        </div> <!-- end card-->
    </div><!-- end col -->

    <div class="col-md-6">
        <!-- Portlet card -->
        <div class="card bg-light text-white {{$altoPanelDer}}">
            <div class="card-body">
                <strong class="panel-title text-dark">@isset($titleUsuario0) {{ $titleUsuario0  }} @endisset</strong>
                @isset($usuario0) {{$usuario0}} @endisset
                <strong class="panel-title text-dark">@isset($titleAsign0) {{ $titleAsign0  }} @endisset</strong>
                @isset($Asign0) {{$Asign0}} @endisset
                <span class="text-dark">Lista de Elementos <strong id="totalRolesUsuarios"> @isset($countAsign0) {{ $countAsign0  }} @endisset </strong></span>
            </div>
        </div> <!-- end card-->
    </div><!-- end col -->
</div>

@section("script_extra")
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('/js/servimun.autocomplete.js')}}?time()"></script>
@endsection
