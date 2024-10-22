@isset($titulo_catalogo)
    <h4 class="page-title-box pt-3 float-left">
        {{$titulo_catalogo}}
        <small>
            @isset($titulo_header)
{{--                {{$titulo_header}}--}}
            @endisset
        </small>
    </h4>
@endisset
