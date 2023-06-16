<div class="row">
    <div class="col-md-12 ">
        <div class="grid-container">
            <div class="form-group row mb-1">
                <label for = "dependencia_id" class="col-md-3 col-form-label">Dependencia</label>
                <div class="col-md-9">
                    <select id="dependencia_id" name="dependencia_id" class="form-control" size="1">
                        <option value="0" selected>Seleccione una Dependencia</option>
                        @foreach($dependencias as $t)
                            <option value="{{$t->id}}" >{{ $t->dependencia }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-1">
                <label for = "servicio_id" class="col-md-3 col-form-label">Servicio</label>
                <div class="col-md-9">
                    <select id="servicio_id" name="servicio_id" class="form-control" size="1">
                    </select>
                </div>
            </div>
            <div class="form-group row mb-1">
                <label for = "estatus_id" class="col-md-3 col-form-label">Estatus</label>
                <div class="col-md-5">
                    <select id="estatus_id" name="estatus_id" class="form-control" size="1">
                        @foreach($estatus as $t)
                            <option value="{{$t->id}}" {{ $t->isDefault() ? 'selected': '' }} >{{ $t->estatus }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-1">
                <label for = "observaciones" class="col-md-3 col-form-label">Observaciones</label>
                <div class="col-md-9">
                    <textarea id="estatus_id" name="observaciones" class="form-control" cols="10" rows="4" ></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="id" value="0" >
<input type="hidden" name="denuncia_id" value="{{ $items->id }}" >
<input type="hidden" name="creadopor_id" id="creadopor_id" value="{{$user->id}}" >
<hr>
