
<div class="form-group row mb-1">
    <label for = "search_autocomplete_calle" class="col-md-3 col-form-label">Calle</label>
    <div class="col-md-7">
        <div class="input-group">
            <input type="text" name="search_autocomplete_calle" id="search_autocomplete_calle" value="" placeholder="Buscar calle...." class="form-control"  >
        </div>

    </div>
    <div class="col-md-2">
        <a href="{{route("newCalle")}}" target="_blank" class="btn btn-icon btn-info " > <i class="mdi mdi-plus"></i></a>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "num_ext" class="col-md-3 col-form-label has-num_ext">Núm. Exterior</label>
    <div class="col-md-7">
        <input type="text" name="num_ext" id="num_ext" value="{{ old('num_ext') }}" class="form-control" />
        <span class="has-num_ext">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "num_int" class="col-md-3 col-form-label">Núm. Interior</label>
    <div class="col-md-7">
        <input type="text" name="num_int" id="num_int" value="{{ old('num_int') }}" class="form-control" />
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "colonia_id" class="col-md-3 col-form-label">Colonia</label>
    <div class="col-md-7">
        <select class="colonia_id form-control select2" data-toggle="select2" name="colonia_id" id="colonia_id" size="1">
            @foreach($colonias as $t)
                <option value="{{$t->id}}" {{ old('colonia_id') == $t->id ? ' selected ':''}}>{{ $t->colonia }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <a href="{{route("newColonia")}}" target="_blank" class="btn btn-icon btn-info " > <i class="mdi mdi-plus"></i></a>
    </div>

</div>

<input type="hidden" name="id" value="0" >
<input type="hidden" name="comun_id" id="comun_id" value="0" >
<input type="hidden" name="calle_id" id="calle_id" value="0" >

<hr>
