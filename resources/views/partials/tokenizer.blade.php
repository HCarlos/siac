<!DOCTYPE html>
<html>

<body>
<form id="myForm" method="" action="" >
    <input type="text" name="curp" id="curp">
    <button type="submit">Enviar</button>
</form>

<div id="resultado"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Obtener el token CSRF desde Laravel

    jQuery(function($) {
        $(document).ready(function() {

            var token = "2708|v2LToSSFvvtiE3bHOc6jJJoQBoWPAMk6x8QuHkfY";
            // 1. Configuración global de cabeceras
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-Token': $("meta[name='csrf-token']").attr("content"),
            //         'Authorization': 'Bearer ' + token + '' , // Token de autenticación
            //         'Accept': 'application/json' // Asegurar formato JSON
            //     }
            // });

            $("#myForm").on('submit', function(event) {
                event.preventDefault();

                // 2. Obtener datos del formulario
                const formData = {
                    curp: $("#curp").val() // Mejor práctica usando jQuery
                };

                // url: 'http://localhost:8000/api/v1b/localidades/', // URL completa para evitar CORS

                // 3. Configuración AJAX con soporte CORS
                $.ajax({
                    url: 'https://siac.villahermosa.gob.mx/api/v1b/localidades', // URL completa para evitar CORS
                    data: formData,
                    method: 'GET',
                    dataType: 'json', // Esperar respuesta JSON
                    crossDomain: true, // Habilitar solicitudes entre dominios
                    contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                    beforeSend: function(xhr) {

                        xhr.setRequestHeader('Authorization','Bearer ' + token);

                        // 4. Validar token antes de enviar
                        // if (!localStorage.getItem('access_token')) {
                        //     alert("Token de acceso no disponible");
                        //     return false;
                        // }
                    }
                })
                    .done(function(response) {
                        if (response.msg === "OK") {
                            $("#resultado").html(JSON.stringify(response.localidades));
                        } else {
                            alert(response.msg || "Error en la respuesta");
                        }
                    })
                    .fail(function(jqXHR) {
                        // 5. Manejo mejorado de errores CORS
                        const errorMsg = jqXHR.status === 0 ?
                            "Error de red/CORS. Verifique la URL y los encabezados del servidor "+token :
                            "Error " + jqXHR.status + ": " + jqXHR.responseText;

                        alert(errorMsg);

                    });
            });
        });
    });

</script>

</body>
</html>
