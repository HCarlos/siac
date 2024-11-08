<div class="form-row mb-1">
    <label for = "fecha" class="col-md-2 col-form-label">Fecha </label>
    <div class="col-md-4">
{{--        {{ Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'fecha','class'=>'form-control']) }}--}}
        <input type="date" name="fecha" id="fecha" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control">

        <span class="has-error has-fecha">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-row mb-1">
    <label for = "respuesta" class="col-md-2 col-form-label">Respuesta </label>
    <div class="col-md-10">
        <textarea name="respuesta" id="respuesta" class="form-control">{{ old('respuesta') }}</textarea>
        <span class="has-error has-respuesta">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-row mb-1">
    <label for = "observaciones" class="col-md-2 col-form-label">Observaciones </label>
    <div class="col-md-10">
        <textarea name="observaciones" id="observaciones" class="form-control">{{ old('observaciones') }}</textarea>
        <span class="has-error has-observaciones">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>

@if(Auth::user()->isRole('Administrator|SysOp'))
    <input type="hidden" id="user__id" name="user__id" value="{{ Auth::user()->id }}"/>
@else
    <input type="hidden" id="user__id" name="user__id" value="{{ $user->id }}"/>
@endif

<input type="hidden" id="denuncia__id" name="denuncia__id" value="{{ $denuncia_id }}"/>
<input type="hidden" id="respuesta__id" name="respuesta__id" value="{{ $respuesta_id }}"/>
<input type="hidden" id="id" name="id" value="0"/>



