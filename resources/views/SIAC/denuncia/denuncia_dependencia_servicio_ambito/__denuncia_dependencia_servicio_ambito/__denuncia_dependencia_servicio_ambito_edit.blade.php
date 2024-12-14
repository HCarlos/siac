<div class="row">
    <div class="col-md-12 ">
        <div class="grid-container">
            <div class="form-group row mb-1">
                <label for = "dependencia_id" class="col-md-3 col-form-label">Dependencia</label>
                <div class="col-md-9">
                    <select id="dependencia_id" name="dependencia_id" class="form-control" size="1">
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
                            <option value="{{$t->id}}" {{ $t->id === $items->estatu_id  ? 'selected': '' }} data-require="{{ $t->requiere_imagen }}" >{{ $t->estatus }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-1">
                <label for = "observaciones" class="col-md-3 col-form-label">Argumentos</label>
                <div class="col-md-9">
                    <textarea id="observaciones" name="observaciones" class="form-control" cols="10" rows="4" >{{$items->observaciones}}</textarea>
                </div>
            </div>

            <div class="form-group row mb-1 hide" id="requiereImagen">
            </div>

            <div class="form-group row mb-1">

                <table class="table table-centered mb-0">
                    <thead class="thead-dark">
                    <tr>
                        <th>Imegen</th>
                        <th>Directorio</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items->imagenes as $item)
                        <tr>
                            @if( $item->descripcion === "mobile" )
                                <td>
                                    <a class="pull-left pl-2"  href="{{asset($item->PathImageMobile)}}" target="_blank" >
                                        <img class="media-object" src="{{asset($item->PathImageMobileThumb)}}" width="64" height="64" alt="" >
                                    </a>
                                </td>
                                <td>{{ asset("/storage/mobile/denuncia/".$item->image) }}</td>
                            @else
                                <td>
                                    <a class="pull-left pl-2"  href="{{asset($item->PathImage)}}" target="_blank" >
                                        <img class="media-object" src="{{asset($item->PathImageThumb)}}" width="64" height="64" alt="" >
                                    </a>
                                </td>
                                <td>{{ asset("/storage/denuncia/".$item->image) }}</td>
                            @endif
                            <td>
                                @include('shared.ui_kit.__remove_item_image_docto_respuesta')
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>

<input type="hidden" name="id" value="{{$Id}}" >
<input type="hidden" name="denuncia_id" value="{{ $items->denuncia_id }}" >
<input type="hidden" name="creadopor_id" id="creadopor_id" value="{{$user->id}}" >
<hr>

@section('script_interno')

    <script type="text/javascript">
        $( document ).ready(function() {

            $('#requiereImagen').hide();

            $( "#estatus_id" ).change(function(event) {
                event.preventDefault();

                var requiere_imagen = $(this).find("option:selected").attr('data-require');

                if ( requiere_imagen === '1' ) {
                    // $( "#requiereImagen" ).html(getFileHTML());
                    $( "#requiereImagen" ).show();
                } else {
                    // $( "#requiereImagen" ).empty();
                    $( "#requiereImagen" ).hide();
                }
            });

            function getFileHTML() {
                return '' +
                    '<div class="form-group row w-100-percent mb-1"><label for = "file1" class="col-md-3 col-form-label">Agregue una imagen</label><div class="col-md-5"><input type="file" id="file1" name="file1" class="form-control-file" required></div></div>' +
                    '<div class="form-group row w-100-percent mb-1"><label for = "file2" class="col-md-3 col-form-label">Agregue una imagen</label><div class="col-md-5"><input type="file" id="file2" name="file2" class="form-control-file" ></div></div>' +
                    '<div class="form-group row w-100-percent mb-1"><label for = "file3" class="col-md-3 col-form-label">Agregue una imagen</label><div class="col-md-5"><input type="file" id="file3" name="file3" class="form-control-file" ></div></div>'
                    ;
            }

        })
    </script>

@endsection
