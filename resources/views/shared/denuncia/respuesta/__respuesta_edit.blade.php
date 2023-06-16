<div class="form-row mb-1">
    <label for = "fecha" class="col-md-2 col-form-label">Fecha </label>
    <div class="col-md-4">
{{--        {{ Form::date('fecha', Carbon\Carbon::parse($item->fecha)->format('Y-m-d'), ['id'=>'fecha','class'=>'form-control']) }}--}}
        <input type="date" name="fecha" id="fecha" value="{{ \Carbon\Carbon::parse($items->fecha,'d-m-Y') }}" class="form-control"  >
        <span class="has-error has-fecha">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-row mb-1">
    <label for = "respuesta" class="col-md-2 col-form-label">Respuesta </label>
    <div class="col-md-10">
        <textarea name="respuesta" id="respuesta" class="form-control">{{ old('respuesta',$item->respuesta) }}</textarea>
        <span class="has-error has-respuesta">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-row mb-1">
    <label for = "observaciones" class="col-md-2 col-form-label">Observaciones </label>
    <div class="col-md-10">
        <textarea name="observaciones" id="observaciones" class="form-control">{{ old('observaciones',$item->observaciones) }}</textarea>
        <span class="has-error has-observaciones">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

<div class="form-group row mb-1">
    <label for = "user__id" class="col-md-2 col-form-label">Ciudadano</label>
    <div class="col-md-10">
        <select id="user__id" name="user__id" class="form-control select2" data-toggle="select2" size="1">
            @foreach($ciudadanos as $t)
                <option value="{{$t->id}}" {{ $t->id == $item->user__id ? 'selected': '' }}  >{{$t->fullname}}</option>
            @endforeach
        </select>
    </div>
</div>

<input type="hidden" id="denuncia__id" name="denuncia__id" value="{{ $denuncia_id }}"/>
{{--<input type="hidden" id="user__id" name="user__id" value="{{ $user->id }}"/>--}}
<input type="hidden" id="id" name="id" value="{{$id}}"/>



