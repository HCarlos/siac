
<div class="form-group row mb-1">
    <label for = "calle_id" class="col-md-3 col-form-label">Calle</label>
    <div class="col-md-7">
        <div class="input-group">
{{--            {!! Form::text('search_autocomplete_calle', null, array('placeholder' => 'Buscar calle...','class' => 'form-control','id'=>'search_autocomplete_calle')) !!}--}}
            <input type="text" name="search_autocomplete_calle" id="search_autocomplete_calle" value="{{ old('search_autocomplete_calle') }}" placeholder="'Buscar calle..." class="form-control">
        </div>
    </div>
    <div class="col-md-2">
{{--        <a href="{{route("newCalle")}}" target="_blank" class="btn btn-icon btn-info " > <i class="mdi mdi-plus"></i></a>--}}
                <a href="{{ route("newCalleV2") }}" id="{{ route("newCalleV2") }}" class="btn btn-icon btn-info btnFullModal" data-toggle="modal" data-target="#modalFull" title="Agregar Calle" >
                    <i class="mdi mdi-plus"></i>
                </a>

    </div>
</div>
<div class="form-group row mb-1">
    <label for = "num_ext" class="col-md-3 col-form-label {{$errors->has('num_ext')?'text-danger':''}}">Núm. Exterior</label>
    <div class="col-md-7">
        <input type="text" name="num_ext" id="num_ext" value="{{ old('num_ext') }}" class="form-control {{$errors->has('num_ext')?'has-error form-error':''}}" />
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "num_int" class="col-md-3 col-form-label">Núm. Interior</label>
    <div class="col-md-7">
        <input type="text" name="num_int" id="num_int" value="{{ old('num_int') }}" class="form-control" />
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "search_autocomplete_colonia" class="col-md-3 col-form-label">Colonia</label>
    <div class="col-md-7">
        <div class="input-group">
            <input type="text" name="search_autocomplete_colonia" id="search_autocomplete_colonia" value="{{ old('search_autocomplete_colonia') }}" placeholder="'Buscar colonia..." class="form-control">
        </div>
    </div>
    <div class="col-md-2">
        <a href="{{route("newColonia")}}" target="_blank" class="btn btn-icon btn-info " > <i class="mdi mdi-plus"></i></a>
    </div>

</div>



<input type="hidden" name="id" value="0" >
<input type="hidden" name="comun_id" id="comun_id" value="0" >
<input type="hidden" name="calle_id" id="calle_id" value="0" >
<input type="hidden" name="colonia_id" id="colonia_id" value="0" >

<hr>
