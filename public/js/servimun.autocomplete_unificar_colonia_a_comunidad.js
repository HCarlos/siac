jQuery(function($) {
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
            }
        });

        // $("#editUser").prop('readonly',true);

        // var catalogo_id = parseInt( $("#catalogo_id").val() );

        var Objs = [".buscarDatoDom", ".buscarDatoDomOtro", ".buscarColComun"];
        var Urls = ["/buscarComunidad", "/buscarColonia", "/buscarColonia"];
        var Inps = ["#buscar_dato_a_unificar", "#buscar_dato_a_unificar_otro", "#buscar_colonia_a_unificar_comunidad"];
        var Indx = [0,1,2];


        $(".buscarColonias").on('click', function(event){
            event.preventDefault();
            $.ajax({
                url: "/buscarColonia",
                dataType: "json",
                data: {
                    search  : $("#colonias").val(),
                },
                success: function(data) {
                    $('.listEle').empty();
                    $("#totalItemsUnificar").html(data.length);
                    $.each(data, function( index, value ) {
                        var unif = value.is_unificadora ? value.id+" " : "";
                        $(".listEle").append("<option value='" + value.id + "'>" + unif+value.value + ', ' + value.comunidad + "</option>");
                    });

                },
            });
        })

        $(".buscarComunidades").on('click', function(event){
            event.preventDefault();
            $.ajax({
                url: "/buscarComunidad",
                dataType: "json",
                data: {
                    search  : $("#comunidades").val(),
                },
                success: function(data) {
                    $('.lstAsigns').empty();
                    $("#totalItemsUnificar").html(data.length);
                    $.each(data, function( index, value ) {
                        var unif = value.is_unificadora ? value.id+" " : "";
                        $(".lstAsigns").append("<option value='" + value.id + "'>" + unif+value.value + "</option>");
                    });

                },
            });
        })
        function clearObjAll(){
            if ( $("#colonias") )    $("#colonias").val("");
            if ( $("#comunidades") ) $("#comunidades").val("");
            $('#listEle').empty();
            $('#lstAsigns').empty();
        }
        var btnUnifica = $(".btnUnifica");
        if ( btnUnifica ){
            btnUnifica.on('click',function (event){
                event.preventDefault();

                var listEle = $('#listEle option:selected').val();
                var lstAsigns = $('#lstAsigns option:selected').val();


                var IdArr  = this.id.split('-');
                var urlAsigna = IdArr[0];
                var x = $('.listEle option:selected').val();
                var y = $('.lstAsigns option:selected').val();
                if (isUndefined(x)){
                    alert("Seleccione una opción disponible");
                    return false;
                }else{
                    x='';
                    var totalItems = $(".listEle option:selected").length;
                    // alert(totalItems);
                    lin = 1;
                    $(".listEle option:selected").each(function () {
                        postf = lin < totalItems ?  "|" : "";
                        x += $(this).val() + postf;
                        lin++;
                    });
                }
                if (isUndefined(y) || y <= 0){
                    alert("Seleccione un elemento-->");
                    return false;
                }

                var Url = '/'+urlAsigna+'/'+x+'/'+y;

                var formData = {};
                formData['origins_id'] = x;
                formData['destino_id'] = y;

                $(function() {

                    // alert(urlAsigna);

                    $.ajax({
                        url: '/'+urlAsigna,
                        data: formData,
                        method: 'POST'
                    }).done(function( response ) {
                        if (response.data == "OK"){
                            alert(response.registros_eliminados);
                            //window.location.href = response.mensaje;
                        }
                    }).fail(function(response) {
                        alert(response.data);
                    });

                });

            });
        }

        // alert("Hola");

    });
});
