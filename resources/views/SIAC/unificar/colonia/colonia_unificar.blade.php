@extends(Auth::user()->Home)
@section('container')

    @component('components.unificarV2')

        @slot('titulo_catalogo', $catalogo_titulo)
        @slot('titulo_header','')
        @slot('altoPanelIzq','asign-pnl-left')
        @slot('altoPanelCen','asign-pnl-center')
        @slot('altoPanelDer','asign-pnl-right')

        @slot('titleLeft0') {{$titleLeft0 }} @endslot
        @slot('urlUnifica') {{$urlUnifica}} @endslot
{{--        @slot('urlElimina') {{$urlElimina}} @endslot--}}
        @slot('urlRegresa') {{$urlRegresa ?? null}} @endslot
        @slot('catalogo_id', $catalogo_id ?? 0)

        @slot('list0')
{{--            {{ Form::select('listEle', null, '', ['multiple' => 'multiple','class'=>'listEle form-control asign-lstEle0']) }}  --}}
            <select name="listEle" id="listEle" multiple class="listEle form-control" style="height: 84%"></select>
        @endslot
        @slot('countListEle',0)
        @slot('Asign0')
            @slot('titleAsign0') {{$titleAsign0}} @endslot
{{--            {{ Form::select('lstAsigns', null, '', ['multiple' => 'multiple', 'id' => 'lstAsigns', 'class'=>'lstAsigns form-control asign-lstAsigns0']) }}--}}
            <select name="lstAsigns" id="lstAsigns" size="1" class="lstAsigns form-control "></select>
        @endslot
        @slot('countAsign0',0)

    @endcomponent

@endsection
