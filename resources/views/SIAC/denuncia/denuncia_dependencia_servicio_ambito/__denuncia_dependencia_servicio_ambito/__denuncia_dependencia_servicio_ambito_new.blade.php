<div class="row">
    <div class="col-md-12">
        <div class="grid-container">
            <div class="form-group row mb-1">
                <label for = "dependencia_id" class="col-md-3 col-form-label">Dependencia</label>
                <div class="col-md-9">
                    <select name="dependencia_id" class="form-control dependencia_status_id" size="1">
                        <option value="0" selected >Seleccione una Dependencia</option>
                        @foreach($dependencias as $t)
                            <option value="{{$t->id}}" @if($t->id == $dependencia_id) selected @endif >{{ $t->dependencia }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-1">
                <label for = "servicio_id" class="col-md-3 col-form-label">Servicio</label>
                <div class="col-md-9">
                    <select id="servicio_id" name="servicio_id" class="form-control" size="1">
                        <option value="0" >Seleccione un Servicio</option>
                        @foreach($servicios as $t)
                            <option value="{{$t->id}}" @if($t->id==$servicio_id) selected @endif >{{ $t->servicio }} </option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="form-group row mb-1">
                <label for = "estatus_id" class="col-md-3 col-form-label">Estatus</label>
                <div class="col-md-5">
                    <select id="estatus_id" name="estatus_id" class="form-control" size="1">
                        @foreach($estatus as $t)
                            <option value="{{$t->id}}" {{ $t->isDefault() ? 'selected': '' }} data-require="{{ $t->requiere_imagen }}" >{{ $t->estatus }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "observaciones" class="col-md-3 col-form-label {{$errors->has('observaciones')?'text-danger':''}}">Argumentos</label>
                <div class="col-md-9">
                    <textarea id="observaciones" name="observaciones" class="form-control {{$errors->has('observaciones')?'has-error form-error':''}}" cols="10" rows="4" ></textarea>
                    @if ($errors->has('observaciones'))
                        <span class="has-error">
                            <strong class="text-danger">{{ $errors->first('observaciones') }}</strong>
                        </span>
                    @endif

                </div>
            </div>

            <div class="form-group row mb-1 hide requiereImagen" id="requiereImagen">
            </div>

        </div>
    </div>
</div>

<input type="hidden" name="id" value="0" >
<input type="hidden" name="denuncia_id" value="{{ $items->denuncia_id }}" >
<input type="hidden" name="creadopor_id" id="creadopor_id" value="{{$user->id}}" >
<hr>

@section('script_interno')

    <script type="text/javascript">
    $( document ).ready(function() {

        $('#requiereImagen').hide();

        evalInputs();
        $( "#estatus_id" ).change(function(event) {
            event.preventDefault();
            evalInputs();
        });

        function evalInputs(){
            var requiere_imagen = $( "#estatus_id" ).find("option:selected").attr('data-require');
            if ( requiere_imagen === '1' ) {
                $( "#requiereImagen" ).html(getFileHTML());
                $( "#requiereImagen" ).show();
            } else {
                $( "#requiereImagen" ).empty();
                $( "#requiereImagen" ).hide();
            }
        }


        function getFileHTML() {
            return '' +
                '<div class="form-group row w-100-percent mb-1"><label for = "file1" class="col-md-3 col-form-label">Agregue una imagen</label><div class="col-md-5"><input type="file" id="file1" name="file1" class="form-control-file" ></div></div>' +
                '<div class="form-group row w-100-percent mb-1"><label for = "file2" class="col-md-3 col-form-label">Agregue una imagen</label><div class="col-md-5"><input type="file" id="file2" name="file2" class="form-control-file" ></div></div>' +
                '<div class="form-group row w-100-percent mb-1"><label for = "file3" class="col-md-3 col-form-label">Agregue una imagen</label><div class="col-md-5"><input type="file" id="file3" name="file3" class="form-control-file" ></div></div>'
                ;
        }


    })
</script>

@endsection
