
<div class="form-group row mb-1">
    <label for = "estatus" class="col-md-2 col-form-label has-estatus">Status</label>
    <div class="col-md-9">
        <input type="text" name="estatus" id="estatus" value="{{ old('estatus',$items->estatus) }}" class="form-control" />
        <span class="has-estatus">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "abreviatura" class="col-md-2 col-form-label has-abreviatura">Abreviatura</label>
    <div class="col-md-9">
        <input type="text" name="abreviatura" id="abreviatura" value="{{ old('abreviatura',$items->abreviatura) }}" class="form-control" />
        <span class="has-abreviatura">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "dependencia_id" class="col-md-2 col-form-label has-dependencia_id">Unidad</label>
    <div class="col-md-7">
        <select class="dependencia_id form-control " data-toggle="select2"  name="dependencia_id" id="dependencia_id" size="1">
            <option value="0" selected>Ninguna</option>
            @foreach($dependencia as $t)
                <option value="{{$t->id}}" @if($t->id === $items->dependencia_id) selected @endif>{{ $t->dependencia }}</option>
            @endforeach
        </select>
        <span class="has-dependencia_id">
            <strong class="text-danger"></strong>
        </span>
    </div>
    <div class="col-md-2 text-right">
        <a class="btn btn-success btn-sm depToStatus " id="addDepEstatu-{{$items->id}}-999" href="#" role="button"><i class="fas fa-plus-circle"></i></a>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "dependencia_id" class="col-md-2 col-form-label">Unidades</label>
    <div class="col-md-9">
        <ul class="list-group">
            @foreach($items->dependencias as $t)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $t->dependencia.' '.$t->id }}
                    <a class="btn btn-danger btn-sm depToStatus" id="removeDepEstatu-{{$items->id}}-{{$t->id}}" href="#" role="button"><i class="fas fa-trash-alt"></i></a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "predeterminado" class="col-md-2 col-form-label">Default</label>
    <div class="col-md-2">
        <select class="predeterminado form-control " name="predeterminado" id="predeterminado" size="1">
            <option value="0">No</option>
            <option value="1" @if($items->isDefault()) selected @endif >Si</option>
        </select>
    </div>
    <label for = "resuelto" class="col-md-2 col-form-label">Evalua Resuelto</label>
    <div class="col-md-2">
        <select class="resuelto form-control " name="resuelto" id="resuelto" size="1">
            <option value="0">No</option>
            <option value="1" @if($items->isResuelto()) selected @endif >Si</option>
        </select>
    </div>
    <label for = "estatus_cve" class="col-md-2 col-form-label">Clave Estatus</label>
    <div class="col-md-2">
        <select class="estatus_cve form-control " name="estatus_cve" id="estatus_cve" size="1">
            <option value="0" @if( $items->estatus_cve === 0 ) selected @endif >Inactivo</option>
            <option value="1" @if( $items->estatus_cve === 1 ) selected @endif >Activo</option>
            <option value="2" @if( $items->estatus_cve === 2 ) selected @endif >Suspendido</option>
            <option value="3" @if( $items->estatus_cve === 3 ) selected @endif >Cancelado</option>
        </select>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "favorable" class="col-md-2 col-form-label">Es Favorable</label>
    <div class="col-md-2">
        <select class="favorable form-control " name="favorable" id="favorable" size="1">
            <option value="0" @if($items->isFavorable() === false) selected @endif >No</option>
            <option value="1" @if($items->isFavorable() === true) selected @endif >Si</option>
        </select>
    </div>
    <label for = "orden_impresion" class="col-md-2 col-form-label has-orden_impresion">Orden Imp.</label>
    <div class="col-md-2">
        <input type="number" name="orden_impresion" id="orden_impresion" min="0" max="99" value="{{ old('orden_impresion',$items->orden_impresion) }}" class="form-control" />
        <span class="has-orden_impresion">
            <strong class="text-danger"></strong>
        </span>
    </div>

    <label for = "ambito_estatus" class="col-md-2 col-form-label">Categoría</label>
    <div class="col-md-2">
        <select class=" form-control "  name="ambito_estatus" id="ambito_estatus" size="1">
            @foreach($ambito as $id => $valor)
                <option value="{{ $id }}" @if($id === $items->ambito_estatus) selected @endif>{{ $valor. ' '.$id }} </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row mb-1">
    <label for = "requiere_imagen" class="col-md-2 col-form-label">Tiene imagen</label>
    <div class="col-md-2">
        <select class="requiere_imagen form-control " name="requiere_imagen" id="requiere_imagen" size="1">
            <option value="0" @if($items->hasImagen() === false) selected @endif >No</option>
            <option value="1" @if($items->hasImagen() === true) selected @endif >Si</option>
        </select>
    </div>
</div>


<input type="hidden" name="id" value="{{$items->id}}" >

    <script type="text/javascript">

        if ( $(".depToStatus") ){
            $(".depToStatus").on('click',function (event) {
                var arrItem = event.currentTarget.id.split('-');
                var Url   = arrItem[0];
                var Id    = arrItem[1];
                var IdDep = parseInt(arrItem[2]) === 999 ? $("#dependencia_id").val() : arrItem[2];
                if (IdDep > 0){
                    $.get( "/"+Url+"/"+Id+"/"+IdDep , function( data ) {
                        data.mensaje === "OK" ? document.location.reload() : alert(data.mensaje);
                    }, "json" );
                }
            })
        }

    </script>
