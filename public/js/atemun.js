
jQuery(function($) {
    $(document).ready(function() {


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
            }
        });

        // var Tabla;

        if ( $(".dataTable").length > 0 ){
            var nCols = $(".dataTable").find("tbody > tr:first td").length;
            var aCol = [];
            aCol[nCols - 1] = {"sorting": false};
            if (aCol.length > 0 ){
                $(".dataTable").DataTable({
                    searching: true,
                    paging: true,
                    info: true,
                    "pageLength": 50,
                    "order": [[ 0, "desc" ]],
                    "language": {
                        "lengthMenu":  "Mostrando _MENU_ entradas",
                        "sInfo":       "del _START_ al _END_ de un total de _TOTAL_ entradas",
                        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
                        "sInfoEmpty":  "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "zeroRecords": "Busqueda sin resultados",
                        "sSearch":     "Buscar:",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "info":        "Mostrando página _PAGE_ de _PAGES_"
                    },
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                    "aoColumns": aCol
                });
                // Tabla = tbl;
            }

        }

        if ( $(".removeItemList").length > 0  ){
            $('.removeItemList').on('click', function(event) {
                event.preventDefault();
                var aID = event.currentTarget.id.split('-');
                var x = confirm("Desea eliminar el registro: "+aID[1]);

                if (!x){
                    return false;
                }

                var Url = '/'+aID[0]+'/'+aID[1];

                $(function() {
                    $.ajax({
                        method: "GET",
                        url: Url
                    })
                        .done(function( response ) {
                            if (response.data == 'OK'){
                                alert(response.mensaje);
                                window.location.reload();
                            }else{
                                alert(response.mensaje);
                            }
                        })
                });
            });
        }

            if ( $(".removeItemListTwo").length > 0  ){
                $('.removeItemListTwo').on('click', function(event) {
                    event.preventDefault();
                    var aID = event.currentTarget.id.split('-');
                    var x = confirm("Desea eliminar el registro: "+aID[1]);

                    if (!x){
                        return false;
                    }

                    var Url = '/'+aID[0]+'/'+aID[1]+'/'+aID[2];

                    $(function() {
                        $.ajax({
                            method: "GET",
                            url: Url
                        })
                            .done(function( response ) {
                                if (response.data == 'OK'){
                                    alert(response.mensaje);
                                    window.location.reload();
                                }else{
                                    alert(response.mensaje);
                                }
                            })
                    });
                });
            }


        if ( $(".btnFullModal").length > 0  ){
            $(".btnFullModal").on("click", function (event) {
                event.preventDefault();
                localStorage.Input="";

                // Aplica para los Checkbox en dataTable
                if ( $(".table") ){
                    $form = $(".table > tbody");
                    $form.find("input[name='file-select']:checked").each(function() {
                        localStorage.Input += localStorage.Input === "" ? $(this).val() : ","+$(this).val();
                    });
                }
                var Url = event.currentTarget.href;

                // Nombre del Modal Form
                $("#modalFull .modal-content").empty();
                $("#modalFull .modal-content").html('<div class="fa-2x m-2"><i class="fa fa-cog fa-spin"></i>Cargando datos...</div>');
                $("#modalFull").modal('show');

                // alert(Url);

                $(function () {
                    $.ajax({
                        method: "GET",
                        url: Url
                    })
                    .done(function (response) {
                        $("#modalFull .modal-content").html(response);


                        // alert("Hola");

                        // Aplica para los Select2
                        $form = $("#modalFull .modal-content");
                        $form.find('.select2').each(function() {
                            $(this).select2({
                                dropdownParent: $('#modalFull')
                            });
                        });

                        // Aplica para los Checkbox en dataTable
                        if ( localStorage.Input!=="" ) {
                            $("#var2").val(localStorage.Input);
                        }


                        // Cuando se ejecuta un cambio en el Checkbox
                        $('.custom-control-input').on("change",function(e){
                            $(this).val( $(this).is(':checked') );
                        });

                        if ( $("#dependencia_id")){
                            $("#dependencia_id").on("change",function (event) {
                                var Id = event.currentTarget.value;
                                $("#servicio_id").empty();
                                $.get( "/getServiciosFromDependencias/"+Id, function( data ) {
                                    $("#servicio_id").empty();
                                    if ( data.data.length > 0 ){
                                        $("#servicio_id").append("<option value=0'>Seleccione un Servicio</option>");
                                        $.each(data.data, function(i, item) {
                                            $("#servicio_id").append('<option value="'+item.id+'" >'+item.id+' - '+item.servicio+'</option>');
                                        });
                                    }
                                }, "json" );
                            });
                        }

                        // alert("Hola 1");

                        // Aplica para el Dropzone
                        if ( $('.dropzone') && Dropzone ){
                            Dropzone.discover();
                        }

                        // alert("Hola 2");

                    });
                });
            });
        }



        // if ( $(".listTarget, .search_autocomplete_user").length > 0  ){
        //     $(".listTarget, .search_autocomplete_user").on('change', function(event) {
        //         event.preventDefault();
        //         //window.location.href = '/'+this.id+'/'+$(this).val();
        //     });
        // }

        if ( $(".btnAsign0").length > 0  ){
            //alert('btnAsign0');
            $(".btnAsign0").on('click', function(event) {
                event.preventDefault();

                //alert(this.id);

                var IdArr  = this.id.split('-');
                var urlAsigna = IdArr[0];
                var x = $('.listEle option:selected').val();
                // var y = $('select[name="listTarget"] option:selected').val();
                var y = $('.listTarget').val();
                if (isUndefined(x)){
                    alert("Seleccione una opción disponible");
                    return false;
                }else{
                    x='';
                    $(".listEle option:selected").each(function () {
                        x += $(this).val() + "|";
                    });
                }
                if (isUndefined(y) || y <= 0){
                    alert("Seleccione un elemento-->");
                    return false;
                }

                var Url = '/'+urlAsigna+'/'+y+'/'+x;

                var formData = {};
                formData['Id'] = y;
                formData['names'] = x;

                $(function() {

                    $.ajax({
                        url: '/'+urlAsigna,
                        data: formData,
                        method: 'POST'
                    }).done(function( response ) {
                        if (response.data == "OK"){
                            window.location.href = response.mensaje;
                        }
                    }).fail(function(response) {
                        alert(response.data);
                    });

                });

            });
        }


        if ( $(".btnUnasign0").length > 0  ){
            $(".btnUnasign0").on('click', function(event) {
                event.preventDefault();
                var IdArr  = this.id.split('-');
                var urlElimina = IdArr[0];
                var urlRegresa = IdArr[1];
                var z = $('.lstAsigns option:selected').val();
                // var y = $('select[name="listTarget"] option:selected').val();
                var y = $('.listTarget').val();
                if (isUndefined(z)){
                    alert("Seleccione una opción disponible");
                    return false;
                }else{
                    z='';
                    $(".lstAsigns option:selected").each(function () {
                        z += $(this).val() + "|";
                    });
                }
                if (isUndefined(y) || y <= 0){
                    alert("Seleccione un elemento");
                    return false;
                }

                var formData = {};
                formData['Id'] = y;
                formData['names'] = z;

                $(function() {
                    $.ajax({
                        url: '/'+urlElimina,
                        data: formData,
                        method: 'POST'
                    }).done(function( response ) {
                        if (response.data == "OK"){
                            window.location.href = response.mensaje;
                        }
                    }).fail(function(response) {
                        alert(response.data);
                    });

                });

            });
        }


        if ( $(".btnFilters").length > 0  ){
            $(".btnFilters").on('click', function(event) {
                event.preventDefault();

                if ( $(".frmSearchInList").length > 0  ){
                    var hRef = event.currentTarget.href;
                    var token = $("meta[name='csrf-token']").attr('content');
                    var arrRole = [];
                    $("input[name*='roles[]']:checked").each(function(){
                        arrRole.push($(this).val());
                    });
                    var oSearch    = $("input[name='search']").length > 0 ? $("input[name='search']").val() : "";
                    var oRole_User = $("input[name='role_user']").length > 0 ? $("input[name='role_user']").val() : "";
                    var PARAMS = {
                        search : oSearch,
                        roles  : arrRole,
                        role_user : oRole_User,
                        _token : token
                    };
                    var temp=document.createElement("form");
                    temp.action=hRef;
                    temp.method="POST";
                    temp.target="_blank";
                    temp.style.display="none";
                    for(var x in PARAMS) {
                        var opt=document.createElement("textarea");
                        opt.name=x;
                        opt.value=PARAMS[x];
                        temp.appendChild(opt);
                    }
                    document.body.appendChild(temp);
                    temp.submit();
                    return temp;
                }

            });
        }


        if ( $(".btnGetItems").length > 0  ){
            $(".btnGetItems").on('click', function(event) {
                event.preventDefault();
                if ( $(".btnGetItems").length > 0  ){
                    var str0 = event.currentTarget.href.split("-");
                    var hRef = str0[0];
                    // alert("hRef")
                    var token = $("meta[name='csrf-token']").attr('content');
                    var oSearch    = $("input[name='search']").length > 0 ? $("input[name='search']").val() : "";
                    var oItems     = $("input[name='items']").length > 0 ? $("input[name='items']").val() : "";
                    var PARAMS = {
                        search : oSearch,
                        items : oItems,
                        fileoutput : str0[1],
                        indice : str0[2],
                        _token : token
                    };
                    var temp=document.createElement("form");
                    temp.action=hRef;
                    temp.method="POST";
                    temp.target="_blank";
                    temp.style.display="none";
                    for(var x in PARAMS) {
                        var opt=document.createElement("textarea");
                        opt.name=x;
                        opt.value=PARAMS[x];
                        temp.appendChild(opt);
                    }
                    document.body.appendChild(temp);
                    temp.submit();
                    return temp;
                }
            });

        }



        // Activa o desactiva los checkbox desde el encabezado de la tabla
        $('#lblcheckbox').on("change",function(event){
            $(".image-chk").prop( "checked", $(this).is(':checked') );
        });

        if ( $(".removeItemSelects").length > 0  ){
            $('.removeItemSelects').on('click', function(event) {
                event.preventDefault();
                localStorage.Input = "";
                if ( $(".table") ){
                    $form = $(".table > tbody");
                    $form.find("input[name='file-select']:checked").each(function() {
                        localStorage.Input += localStorage.Input === "" ? $(this).val() : ","+$(this).val();
                    });
                }
                var x = confirm("Desea eliminar los registros seleccionados?");

                if (!x){
                    return false;
                }
                var aID = event.currentTarget.id.split('-');
                if ( localStorage.Input === ""){
                    var Url = '/'+aID[0]+'/'+aID[1];
                }else{
                    var Url = '/'+aID[0]+'/'+localStorage.Input;
                }

                $(function() {
                    $.ajax({
                        method: "GET",
                        url: Url
                    })
                        .done(function( response ) {
                            if (response.data == 'OK'){
                                alert(response.mensaje);
                                window.location.reload();
                            }else{
                                alert(response.mensaje);
                            }
                        })
                });
            });
        }


        if ( $(".home").html().length == 37 ){
            $(".home").html("<div class='img_bg_home' ></div>");
        }


        function IsCURP(curp) {
            var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
                validado = curp.match(re);

            if (!validado)  //Coincide con el formato general?
                return false;

            function digitoVerificador(curp17) {
                //Fuente https://consultas.curp.gob.mx/CurpSP/
                var diccionario  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
                    lngSuma      = 0.0,
                    lngDigito    = 0.0;
                for(var i=0; i<17; i++)
                    lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
                lngDigito = 10 - lngSuma % 10;
                if (lngDigito == 10) return 0;
                return lngDigito;
            }

            if (validado[2] != digitoVerificador(validado[1]))
                return false;

            return true; //Validado
        }

        function validaInputCURP(input) {
            var curp = input.value.toUpperCase(),
                resultado = document.getElementById("resultadoCURP"),
                valido = "No válido";
            if (IsCURP(curp)) { // ⬅️ Acá se comprueba
                valido = "Válido";
                resultado.classList.add("ok");
            } else {
                resultado.classList.remove("ok");
            }

            resultado.innerText = "CURP: " + curp + "\nFormato: " + valido;
        }


        function IsRFC(rfc) {

            var patternPM = "^(([A-ZÑ&]{3})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\\d])|[3][01])([A-Z0-9]{3}))|" +
                "(([A-ZÑ&]{3})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\\d])|[3][0])([A-Z0-9]{3}))|" +
                "(([A-ZÑ&]{3})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\\d])([A-Z0-9]{3}))|" +
                "(([A-ZÑ&]{3})([0-9]{2})[0][2]([0][1-9]|[1][0-9]|[2][0-8])([A-Z0-9]{3}))$";
            var patternPF = "^(([A-ZÑ&]{4})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\\d])|[3][01])([A-Z0-9]{3}))|" +
                "(([A-ZÑ&]{4})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\\d])|[3][0])([A-Z0-9]{3}))|" +
                "(([A-ZÑ&]{4})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\\d])([A-Z0-9]{3}))|" +
                "(([A-ZÑ&]{4})([0-9]{2})[0][2]([0][1-9]|[1][0-9]|[2][0-8])([A-Z0-9]{3}))$";

            if (rfc.match(patternPM) || rfc.match(patternPF)) {
                return true;
            } else {
                alert("La estructura de la clave de RFC es incorrecta.");
                return false;
            }
        }

        $("#colonia, #comunidad, #calle, #asentamiento, #tipoasentamiento, #tipocomunidad, #localidad," +
            "#afiliacion, #area, #subarea, #dependencia, #medida, #origen, #prioridad, #servicio, #ubicacon," +
            "#ciudad, #estado, #municipio, #estatus, #codigo, #cp, #search, #num_ext, #num_int," +
            "#search_autocomplete, #search_autocomplete_user, .search_autocomplete_user, " +
            "#search_autocomplete_calle, #search_autocomplete_colonia, #search_autocomplete_cp, " +
            "#search_autocomplete_comunidad, #clave_identificadora, #buscar_dato_a_unificar, " +
            "#buscar_dato_a_unificar_otro").keyup(function(){
            $(this).val($(this).val().toUpperCase());
        });

        if ( $(".operDenuncia").length > 0  ){
            $('.operDenuncia').on('click', function(event) {
                event.preventDefault();
                var id = event.currentTarget.id.split('.');
                var x = confirm("Desea "+id[0]+" este documento? \n\nNo se podrá deshacer esta acción.");

                if (!x){
                    return false;
                }

                var Url = '/'+id[1];

                $(function() {
                    $.ajax({
                        method: "GET",
                        url: Url
                    })
                        .done(function( response ) {
                            if (response.data == 'OK'){
                                alert(response.mensaje);
                                window.location.reload();
                            }else{
                                alert(response.mensaje);
                            }
                        })
                });
            });
        }


        $(".searchIdentical").on('click',function (event){
           event.preventDefault();
           var formData = {};
            formData['descripcion']  = $("#descripcion").val();
            formData['referencia']   = $("#referencia").val();
            formData['ubicacion']    = $("#ubicacion").val();
            formData['ubicacion_id'] = $("#ubicacion_id").val();
            formData['usuario_id']   = $("#usuario_id").val();
            formData['servicio_id']  = $("#servicio_id").val();
            formData['id']           = $("#id").val();

            var ciudadano_id = $("#usuario_id").val();

            $.ajax({
                method: "POST",
                data: formData,
                url: '/searchIdentical'
            })
                .done(function( response ) {
                    var Tbl = "";
                    if (response.result_msg == 'OK'){

                        $("#tblBody").empty();

                        $.each(response.data, function( index, value ) {
                            var TC = "";
                            if (value.total_ciudadanos !== ""){
                                TC = "(<strong class='text-danger'> <i class='fas fa-users'></i> "+value.total_ciudadanos+"</strong>)<br>";
                            }
                            Tbl += "<tr class='bgc-h-yellow-l3'>";
                            Tbl += "<td>"+
                                    value.id+"<br>"+
                                    "<strong>"+value.descripcion+"</strong><br>"+
                                    "<small>"+value.fecha+"</small><br>"+
                                    "<strong class='text-green'>"+value.ciudadano+"</strong><br>"+
                                    "<small>"+value.ubicacion+"</small><br>"+
                                    "<strong class='text-primary-dark'>"+value.ultimo_estatus+"</strong> " + TC +
                                "</td>"+
                                "<td>"+
                                    "<a href='/updateAddUserDenunciaGet/"+value.id+"/"+ciudadano_id+"' class='btn btn-danger'>Vincular</a>"+
                                "</td>";
                            Tbl += "</tr>";
                        });

                        $("#tblBody").append(Tbl);

                    }else{
                        alert(response.mensaje);
                    }
                })
        });

        // alert("Hola mun2");

        $(".formData").on('submit',function(event){
            $(".btnGuardarDenuncia").prop('disabled', true);
        });

        if ( $(".fecha_ingreso") ){
            var isFechaIngresoView = $("#isFechaIngresoView").val() !== "SI";
            $(".fecha_ingreso").prop('readonly', isFechaIngresoView);
        }

    });

});
