
<div class="form-group row mb-1">
    <label for = "dependencia" class="col-md-3 col-form-label has-dependencia">Unidad</label>
    <div class="col-md-9">
        <input type="text" name="dependencia" id="dependencia" value="{{ old('dependencia',$items->dependencia) }}" class="form-control" />
        <span class="has-dependencia">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "abreviatura" class="col-md-3 col-form-label has-abreviatura">Abreviatura</label>
    <div class="col-md-9">
        <input type="text" name="abreviatura" id="abreviatura" value="{{ old('abreviatura',$items->abreviatura) }}" class="form-control" />
        <span class="has-abreviatura">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "class_css" class="col-md-3 col-form-label">Clase CSS</label>
    <div class="col-md-9">
        <input type="text" name="class_css" id="class_css" value="{{ old('class_css',$items->class_css) }}" class="form-control" />
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "visible_internet" class="col-md-3 col-form-label">Visible en Internet</label>
    <div class="col-md-9">
        <select class="visible_internet form-control select2" data-toggle="select2"  name="visible_internet" id="visible_internet" size="1">
            <option value="1" @if($items->isVisibleInternet()==true) selected @endif>SI</option>
            <option value="0" @if($items->isVisibleInternet()!==true) selected @endif>NO</option>
        </select>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "is_areas" class="col-md-3 col-form-label">Es un Área</label>
    <div class="col-md-9">
        <select class="is_areas form-control select2" data-toggle="select2"  name="is_areas" id="is_areas" size="1">
            <option value="1" @if($items->isArea()==true) selected @endif>SI</option>
            <option value="0" @if($items->isArea()!==true) selected @endif>NO</option>
        </select>
    </div>
</div>
<div class="form-group row mb-1">
    <label for = "ambito_dependencia" class="col-md-3 col-form-label">Categoría</label>
    <div class="col-md-9">
        <select class=" form-control "  name="ambito_dependencia" id="ambito_dependencia" size="1">
            @foreach($ambito as $id => $valor)
                <option value="{{ $id }}" @if($id === $items->ambito_dependencia) selected @endif>{{ $valor }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row mb-3">
    <label for = "jefe_id" class="col-md-3 col-form-label">Jefe</label>
    <div class="col-md-9">
        <select class="jefe_id form-control select2" data-toggle="select2"  name="jefe_id" id="jefe_id" size="1">
            @foreach($jefes as $t)
                <option value="{{$t->id}}" @if($t->id ==$items->jefe_id) selected @endif>{{ $t->fullname.' '.$t->username }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "dependencia_id" class="col-md-3 col-form-label">Unidades</label>
    <div class="col-md-9">
        <ul class="list-group">
            @foreach($items->estatus as $t)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $t->estatus}}
                    {{--@if($items->hasEstatus('XXXz|RECIBIDO'))--}}
                        {{--Ok!--}}
                    {{--@endif--}}
                </li>
            @endforeach
        </ul>
    </div>
</div>

<input type="hidden" name="id" value="{{$items->id}}" >
