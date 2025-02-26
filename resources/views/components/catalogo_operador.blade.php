<div class="row">
    <div class="col-lg-12">
{{--        <div class="page-title-box">--}}
            {{$buttons_catalogo_operador}}
{{--        </div>--}}
    </div>
</div>

<div class="col-lg-12 mt-2">
    <div class="row">
        {{$body_catalogo_operador}}
    </div>
<div class="row">

@section('script_interno')
<script src="{{ asset('js/siac_operadores.js') }}"></script>
@endsection
