<div class="form-row mb-1">
    <label for = "curp" class="col-md-2 col-form-label">CURP</label>
    <div class="col-md-4">
        <input type="text" name="curp" id="curp" value="{{ old('curp') }}" class="form-control" />
    </div>
    <label for = "id" class="col-md-1 col-form-label text-right">ID </label>
    <div class="col-md-5">
        <input type="text" name="id" id="id" value="{{ old('id') }}" class="form-control" />
    </div>
</div>

<div class="form-row mb-1">
    <label for = "ciudadano" class="col-md-2 col-form-label">Nombre Completo</label>
    <div class="col-md-4">
        <input type="text" name="ciudadano" id="ciudadano" value="{{ old('ciudadano') }}" class="form-control" />
    </div>
{{--    <label for = "uuid" class="col-md-1 col-form-label text-right">UUID</label>--}}
{{--    <div class="col-md-5">--}}
{{--        <input type="text" name="uuid" id="uuid" value="{{ old('uuid') }}" class="form-control" />--}}
{{--    </div>--}}
    <label for = "ciudadano_id" class="col-md-1 col-form-label text-right">Usuario ID</label>
    <div class="col-md-5">
        <input type="text" name="ciudadano_id" id="ciudadano_id" value="{{ old('ciudadano_id') }}" class="form-control" />
    </div>
</div>

<div class="form-row mb-1">
        <label for="desde" class="col-md-2 col-form-label">Desde</label>
        <div class="col-md-4">
{{--            {{ Form::date('desde', \Carbon\Carbon::now(), ['id'=>'desde','class'=>'form-control']) }}--}}
            <input type="date" name="desde" id="desde" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control">
        </div>
        <label for="hasta" class="col-md-1 col-form-label text-right">Hasta</label>
        <div class="col-md-3">
{{--            {{ Form::date('hasta', \Carbon\Carbon::now(), ['id'=>'hasta','class'=>'form-control']) }}--}}
            <input type="date" name="hasta" id="hasta" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control">
        </div>
        <div class="col-md-1 ">
            <div class="custom-control custom-checkbox mt-1 float-left">
                <input type="checkbox" class="custom-control-input" id="incluirFecha" name="incluirFecha">
                <label class="custom-control-label" for="incluirFecha">Incluir</label>
            </div>
        </div>
</div>

<div class="form-row mb-1">
    <label for = "dependencia_id" class="col-md-2 col-form-label">Dependencia</label>
    <div class="col-md-8">
        <select id="dependencia_id" name="dependencia_id" class="form-control" size="1">
{{--            @if ( !Auth::user()->isRole('ENLACE') )--}}
                <option value="0" selected >Seleccione una Dependencia</option>
{{--            @endif--}}
            @foreach($dependencias as $id => $valor)
                <option value="{{ $id }}">{{ $valor }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 ">
        <div class="custom-control custom-checkbox mt-1 float-left">
            <input type="checkbox" class="custom-control-input" id="conRespuesta" name="conRespuesta">
            <label class="custom-control-label" for="conRespuesta">Con Respuesta</label>
        </div>
    </div>
</div>

<div class="form-row mb-1">
    <label for = "servicio_id" class="col-md-2 col-form-label">Servicio</label>
    <div class="col-md-10">
        <select id="servicio_id" name="servicio_id" class="form-control" size="1">
            <option value="" selected >Seleccione un Servicio</option>
            @foreach($servicios as $id => $valor)
                <option value="{{ $id }}">{{ $valor }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-row mb-1">
    <label for = "origen_id" class="col-md-2 col-form-label">Origen</label>
    <div class="col-md-4">
        <select id="origen_id" name="origen_id" class="form-control" size="1">
            <option value="0" selected >Seleccione un Origen</option>
            @foreach($origenes as $t)
                <option value="{{ $t->id }}">{{ $t->origen }} </option>
            @endforeach
        </select>
    </div>
    <label for = "estatus_id" class="col-md-1 col-form-label text-right">Estatus</label>
    <div class="col-md-5">
        <select id="estatus_id" name="estatus_id" class="form-control" size="1">
            <option value="0" selected >Seleccione un Estatus</option>
            @foreach($estatus as $t)
                <option value="{{ $t->id }}">{{ $t->estatus }} </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-row mb-1">
    <label for = "creadopor_id" class="col-md-2 col-form-label">Creado Por:</label>
    <div class="col-md-10">
        <select id="creadopor_id" name="creadopor_id" class="form-control" size="1">
            <option value="0" selected >Seleccione un Usuario</option>
            @foreach($capturistas as $id => $valor)
                <option value="{{ $id }}">{{ $valor }}</option>
            @endforeach
        </select>
    </div>
{{--    <label for = "id" class="col-md-2 col-form-label text-right">ID </label>--}}
{{--    <div class="col-md-2">--}}
{{--        <input type="text" name="id" id="id" value="{{ old('id') }}" class="form-control" />--}}
{{--    </div>--}}
</div>

<div class="form-row mb-1">
    <label for = "clave_identificadora" class="col-md-2 col-form-label text-left">Cve Identificadora</label>
    <div class="col-md-4">
        @if ( Auth::user()->hasAnyPermission(['seleccionar_hashtag']) )
        <select id="clave_identificadora" name="clave_identificadora" class="form-control" size="1">
            <option value="" selected >Seleccione una Clave</option>
            @foreach($hashtag as $id => $valor)
                <option value="{{ $id }}">{{ $valor }}</option>
            @endforeach
        </select>
        @else
            <input type="text" name="clave_identificadora" id="clave_identificadora" value="{{ old('clave_identificadora') }}" class="form-control" />
        @endif
    </div>
    <div class="col-md-6 ">
        <div class="custom-control custom-checkbox mt-1 float-left">
            <input type="checkbox" class="custom-control-input" id="incluirFechaMovto" name="incluirFechaMovto">
            <label class="custom-control-label" for="incluirFechaMovto">Buscar en Fecha Movto</label>
        </div>
    </div>

</div>



<hr>
<div class="form-row mb-1">
    <label for = "items_for_query" class="col-md-2 col-form-label">Regs. consulta</label>
    <div class="col-md-10">
        <select id="items_for_query" name="items_for_query" class="form-control" size="1">
            <option value="250" selected >250</option>
            <option value="500" >500</option>
            <option value="750" >750</option>
            <option value="1000">1000</option>
            <option value="1250">1250</option>
            <option value="1500">1500</option>
            <option value="1750">1750</option>
            <option value="2000">2000</option>
            <option value="2250">2250</option>
            <option value="2500">2500</option>
            <option value="2750">2750</option>
            <option value="3000">3000</option>
            <option value="3250">3250</option>
            <option value="3500">3500</option>
        </select>
        <small class="text-muted">La cantidad de registros, es directamente proporcional al tiempo que tarda la consulta.</small>
    </div>
{{--    <label for = "formato" class="col-md-2 col-form-label">Formato de Salida</label>--}}
{{--    <div class="col-md-4">--}}
{{--        <select id="formato" name="formato" class="form-control " size="1">--}}
{{--            @foreach(config("atemun.menu_archivos") as $id => $valor)--}}
{{--                <option value="{{ $valor }}">{{ $id }}</option>--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--    </div>--}}
</div>

@section("script_extra")
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script >
        jQuery(function($) {
            $(document).ready(function () {

                // $("#dependencia_id").on("change",function (event) {
                //     var Id = event.currentTarget.value;
                //     $("#servicio_id").empty();
                //     $.get( "/getServiciosFromDependencias/"+Id, function( data ) {
                //         $("#servicio_id").empty();
                //         if ( data.data.length > 0 ){
                //             $.each(data.data, function(i, item) {
                //                 $("#servicio_id").append('<option value="'+item.id+'" > '+item.servicio+'</option>');
                //             });
                //         }
                //     }, "json" );
                // });


                // alert("Hola le Monde");


            });
        });

@endsection
