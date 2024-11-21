<div class="form-row mb-1">
    <label for = "dependencia_id" class="col-md-3 col-form-label">Dependencia</label>
    <div class="col-md-9">
        <select id="dependencia_id" name="dependencia_id" class="form-control" size="1">
            <option value="0" selected >Seleccione una Dependencia</option>
            @foreach($dependencias as $id => $valor)
                <option value="{{ $id }}">{{ $valor }}</option>
            @endforeach
        </select>
    </div>
{{--    <label for = "ambito_dependencia" class="col-md-3 col-form-label">Alcance</label>--}}
{{--    <div class="col-md-9">--}}
{{--        <select id="ambito_dependencia" name="ambito_dependencia" class="form-control" size="1">--}}
{{--            <option value="0" selected >Seleccione un elemento</option>--}}
{{--            @foreach($ambito_dependencia as $id => $valor)--}}
{{--                <option value="{{ $id }}">{{ $valor }}</option>--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--    </div>--}}
</div>


@section("script_extra")
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script >
        jQuery(function($) {
            $(document).ready(function () {

            });
        });
@endsection
