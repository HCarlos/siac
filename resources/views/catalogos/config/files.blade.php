@extends(Auth::user()->Home)

@section('container')

@component('components.home')
    @slot('titulo_catalogo','Archivos de Configuración')
    @slot('titulo_header','')
    @slot('contenido')
        <div class="col-md-4">
            <p class="text-success">Listado de archivos base:</p>
            <ul>
                @foreach($archivos as $archivo)
                    <li>
                        <a href="{{ asset('storage/externo/'.$archivo)  }}" target="_blank">{{$archivo}}</a>

                        <a href="{{ route('quitarArchivoBase') }}" title="Eliminar archivo"
                           onclick="event.preventDefault();
                             document.getElementById('remove-file-form-{{$archivo}}').submit();">
                            <i class="fa fa-trash red"></i>
                        </a>

                        <form id="remove-file-form-{{$archivo}}" action="{{ route('quitarArchivoBase') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="driver" value="externo">
                            <input type="hidden" name="archivo" value="{{$archivo}}">
                        </form>


                    </li>
                @endforeach
            </ul>

            <hr/>

            <p class="text-success">Descarga de datos:</p>
            <ul class="bg-muted">
                <li class="list list-activity">
                    <a href="{{ route('viddss.descargar_csv') }}" target="_blank">Descarga de datos de último estatus</a>
                </li>
            </ul>

        </div> <!-- end col-->

        <div class="col-md-8">
            <!-- Chart-->
            @component('components.card')
            @slot('title_card','Subir Archivo')
            @slot('body_card')

                <div class="card card-atemun">
                    <div class="card-body">
                        <form method="post" action="{{ action('Storage\StorageExternalFilesController@subirArchivoBase') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="categ_file" class=" control-label {{$errors->has('categ_file')?'text-danger':''}}">Categoría de Archivo</label>
                                <select class="form-control select2 {{$errors->has('categ_file')?' text-danger is-invalid border-danger':''}}" data-toggle="select2" name="categ_file" id="categ_file" size="1">
                                    <option value="">Formatos XLSX</option>
                                    @foreach(config('atemun.archivos') as $item => $value)
                                        <option value="{{$value}}">{{ $item  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="base_file" class=" control-label {{$errors->has('base_file')?'text-danger':''}}">Nuevo Archivo</label>
                                <div class="input-group">
                                    <input type="file" name="base_file" class="form-control {{ $errors->has('base_file') ? ' is-invalid' : '' }} "  value="{{ old('base_file') }}" style="padding-top: 0px; padding-left: 0px;" >
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-mini btn-primary">Subir</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            @endslot
            @endcomponent
        </div>
    @endslot
    @endcomponent

@endsection

@section('script')
<script type="javascript">
    document.getElementById('btn-print-viddss').addEventListener('click', function() {
    // Redirige el navegador a la ruta de descarga.
    // Esto forzará la descarga del archivo.
    window.location.href = '{{ route('viddss.descargar_csv') }}';

    // Si necesitas pasar filtros o parámetros, puedes añadirlos así:
    // const filtro = 'algun_valor'; // O toma el valor de un input
    // window.location.href = `{{ route('viddss.descargar_csv') }}?filtro=${filtro}`;
    });
</script>
@endsection
