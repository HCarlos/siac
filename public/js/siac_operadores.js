
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
                if ( denuncia_id <= 0 || isNaN(denuncia_id) ) {
                    alert("Proporcione el ID de la solicitud");
                    isValidSave();
                    return false;
                }

                $(function () {
                    $.ajax({
                        method: "PUT",
                        url: "/getDenunciaAmbitoAjaxFromId",
                        data: "denuncia_id="+denuncia_id

                    })
                    .done(function (response) {
                        var OK = response.mensaje === "OK";
                        var data = response.data;
                        if (!OK) {
                            alert(data);
                        }

                        // alert(data.denuncia);
                        $("#lblSolicitudId").html(data.id);
                        $("#solicitud").html(data.denuncia);
                        $("#sue").html(data.servicio_ultimo_estatus);
                        $("#ciudadano").html(data.ap_paterno_ciudadano+" "+data.ap_materno_ciudadano+" "+data.nombre_ciudadano);
                        $("#ubicacion").html(data.gd_ubicacion+" " + getGeoRefHtml(data));

                        isValidSave();

                    });
                });
            });
        }
        if ( $("#btnSaveSolicitud").length > 0  ){
            $("#btnSaveSolicitud").on("click", function (event) {

                var denucnia_id = parseInt( $("#denuncia_id").val() );
                var operador_id = parseInt( $("#operador_id").val() );

                if ( operador_id <= 0 || isNaN(operador_id) ) {
                    $("#btnSaveSolicitud").attr("disabled", true);
                    alert("Seleccione un Operador");
                    return false;
                }

                if ( denucnia_id <= 0 || isNaN(denucnia_id) ) {
                    $("#btnSaveSolicitud").attr("disabled", true);
                    alert("Proporcione el ID de la solicitud");
                    return false;
                }

                $(function () {
                    $.ajax({
                        method: "POST",
                        url: "/getSolicitudesAmbitoAjaxFromOperator",
                        data: "denuncia_id="+denucnia_id+"&operador_id="+operador_id

                    })
                        .done(function (response) {
                            var OK = response.mensaje === "OK";
                            var data = response.data;
                            if (!OK) {
                                alert(data);
                            }

                            window.location.href = "/denuncia_operador_list/"+operador_id;
                            // alert(data.denuncia);
                        });
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
                        isValidSave();
                    },
                });



                // $("#btnSaveSolicitud").attr("disabled", false);


            });
        }

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

    });
});
