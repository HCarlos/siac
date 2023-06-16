<div class="row">
    <div class="col-md-6 ">
        <div class="grid-container">
            <div class="form-row mb-1">
                <label for = "fecha_ingreso" class="col-md-2 col-form-label">Fecha </label>
                <div class="col-md-4">
{{--                    {{ Form::date('fecha_ingreso', \Carbon\Carbon::now(), ['id'=>'fecha_ingreso','class'=>'form-control','readonly'=>'readonly']) }}--}}
                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" class="form-control" readonly >
                </div>
                <label for = "fecha_ejecucion" class="col-md-2 col-form-label">F. Ejec. </label>
                <div class="col-md-4">
{{--                    {{ Form::date('fecha_ejecucion', \Carbon\Carbon::now()->addDay(3), ['id'=>'fecha_ejecucion','class'=>'form-control','readonly'=>'readonly']) }}--}}
                    <input type="date" name="fecha_ejecucion" id="fecha_ejecucion" value="{{ \Carbon\Carbon::now()->addDay(3)->format('d-m-Y') }}" class="form-control" readonly >
                </div>
            </div>
            <div class="form-row mb-1">
                <label for = "fecha_limite" class="col-md-2 col-form-label">F. Límite </label>
                <div class="col-md-4">
{{--                    {{ Form::date('fecha_limite', \Carbon\Carbon::now()->addDay(5), ['id'=>'fecha_limite','class'=>'form-control','readonly'=>'readonly']) }}--}}
                    <input type="date" name="fecha_limite" id="fecha_limite" value="{{ \Carbon\Carbon::now()->addDay(5)->format('d-m-Y') }}" class="form-control" readonly >
                </div>
            </div>
            <div class="form-row mb-1">
                <label for = "descripcion" class="col-md-2 col-form-label">Denuncia </label>
                <div class="col-md-10">
                    <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
                </div>
            </div>
            <div class="form-row mb-1">
                <label for = "referencia" class="col-md-2 col-form-label">Referencia </label>
                <div class="col-md-10">
                    <textarea name="referencia" id="referencia" class="form-control">{{ old('referencia') }}</textarea>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-6 ">
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
                <label for = "domicilio_ciudadano_internet" class="col-md-3 col-form-label">Domicilio</label>
                <div class="col-md-9">
                    <textarea name="domicilio_ciudadano_internet" id="domicilio_ciudadano_internet" class="form-control" rows="6">{{ old('domicilio_ciudadano_internet') }}</textarea>
                </div>
            </div>
        </div>
    </div>

</div>

<input type="hidden" name="id" value="0" >
<input type="hidden" name="ubicacion_id" id="ubicacion_id" value="0" >
<input type="hidden" name="creadopor_id" id="creadopor_id" value="{{$user->id}}" >
<input type="hidden" name="modificadopor_id" id="modificadopor_id" value="1" >
<hr>
