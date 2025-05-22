    <div class="row mt-3">
        {{$contenido}}
    </div>
@section("script_extra")
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('/js/servimun.autocomplete.js')}}?time()"></script>
    <script >

        jQuery(function($) {
            $(document).ready(function() {

                $("#radio1").prop('checked',true);

                $(".panelUbiProblem").hide();

                if( $(".pregunta1") ){
                    $(".pregunta1").on('change',function(event){
                        event.preventDefault();
                        if ( $(this).val() == 0 ){
                            $(".panelUbiProblem").hide();
                        }else{
                            $(".panelUbiProblem").show();
                        }
                    });
                }

                function getServicioFromDependencia(dependencia_id, efect){
                    $("#servicio_id").empty();
                    $.get( "/getServiciosFromDependencias/"+dependencia_id+"/"+efect, function( data ) {
                        $("#servicio_id").empty();
                        if ( data.data.length > 0 ){
                            $.each(data.data, function(i, item) {
                                $("#servicio_id").append('<option value="'+item.id+'" > '+item.id+' - '+item.servicio+'</option>');
                            });
                        }
                    }, "json" );

                }

                $("#dependencia_id").on("change",function (event) {
                    var Id = event.currentTarget.value;
                    getServicioFromDependencia(Id,0);
                });

                $(".dependencia_status_id").on("change",function (event) {
                    var Id = event.currentTarget.value;
                    getServicioFromDependencia(Id,1);
                });


                if ( $(".pregunta1").val() == 1 ){
                    $(".panelUbiProblem").show();
                }

            });

        });

    </script>

@endsection
