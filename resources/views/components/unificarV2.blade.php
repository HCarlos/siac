<h4 class="page-title">{{$titulo_catalogo}} <small>{{$titulo_header}}</small></h4>
<div class="mt-1 mb-1"></div>
<div class="row">

    <div class="col-md-4">
        <div class="card bg-light text-dark {{$altoPanelIzq}}">

            <div class="card-body">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="text" id="buscar_dato_a_unificar" name="buscar_dato_a_unificar" value="" class="form-control col-md-10 d-inline-block" placeholder="Buscar dato...">
                        <span class="form-text d-inline-block ml-0 col-md-1">
                        <a href="#" class="btn btn-sm btn-info btn-bold brc-white-tp3 shadow-sm radius-round text-125 px-25 buscarDatoDom" ><i class="fa fa-search"></i> </a>
                    </span>
                    </div>
                </div>

                <strong class="panel-title">@isset($titleLeft0) {{ $titleLeft0 }} @endisset</strong>
                @isset($list0) {{ $list0 }} @endisset
                <span class="text-dark">Lista de Elementos: <strong id="totalItemsUnificar" class="text-primary-dark"></strong></span>
            </div>
        </div> <!-- end card-->
    </div><!-- end col -->

    <div class="col-md-2">
        <!-- Portlet card -->
        <div class="card bg-default text-white {{$altoPanelCen}} " >
            <div class="card-body">
                <div class="position-ref full-height" style="padding-top: 30vh">
                    @if (Auth::user()->hasAnyPermission(['all', 'unificar']) )
                        @isset($urlUnifica)
                            <button type="button" class="btn btn-block btn-primary btn-rounded btnUnifica" id="{{$urlUnifica.'-'.$urlRegresa}}">
                                Unificar <i class="fas fa-chevron-right"></i>
                            </button>
                        @endisset
{{--                        @isset($urlElimina)--}}
{{--                            <button type="button" class="btn btn-block btn-sm btn-info btn-rounded btnUnasign0" id="{{$urlElimina.'-'.$urlRegresa}}">--}}
{{--                                <i class="fas fa-chevron-left"></i> Quitar--}}
{{--                            </button>--}}
{{--                        @endisset--}}
                    @endif
                </div>
            </div>
        </div> <!-- end card-->
    </div><!-- end col -->

    <div class="col-md-6">
        <!-- Portlet card -->
        <div class="card bg-light text-white {{$altoPanelDer}}">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="text" id="buscar_dato_a_unificar_otro" name="buscar_dato_a_unificar_otro" value="" class="form-control col-md-10 d-inline-block" placeholder="Buscar dato...">
                        <span class="form-text d-inline-block ml-0 col-md-1">
                        <a href="#" class="btn btn-sm btn-info btn-bold brc-white-tp3 shadow-sm radius-round text-125 px-25 buscarDatoDomOtro" ><i class="fa fa-search"></i> </a>
                    </span>
                    </div>
                </div>
                <strong class="panel-title text-dark">@isset($titleAsign0) {{ $titleAsign0  }} @endisset</strong>
                @isset($Asign0) {{$Asign0}} @endisset
                <span class="text-dark">Lista de Elementos <strong id="totalRolesUsuarios"> @isset($countAsign0) {{ $countAsign0  }} @endisset </strong></span>
            </div>
        </div> <!-- end card-->
    </div><!-- end col -->
</div>
<input type="hidden" name="catalogo_id" id="catalogo_id" value="{{$catalogo_id}}">
@section("script_extra")
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('/js/servimun.autocomplete_unificar.js')}}?time()"></script>
@endsection
