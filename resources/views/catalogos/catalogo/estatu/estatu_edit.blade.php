@extends(Auth::user()->Home)

@section('container')

@component('components.home')
    @slot('titulo_catalogo',$titulo_catalogo)
    @slot('titulo_header','Editando el registro '. $items->id)
    @slot('contenido')
        <div class="col-md-8">
            <!-- Chart-->
            @component('components.card')
                @slot('title_card','')
                @slot('body_card')
                    @include('shared.code.__errors')
                    <form method="POST" action="{{ route('updateEstatu') }}">
                        @csrf
                        {{method_field('PUT')}}
                        @include('shared.catalogo.estatu.__estatu_edit')
                        @include('shared.ui_kit.__button_form_normal')
                    </form>
                @endslot
            @endcomponent
        </div>
    @endslot
@endcomponent

@endsection

@section('script_interno')
    <script type="text/javascript">
        $(".depToStatus").on('click',function (event) {
            var arrItem = event.currentTarget.id.split('-');
            var Url   = arrItem[0];
            var Id    = arrItem[1];
            var IdDep = arrItem[2] == 999 ? $("#dependencia_id").val() : arrItem[2];
            if (IdDep > 0){
                $.get( "/"+Url+"/"+Id+"/"+IdDep , function( data ) {
                    data.mensaje === "OK" ? document.location.href = '/editEstatu/'+Id : alert(data.mensaje);
                }, "json" );
            }
        })
    </script>
@endsection
