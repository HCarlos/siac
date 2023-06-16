<div class="row">
    <div class="col-lg-12 ">
        <div class="grid-container">
            <div class="form-row mb-1">
                <label for = "fecha_ingreso" class="col-lg-2 col-form-label">Fecha </label>
                <div class="col-lg-4">
                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control" readonly>
                </div>
                <div class="col-lg-6">
                </div>
            </div>
            <div class="form-group row mb-1">
                <label for = "servicios" class="col-lg-2 col-form-label">Servicio</label>
                <div class="col-lg-10">
                    <select id="servicios" name="servicios" class="form-control" size="1">
                        @foreach($Servicios as $t)
                            <option value="{{$t->id.'-'.$t->subarea_id.'-'.$t->area_id.'-'.$t->dependencia_id}}" >{{ $t->servicio }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row mb-1">
                <label for = "descripcion" class="col-lg-2 col-form-label">Solicitud </label>
                <div class="col-lg-10">
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="6">{{ old('descripcion') }}</textarea>
                </div>
            </div>
            <div class="form-row mb-1">
                <label for = "referencia" class="col-lg-2 col-form-label">Referencia </label>
                <div class="col-lg-10">
                    <textarea name="referencia" id="referencia" class="form-control">{{ old('referencia') }}</textarea>
                </div>
            </div>
            <div class="form-group row mb-1">
                <label for = "ubicacion_problema_ciudadano" class="col-lg-2 col-form-label">Ubicación del Problema</label>
                <div class="col-lg-10">
                    <textarea name="ubicacion_problema_ciudadano" id="ubicacion_problema_ciudadano" class="form-control" >{{ old('ubicacion_problema_ciudadano') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="grid-structure">
    <div class=" row">
        <div class="col-lg-12 ">
            <div class="grid-container">
                <div class="form-group mb-1">
                    <label for="file1"><strong>Archivo 1</strong>: Subir archivo</label><br>
{{--                    {{ Form::file('file1',['id' => 'file1', 'accept'=>'.png , .jpeg , .jpg , .pdf'])}}--}}
                    <input type="file" name="file1" id="file1" accept=".png , .jpeg , .jpg , .pdf" class="form-control-file">
{{--                    <smal class="text-muted mt-1"> Archivos: [png, jpeg, jpg] <= 10mb</smal>--}}
                </div>
{{--                <hr>--}}
{{--                <div class="form-group mb-1">--}}
{{--                    <label for="file2"><strong>Archivo 2</strong>: Subir archivo</label>--}}
{{--                    <input type="file" id="file2" name="file2" class="form-control-file">--}}
{{--                    <smal class="text-muted mt-1"> Archivos: [png, jpeg, jpg] <= 10mb</smal>--}}
{{--                </div>--}}
{{--                <hr>--}}
{{--                <div class="form-group mb-1">--}}
{{--                    <label for="file3"><strong>Archivo 3</strong>: Subir archivo</label>--}}
{{--                    <input type="file" id="file3" name="file3" class="form-control-file">--}}
{{--                    <smal class="text-muted mt-1"> Archivos: [png, jpeg, jpg] <= 10mb</smal>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="id" value="0" >
<input type="hidden" name="ubicacion_id" id="ubicacion_id" value="1" >
<input type="hidden" name="creadopor_id" id="creadopor_id" value="{{$user->id}}" >
<input type="hidden" name="modificadopor_id" id="modificadopor_id" value="{{$user->id}}" >
