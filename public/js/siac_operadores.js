jQuery(function($) {
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
            }
        });

        $("#btnSaveSolicitud").attr("disabled", true);

        if ( $("#btnSolicitudId").length > 0  ){

            $("#btnSolicitudId").on("click", function (event) {
                // event.preventDefault();
                $("#btnSaveSolicitud").attr("disabled", true);

                var denuncia_id = parseInt( $("#denuncia_id").val() );
                var operador_id = parseInt( $("#operador_id").val() );

                if ( operador_id <= 0 || isNaN(operador_id) ) {
                    $("#btnSaveSolicitud").attr("disabled", true);
                    alert("Seleccione un Operador");
                    return false;
                }

                if ( denuncia_id <= 0 || isNaN(denuncia_id) ) {
                    alert("Proporcione el ID de la solicitud");
                    isValidSave();
                    return false;
                }

                var _data = { denuncia_id: denuncia_id, operador_id: operador_id };

                $.ajax({
                    method: "POST",
                    url: "/getDenunciaAmbitoAjaxFromId",
                    data: _data
                })
                .done(function (response) {
                    var OK = response.mensaje === "OK";
                    var data = response.data;
                    if (OK) {
                        $("#lblSolicitudId").html(data.id);
                        $("#solicitud").html(data.denuncia);
                        $("#sue").html(data.servicio_ultimo_estatus);
                        $("#ciudadano").html(data.ap_paterno_ciudadano+" "+data.ap_materno_ciudadano+" "+data.nombre_ciudadano);
                        $("#ubicacion").html(data.gd_ubicacion+" " + getGeoRefHtml(data));
                    } else {
                        alert(data);
                    }
                    isValidSave();
                });
            });
        }
        if ( $("#btnSaveSolicitud").length > 0  ){
            $("#btnSaveSolicitud").on("click", function (event) {

                var denuncia_id = parseInt( $("#denuncia_id").val() );
                var operador_id = parseInt( $("#operador_id").val() );

                if ( operador_id <= 0 || isNaN(operador_id) ) {
                    $("#btnSaveSolicitud").attr("disabled", true);
                    alert("Seleccione un Operador");
                    return false;
                }

                if ( denuncia_id <= 0 || isNaN(denuncia_id) ) {
                    $("#btnSaveSolicitud").attr("disabled", true);
                    alert("Proporcione el ID de la solicitud");
                    return false;
                }

                $.ajax({
                    method: "POST",
                    url: "/getSolicitudesAmbitoAjaxFromOperator",
                    data: "denuncia_id="+denuncia_id+"&operador_id="+operador_id
                })
                .done(function (response) {
                    var OK = response.mensaje === "OK";
                    var data = response.data;
                    if (!OK) {
                        alert(data);
                    }
                    window.location.href = "/denuncia_operador_list/"+operador_id;
                });
            });
        }


        if ( $("#operador_id").length > 0)  {
            $("#operador_id").on("change", function (event) {
                var operador_id = parseInt( $("#operador_id").val() );
                if ( operador_id <= 0 || isNaN(operador_id) ) {
                    $("#btnSaveSolicitud").attr("disabled", true);
                    isValidSave();
                    return false;
                }
                $.ajax({
                    url: "/getUser/"+operador_id,
                    dataType: "json",
                    data: {
                    },
                    success: function(response) {
                        var dataUser = response.data;
                        $("#user_roles").html(dataUser.roles);
                        $("#user_permissions").html(dataUser.permissions);
                        $("#user_unidades").html(dataUser.unidades);
                        $("#user_curp").html(dataUser.curp+" ("+dataUser.id+")" );
                        //getSolocitudesDeOperador();
                        //isValidSave();

                        showTableData();

                    },
                });



                // $("#btnSaveSolicitud").attr("disabled", false);


            });
        }

        $("#btnGetSolicitudesOperator").on("click", function (event) {
            getSolocitudesDeOperador();
        })

        function getSolocitudesDeOperador() {
            var operador_id = parseInt( $("#operador_id").val() );
            if ( operador_id <= 0 || isNaN(operador_id) ) {
                alert("Seleccione un Operador");
                return false;
            }
            window.location.href = "/denuncia_operador_list/"+operador_id;
        }

        $("#btnGetSolicitudOperator").on("click", function (event) {
            var denuncia_id = parseInt( $("#denuncia_id").val() );
            if ( denuncia_id <= 0 || isNaN(denuncia_id) ) {
                alert("Proporcione el ID de la solicitud");
                return false;
            }
            window.location.href = "/denuncia_solicitud_id_list/"+denuncia_id;
        })

        // operador_id


        function isValidSave() {
            var operador_id = parseInt( $("#operador_id").val() );
            if ( operador_id <= 0 || isNaN(operador_id) ) {
                $("#btnSaveSolicitud").attr("disabled", true);
                return false;
            }
            var denuncia_id = parseInt( $("#denuncia_id").val() );
            if ( denuncia_id <= 0 || isNaN(denuncia_id) ) {
                $("#btnSaveSolicitud").attr("disabled", true);
                return false;
            }

            $("#btnSaveSolicitud").attr("disabled", false);

            return true;
        }


        function getGeoRefHtml(data) {
            var html = "";
            if (data.latitud > 0) {
               html = `<a href="https://www.google.com/maps/place/${data.latitud},${data.longitud}/${data.latitud},${data.longitud},15z"
                       class="action-icon text-center icon_globo_terraqueo_interno"  target="_blank"
                       data-toggle="tooltip" title="Geolocalización"
                        >
                        <i class="fas fa-globe-americas"></i>
                        </a>`;
            }
            return html;
        }

        function showTableData(){

            var operador_id = parseInt( $("#operador_id").val() );
            if ( operador_id <= 0 || isNaN(operador_id) ) {
                $("#btnSaveSolicitud").attr("disabled", true);
                return false;
            }

            var formData = new FormData();
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('operador_id', operador_id);

            $.ajax({
                url: "/getSolicitudesDeUsuarioAjax",
                dataType: "json",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $("#tblSolicitudesOperador > tbody").empty();
                    response.data.data.forEach(item => {
                        // Formatear fecha al estilo dd-mm-yyyy HH:mm
                        var dt = new Date(item.denuncia.fecha_ingreso);
                        var fechaFormateada = [
                            String(dt.getDate()).padStart(2,'0'),
                            String(dt.getMonth()+1).padStart(2,'0'),
                            dt.getFullYear()
                        ].join('-') + ' ' + String(dt.getHours()).padStart(2,'0') + ':' + String(dt.getMinutes()).padStart(2,'0');

                        // Último comentario de la cadena de estatus
                        var ultimaObs = (item.denuncia.ultimo_estatu_denuncia_dependencia_servicio || []).slice(-1)[0];
                        var observaciones = ultimaObs ? (ultimaObs.observaciones || '') : '';

                        var tr = `<tr>
                            <td>${item.denuncia.id}</td>
                            <td>${item.operador.full_name}</td>
                            <td>${item.denuncia.ciudadano.full_name}</td>
                            <td>${item.denuncia.servicio.servicio}<br><br>${item.denuncia.descripcion}</td>
                            <td>${item.denuncia.ultimo_estatus.estatus}</td>
                            <td>${fechaFormateada}</td>
                            <td>${observaciones}</td>
                            <td>
                                <a href="#"
                                   id="removeSolicitudOperador-${item.id}"
                                   class="action-icon text-center text-danger removeOperadorSolicitud"
                                   data-toggle="tooltip"
                                   title="Eliminar permanentemente este objeto.">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </a>
                            </td>
                        </tr>`;
                        $("#tblSolicitudesOperador > tbody").append(tr);
                    });
                }
            });
        }

        // Delegación para el botón eliminar de filas dinámicas en tblSolicitudesOperador
        $(document).on('click', '.removeOperadorSolicitud', function(event) {
            event.preventDefault();
            var aID  = event.currentTarget.id.split('-');
            var id   = aID[1];
            var ruta = aID[0];

            var confirmado = confirm("¿Desea eliminar el registro: " + id + "?");
            if (!confirmado) return false;

            $.ajax({
                method: "GET",
                url: '/' + ruta + '/' + id
            }).done(function(response) {
                if (response.data === 'OK') {
                    alert(response.mensaje);
                    // Eliminar la fila del DOM sin recargar la página
                    $('#removeSolicitudOperador-' + id).closest('tr').remove();
                } else {
                    alert(response.mensaje);
                }
            });
        });

    });
});