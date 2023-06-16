@extends(Auth::user()->Home)

@section('container')

@component('components.home')
    @slot('titulo_catalogo',$titulo_catalogo)
    @slot('titulo_header','Cambiar mi foto')
    @slot('contenido')
        <div class="col-md-4">
            @include('shared.catalogo.user.__user_photo_header')
        </div> <!-- end col-->

        <div class="col-md-8">
            <!-- Chart-->
            @component('components.card-sin-fondo')
                @slot('title_card',Auth::user()->FullName)
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route('subirArchivoProfile/') }}"
                          accept-charset="UTF-8" enctype="multipart/form-data"
                          id="fromPhotoProfile">
                        @csrf
                        @include('shared.catalogo.user.__user_photo_update')
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-xs btn-rounded btn-primary float-right" id="btnSavePhoto"><i class="mdi mdi-upload mdi-24px"></i>Subir imagen</button>
                            @include('shared.code.__preloader')
                        </div>
                    </form>
                @endslot
            @endcomponent
        </div>
    @endslot
@endcomponent
{{--@section('script_extra')--}}
{{--<script src="{{asset('js/dropzone.min.js')}}"></script>--}}
{{--<script src="{{asset('js/component.fileupload.js')}}"></script>--}}

{{--@endsection--}}

@endsection
