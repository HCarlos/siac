{{--@extends(Auth::user()->Home)--}}

{{--@section('container')--}}

{{--@component('components.home')--}}
{{--    @slot('titulo_catalogo',$titulo_catalogo)--}}
{{--    @slot('titulo_header','Editando el registro '. $items->id)--}}
{{--    @slot('contenido')--}}
{{--        <div class="col-md-8">--}}
{{--            <!-- Chart-->--}}
{{--            @component('components.card')--}}
{{--                @slot('title_card','')--}}
{{--                @slot('body_card')--}}
{{--                    @include('shared.code.__errors')--}}
{{--                    <form method="POST" action="{{ route('updateUbicacion') }}" id="frmUbicacion">--}}
{{--                        @csrf--}}
{{--                        {{method_field('PUT')}}--}}
{{--                        @include('shared.catalogo.domicilio.ubicacion.__ubicacion_edit')--}}
{{--                        @include('shared.ui_kit.__button_form_normal')--}}
{{--                    </form>--}}
{{--                @endslot--}}
{{--            @endcomponent--}}
{{--        </div>--}}
{{--    @endslot--}}
{{--@endcomponent--}}

{{--@endsection--}}

@component('components.form.form-modal')
    @slot('Method', $Method ?? 'GET')
    @slot('Titulo', $Titulo ?? 'Nuevo')
    @slot('Route', $Route ?? '#')
    @slot('IsUpload', $IsUpload ?? false)
    @slot('IsNew', $IsNew ?? false)
    @slot('calles', $calles ?? null)
    @slot('colonias', $colonias ?? null)
    @slot('comunidades', $comunidades ?? null)
    @slot('codigospostales', $codigospostales ?? null)
    @slot('items_forms', $items_forms ?? '')
    @slot('formData', 'formFullModal')
    @slot('user',$user ?? null)
@endcomponent
