<div class="row mt-3">
    {{$contenido}}
</div>

@section("script_extra")
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script >
        jQuery(function($) {
            $(document).ready(function() {

                if ( $("#search_autocomplete") ){

                    src = "{{ route('searchAdress') }}";
                    $("#search_autocomplete").autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: src,
                                dataType: "json",
                                data: {
                                    search : request.term
                                },
                                success: function(data) {
                                    response(data);
                                },
                            });
                        },
                        minLength: 3,
                    });
                }
                $( "#search_autocomplete" ).on( "autocompleteselect", function( event, ui ) {
                    var Id = ui.item['id'];
                    $.get( "/getUbi/"+Id, function( data ) {
                        $("#ubicacion_id").val(data.data.id);
                        $("#ubicacion_id_span").html(data.data.id);
                        $("#ubicacion").val(data.data.calle+' '+data.data.colonia+' '+data.data.comunidad+' '+data.data.ciudad+' '+data.data.municipio+' '+data.data.estado+' '+data.data.cp);
                        $("#search_autocomplete").val("");
                    }, "json" );
                });

                $( "#search_autocomplete" ).on( "keyup", function( event ) {
                    clearObjects();
                });

                function clearObjects() {
                    $("#ubicacion_id").val(0);
                    $("#ubicacion").val("");
                    $("#ubicacion_id_span").html(0);
                }

                $("#dependencia_id").on("change",function (event) {
                    var Id = event.currentTarget.value;
                    $("#servicio_id").empty();
                    $.get( "/getServiciosFromDependencias/"+Id, function( data ) {
                        $("#servicio_id").empty();
                        if ( data.data.length > 0 ){
                            $.each(data.data, function(i, item) {
                                $("#servicio_id").append('<option value="'+item.id+'" >'+item.id+' - '+item.servicio+'</option>');
                            });
                        }
                    }, "json" );
                });

                // alert("Hola");

            });
        });

        // alert("Init");

    </script>

@endsection
