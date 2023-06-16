jQuery(function($) {
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
            }
        });

        // $("#editUser").prop('readonly',true);

        var catalogo_id = parseInt( $("#catalogo_id").val() );

        var Objs = [".buscarDatoDom", ".buscarDatoDomOtro"];
        var Urls = ["/buscarComunidad", "/buscarColonia"];
        var Inps = ["#buscar_dato_a_unificar", "#buscar_dato_a_unificar_otro"];
        var Indx = [0,1];


        for (i=0;i<Objs.length;i++)
            if ( $(Objs[i]) ) callAjax( $(Objs[i]), $(Inps[i]), Indx[i] );

        // alert("OK");

        function callAjax(Objs, Inps, Indx) {


            Objs.on('click', function(event){
                event.preventDefault();

                switch (Indx) {
                    case 0:
                        $('.listEle').empty();
                        $('.lstAsigns').empty();
                        break;
                    case 1:
                        $('.lstAsigns').empty();
                        break;
                }

                $.ajax({
                    url: Urls[catalogo_id],
                    dataType: "json",
                    data: {
                        search  : Inps.val(),
                    },
                    success: function(data) {
                        $("#totalItemsUnificar").html(data.length);
                        $.each(data, function( index, value ) {

                            var unif = value.is_unificadora ? value.id+" " : "";
                            switch (Indx) {
                                case 0:
                                    $(".listEle").append("<option value='" + value.id + "'>" + unif+value.value + "</option>");
                                    $(".lstAsigns").append("<option value='" + value.id + "'>" + unif+value.value + "</option>");
                                    break;
                                case 1:
                                    $(".lstAsigns").append("<option value='" + value.id + "'>" + value.value + "</option>");
                                    break;
                            }

                        });

                    },
                });

            });

            // $( Obj ).on( "autocompleteselect", function( event, ui ) {
            //     var ox = ID.split('/');
            //     var Id;
            //     if ( ox.length ==1 ) Id = ui.item[ID];
            //     if ( ox.length == 2 ) Id = ui.item[ox[0]]+"/"+ui.item[ox[1]];
            //     $.get( Get+Id, function( data ) {
            //         asignObjects(Obj,Item, data);
            //     }, "json" );
            // });
            //
            // $( Obj ).on( "keyup", function( event ) {
            //     clearObjects(Item);
            // });

        }


        function asignObjects(Obj, Item, data) {
            // alert(Item);
            //
            var d = data.data;
            switch (Item) {
                case 0:
                    // $("#ubicacion_id").val(d.id);
                    // $("#ubicacion_id_span").html(d.id);
                    // $("#ubicacion").val(d.calle+' '+d.colonia+' '+d.comunidad+' '+d.ciudad+' '+d.municipio+' '+d.estado+' '+d.cp);
                    // $("#ubicacion_nueva_id").val(d.id);
                    break;
            }
        }

        function clearObjects(Item) {
            switch (Item) {
                case 0:
                    // $("#ubicacion_id").val(0);
                    // $("#ubicacion_id_span").val("");
                    // $("#ubicacion").val("");
                    // $("#ubicacion_nueva_id").val(0);
                    break;

            }
        }

        // function clearObjAll(){
        //     if ( $("#ubicacion_id") )               $("#ubicacion_id").val(0);
        //     if ( $("#ubicacion_id_span") )          $("#ubicacion_id_span").val("");
        //     if ( $("#ubicacion_nueva_id") )         $("#ubicacion_nueva_id").val(0);
        //     if ( $("#ubicacion") )                  $("#ubicacion").val("");
        //     if ( $("#usuario_domicilio") )          $("#usuario_domicilio").val("");
        //     if ( $("#usuario_telefonos") )          $("#usuario_telefonos").val("");
        //     if ( $("#usuario_id") )                 $("#usuario_id").val(0);
        //     if ( $("#usuario_id") )                 $("#lstAsigns").empty();
        //     if ( $("#listTarget") )                 $("#listTarget").val(0);
        //     if ( $("#calle_id") )                   $("#calle_id").val(0);
        //     if ( $("#colonia_id") )                 $("#colonia_id").val(0);
        //     //if ( $("#search_autocomplete_calle") )  $("#search_autocomplete_calle").val("");
        // }

        function getRolesFromUser(Obj, Item, data){
            var d = data.data;
            $.get(  $("#getItems").val()+d.id, function( dato ) {
                var count = $.map(dato.data, function(n, i) { return i; }).length;
                $("#totalRolesUsuarios").html( count );
                $.each(dato.data, function( index, value ) {
                    $("#lstAsigns").append("<option value='"+index+"'>"+value+"</option>");
                });
            }, "json" );
        }

        if ( $(".btnUnifica") ){
            $(".btnUnifica").on('click',function (event){
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
