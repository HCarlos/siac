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

                $(".btnGuardarDenuncia").on("click",function (event) {

                    var lista_estatus_utilizados = $("#lista_estatus_utilizados").val();
                    var array = lista_estatus_utilizados.split(',');
                    var buscarElemento = $("#estatus_id").val();
                    var indice = array.indexOf(buscarElemento);

                    if (indice !== -1) {
                        var estatus_text = $( "#estatus_id option:selected" ).text();
                        if (confirm("Este Estatus ("+estatus_text+") ya ha sido ha utilizado en esta Solicitud. \n\n ¿Desea continuar?") === false) {
                            return false;
                        }
                    }

                    event.preventDefault();
                    var $form = $("#formData");
                    var url = $form.attr('action');
                    var formData = {};
                    $form.find("input, select").each(function() {
                        formData[ $(this).attr('name') ] = $(this).val();
                    });

                    var dep_id = $(".dependencia_status_id").val();
                    var den_id = $("#denuncia_id").val();
                    var dependencia_text = $( ".dependencia_status_id option:selected" ).text();

                    var formDatax = {};
                    formDatax['denuncia_id'] = den_id;
                    formDatax['dependencia_id'] = dep_id;

                    $.post('/lastDepDen', formDatax, function(response) {
                        if (response.data === "Error") {
                            if (confirm("Esta Unidad Adminitrativa ("+dependencia_text+") no se ha utilizado en esta Solicitud. \n\n ¿Desea continuar?") === true) {
                                $form.submit();
                            }
                        }else{
                            $form.submit();
                        }
                    });



                });

            });

        });

    </script>

@endsection
