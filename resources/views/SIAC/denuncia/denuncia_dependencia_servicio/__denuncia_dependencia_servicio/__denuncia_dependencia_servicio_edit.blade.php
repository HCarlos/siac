<div class="row">
    <div class="col-md-12 ">
        <div class="grid-container">
            <div class="form-group row mb-1">
                <label for = "dependencia_id" class="col-md-3 col-form-label">Dependencia</label>
                <div class="col-md-9">
                    <select name="dependencia_id" class="form-control dependencia_status_id" size="1">
                        @foreach($dependencias as $t)
                            <option value="{{$t->id}}" {{ $t->id == $items->dependencia_id  ? 'selected': '' }} >{{ $t->dependencia }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-1">
                <label for = "servicio_id" class="col-md-3 col-form-label">Servicio</label>
                <div class="col-md-9">
                    <select id="servicio_id" name="servicio_id" class="form-control" size="1">
                        @foreach($servicios as $t)
{{--                            <option value="{{$t->id}}" {{ $t->id == $items->servicio_id  ? 'selected': '' }} >{{ $t->servicio }} </option>--}}
                            <option value="{{$t->id}}" {{ $t->id == $items->servicio_id  ? 'selected': '' }} >{{ $t->servicio }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-1">
                <label for = "estatus_id" class="col-md-3 col-form-label">Estatus</label>
                <div class="col-md-5">
                    <select id="estatus_id" name="estatus_id" class="form-control" size="1">
                        @foreach($estatus as $t)
                            <option value="{{$t->id}}" {{ $t->id == $items->estatu_id  ? 'selected': '' }} >{{ $t->estatus }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-1">
                <label for = "favorable" class="col-md-3 col-form-label">Favorable</label>
                <div class="col-md-5">
                    <select id="favorable" name="favorable" class="form-control" size="1">
                        <option value="0" @if($items->favorable == false) selected @endif>NO</option>
                        <option value="1" @if($items->favorable == true) selected @endif>SI</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-1">
                <label for = "observaciones" class="col-md-3 col-form-label">Argumentos</label>
                <div class="col-md-9">
                    <textarea id="observaciones" name="observaciones" class="form-control" cols="10" rows="4" >{{$items->observaciones}}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="id" value="{{$Id}}" >
<input type="hidden" name="denuncia_id" id="denuncia_id" value="{{ $items->denuncia_id }}" >
<input type="hidden" name="creadopor_id" id="creadopor_id" value="{{$user->id}}" >
<hr>
