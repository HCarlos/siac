jQuery(function($) {
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
            }
        });

        var Objs = ["#search_autocomplete","#search_autocomplete_user",".search_autocomplete_user","#search_autocomplete_calle","#search_autocomplete_colonia","#search_autocomplete_cp","#search_autocomplete_comunidad"];
        var Urls = ["/searchAdress","/searchUser","/searchUser","/buscarCalle","/buscarColonia","/buscarCodigopostal","/buscarComunidad"];
        var Gets = ["/getUbi/","/getUser/","/getUser/","/getCalle/","/getColonia/","/getCodigopostal/","/getComunidad/"];
        var Ids =  ["id","id","id","id","id","id","id"];

        // alert(Ids.length);

        for (i=0;i<Objs.length;i++)
            if ( $(Objs[i]) ) callAjax($(Objs[i]), Urls[i], Gets[i], i, Ids[i]);

        function callAjax(Obj, Url, Get, Item, ID, Elem) {
            $(Obj).autocomplete({
                source: function(request, response) {
                    $(".denuncuaUserModalChange").prop('disabled',true);
                    $("#editUser").prop('disabled',true);
                    $.ajax({
                        url: Url,
                        dataType: "json",
                        data: {
                            search  : request.term,
                        },
                        success: function(data) {
                            response(data);
                        },
                    });

                },
                minLength: 3,
            });

            $( Obj ).on( "autocompleteselect", function( event, ui ) {
                var ox = ID.split('/');
                var Id;
                if ( ox.length ==1 ) Id = ui.item[ID];
                if ( ox.length == 2 ) Id = ui.item[ox[0]]+"/"+ui.item[ox[1]];
                $.get( Get+Id, function( data ) {
                    asignObjects(Obj,Item, data);
                }, "json" );
            });

            $( Obj ).on( "keyup", function( event ) {
                clearObjects(Item);
            });

        }

        function asignObjects(Obj, Item, data) {
            // alert(Item);
            //
            var d = data.data;
            switch (Item) {
                case 0:
                    $("#ubicacion_id").val(d.id);
                    $("#ubicacion_id_span").html(d.id);
                    $("#ubicacion").val(d.id+' '+d.calle+' '+d.colonia+' '+d.comunidad+' '+d.ciudad+' '+d.municipio+' '+d.estado+' '+d.cp);
                    $("#ubicacion_nueva_id").val(d.id);
                    $("#searchGoogle").val(d.sanitizer_location);
                    break;
                case 1:
                    if ( $("#usuario") )            $("#usuario").val('('+d.id+') '+d.nombre_completo);
                    if ( $("#usuario_domicilio") )  $("#usuario_domicilio").val(d.domicilio);
                    if ( $("#searchGoogle") )       $("#searchGoogle").val(d.sanitizer_location);

                    if ( $("#usuario_telefonos") )  {
                        llevarDatosdelUsuario(d);
                        // $("#usuario_telefonos").val(d.telefonos);
                        // var dd = d.telefonos.split(';');
                        // $("#lblCelulares").html(dd[0]);
                        // $("#lblTelefonos").html(dd[1]);
                        // $("#lblEMails").html(dd[2]);
                        // $("#ciu_ap_paterno").val(d.ap_paterno);
                        // $("#ciu_ap_materno").val(d.ap_materno);
                        // $("#ciu_nombre").val(d.nombre);
                        // $("#ciu_telefonos").val(dd[1]);
                        // $("#ciu_celulares").val(dd[0]);
                        // $("#ciu_emails").val(dd[2]);
                        // $("#ciudadano_id").val(d.id);
                    }

                    if ( $("#usuario_id") ){
                        $("#usuario_id").val(d.id)
                        $(".denuncuaUserModalChange").prop('disabled',false);
                    };
                    if ( $("#ubicacion_id") )       $("#ubicacion_id").val(d.ubicacion_id);
                    if ( $("#ubicacion_id_span") )  $("#ubicacion_id_span").html(d.ubicacion_id);
                    if ( $("#ubicacion") )          $("#ubicacion").val(d.id+' '+d.domicilio);
                    if ( $("#ubicacion_nueva_id") ) $("#ubicacion_nueva_id").val(d.ubicacion_id);
                    if ( $("#editUser") ) $("#editUser").prop('disabled',false);
                    if ( $("#editUser") ) $("#editUser").attr('href','/editUser/'+d.id);

                    break;
                case 2:
                    if ( $("#lstAsigns") ) $("#lstAsigns").empty();
                    $("#listTarget").val(d.id);
                    getRolesFromUser(Obj, Item, data);
                    break;
                case 3:
                    $("#calle_id").val(d.id);
                    $("#search_autocomplete_calle").val(d.calle);
                    break;
                case 4:
                    $("#colonia_id").val(d.id);
                    $("#search_autocomplete_colonia").val(d.colonia);
                    break;
                case 5:
                    $("#codigopostal_id").val(d.id);
                    $("#search_autocomplete_cp").val(d.cp);
                    break;
                case 6:
                    $("#comunidad_id").val(d.id);
                    $("#search_autocomplete_comunidad").val(d.id +' - '+d.comunidad);
                    break;
            }
        }

        function clearObjects(Item) {
            switch (Item) {
                case 0:
                    $("#ubicacion_id").val(0);
                    $("#ubicacion_id_span").val("");
                    $("#ubicacion").val("");
                    $("#ubicacion_nueva_id").val(0);
                    break;
                case 1:
                    $("#usuario").val("");
                    $("#usuario_domicilio").val("");
                    $("#usuario_telefonos").val("");
                    $("#usuario_id").val(0);
                    $("#editUser").prop('disabled',true);
                    $("#editUser").prop('href',null);
                    $(".denuncuaUserModalChange").prop('disabled',true);

                    if ( $("#usuario_telefonos") )  {
                        limpiarDatosdelUsuario();
                        // $("#usuario_telefonos").empty();
                        // $("#lblCelulares").html('');
                        // $("#lblTelefonos").html('');
                        // $("#lblEMails").html('');
                        // $("#ciu_ap_paterno").empty();
                        // $("#ciu_ap_materno").empty();
                        // $("#ciu_nombre").empty();
                        // $("#ciu_telefonos").empty();
                        // $("#ciu_celulares").empty();
                        // $("#ciu_emails").empty();
                        // $("#ciudadano_id").val(0);
                    }

                    break;
                case 2:
                    if ( $("#lstAsigns") ) $("#lstAsigns").empty();
                    $("#listTarget").val(0);
                    break;
                case 3:
                    $("#calle_id").val(0);
                    break;
                case 4:
                    $("#colonia_id").val(0);
                    break;
                case 5:
                    $("#codigopostal_id").val(0);
                    break;
                case 6:
                    $("#comunidad_id").val(0);
                    break;

            }
        }

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

        $("#user_address_list").on('change',function(event){
             $("#ubicacion_nueva_id").val( $(this).val() );
        });

        if ( $("#usuario_id") && parseInt( $("#usuario_id").val() ) > 0 ) {
            $(".denuncuaUserModalChange").prop('disabled', false);
        }else{
            $(".denuncuaUserModalChange").prop('disabled', true);
        }

        if ( $("#btnRefreshUserData") ) {
            $("#btnRefreshUserData").on('click', function (event) {
                event.preventDefault();
                if ($("#btnRefreshUserData")) {
                    var ciudadano_id = parseInt($("#ciudadano_id").val());
                    if (ciudadano_id > 0) {

                        var hRef = "putModalDenunciaUserUpdate";
                        var token = $("meta[name='csrf-token']").attr('content');
                        var ap_paterno = $("#ciu_ap_paterno").val();
                        var ap_materno = $("#ciu_ap_materno").val();
                        var nombre = $("#ciu_nombre").val();
                        var telefonos = $("#ciu_telefonos").val();
                        var celulares = $("#ciu_celulares").val();
                        var emails = $("#ciu_emails").val();

                        var PARAMS = {
                            ciudadano_id: ciudadano_id,
                            ap_paterno: ap_paterno,
                            ap_materno: ap_materno,
                            nombre: nombre,
                            telefonos: telefonos,
                            celulares: celulares,
                            emails: emails,
                            _token: token
                        };

                        $.post(hRef, PARAMS, function (response) {
                            alert(response.mensaje);
                            var d = response.data;
                            $("#lblCelulares").html(d.celulares);
                            $("#lblTelefonos").html(d.telefonos);
                            $("#lblEMails").html(d.emails);
                            $("#denuncuaUserModalChange").modal('hide');
                        }).fail(function (response) {
                            $("#denuncuaUserModalChange").modal('hide');
                            // var err = JSON.stringify(response.responseJSON);
                            // if ( response.responseJSON.errors === undefined ) {
                            //     fillArray(response.responseJSON, $form)
                            // }else{
                            //     sayErrors(response.responseJSON.errors, $form);
                            // }
                        });

                    }
                }

            });
        }

    });


    function llevarDatosdelUsuario(d){
        $("#usuario_telefonos").val(d.telefonos);
        var dd = d.telefonos.split(';');
        $("#lblCelulares").html(dd[0]);
        $("#lblTelefonos").html(dd[1]);
        $("#lblEMails").html(dd[2]);
        $("#ciu_ap_paterno").val(d.ap_paterno);
        $("#ciu_ap_materno").val(d.ap_materno);
        $("#ciu_nombre").val(d.nombre);
        $("#ciu_telefonos").val(dd[1]);
        $("#ciu_celulares").val(dd[0]);
        $("#ciu_emails").val(dd[2]);
        $("#ciudadano_id").val(d.id);
    }

    function limpiarDatosdelUsuario(){
        $("#usuario_telefonos").empty();
        $("#lblCelulares").html('');
        $("#lblTelefonos").html('');
        $("#lblEMails").html('');
        $("#ciu_ap_paterno").empty();
        $("#ciu_ap_materno").empty();
        $("#ciu_nombre").empty();
        $("#ciu_telefonos").empty();
        $("#ciu_celulares").empty();
        $("#ciu_emails").empty();
        $("#ciudadano_id").val(0);
    }


});
