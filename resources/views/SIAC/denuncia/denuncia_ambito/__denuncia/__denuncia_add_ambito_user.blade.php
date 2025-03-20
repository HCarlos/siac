<div class="col-lg-12">
    <div class="row">
        <div class="form-row mb-1">
            <p><strong class="text-cafe">SOLICITUD: </strong>
            {{$items->descripcion}} <br><br>
            <strong class="text-cafe">REFERENCIA:</strong>
            {{$items->referencia.'  '.$items->observaciones}}</p>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="row">
        <div class="form-row mb-1">
            <label for = "search_autocomplete_user" class="col-lg-3 col-form-label labelDenuncia">Buscar Usuario</label>
                <div class="input-group">
                   <input type="text" name="search_autocomplete_user" id="search_autocomplete_user" placeholder="Buscar usuario..." value="" class="form-control">
                    <span class="input-group-append">
                        <a href="{{route("newUser")}}" target="_blank" class="btn btn-icon btn-info"> <i class="mdi mdi-plus"></i></a>
                    </span>
                </div>
                <div class="input-group btn-group-xs">
                    <input type="text" name="usuario" id="usuario" placeholder="Buscar usuario..." value="" class="form-control" readonly>
                    <span class="input-group-append">
                        <a  target="_blank" class="btn btn-xs btn-icon btn-primary editUser" id="editUser" name="editUser"> <i class="mdi mdi-account-edit  text-white"></i></a>
                    </span>
                </div>
                <input type="text" name="usuario_domicilio" id="usuario_domicilio" value="" class="form-control" readonly>
            <input type="text" name="usuario_telefonos" id="usuario_telefonos" value="" class="form-control" readonly>
        </div>
    </div>
</div>

<input type="hidden" name="id" id="id" value="{{$items->id}}" >
<input type="hidden" name="usuario_id" id="usuario_id" value="0" >

<hr>
