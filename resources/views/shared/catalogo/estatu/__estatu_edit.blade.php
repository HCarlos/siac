
<div class="form-group row mb-3">
    <label for = "estatus" class="col-md-3 col-form-label">Status</label>
    <div class="col-md-9">
        <input type="text" name="estatus" id="estatus" value="{{ old('estatus',$items->estatus) }}" class="form-control" />
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "dependencia_id" class="col-md-3 col-form-label">Dependencia</label>
    <div class="col-md-7">
        <select class="dependencia_id form-control select2" data-toggle="select2"  name="dependencia_id" id="dependencia_id" size="1">
            <option value="0" selected>Ninguna</option>
            @foreach($dependencia as $t)
                <option value="{{$t->id}}" @if($t->id == $items->dependencia_id) selected @endif>{{ $t->dependencia }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 text-right">
        <a class="btn btn-success btn-sm depToStatus " id="addDepEstatu-{{$items->id}}-999" href="#" role="button"><i class="fas fa-plus-circle"></i></a>
    </div>
</div>
<div class="form-group row mb-3">
    <label for = "dependencia_id" class="col-md-3 col-form-label">Dependencias</label>
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

<div class="form-group row mb-3">
    <label for = "predeterminado" class="col-md-3 col-form-label">Predeterminado</label>
    <div class="col-md-9">
        <select class="predeterminado form-control select2" name="predeterminado" id="predeterminado" size="1">
            <option value="0">No</option>
            <option value="1" @if($items->isDefault()) selected @endif >Si</option>
        </select>
    </div>
</div>

<input type="hidden" name="id" value="{{$items->id}}" >

<hr>
