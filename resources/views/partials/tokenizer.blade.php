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
            // Configurar token CSRF
            const csrfToken = $("meta[name='csrf-token']").attr("content");

            $("#myForm").on('submit', function(event) {
                event.preventDefault();

                // $.ajax({
                //     url: 'https://siac.villahermosa.gob.mx/api/v1b/localidades',
                //     method: 'GET',
                //     success: function(data, status, xhr) {
                //         const allowedHeaders = xhr.getResponseHeader('Access-Control-Allow-Headers');
                //         console.log("Cabeceras permitidas:", allowedHeaders);
                //     },
                //     error: function(xhr) {
                //         console.error("Error en OPTIONS:", xhr.getAllResponseHeaders());
                //     }
                // });
                // return false;

                const curp = $("#curp").val();
                const token = "2722|P5hlFXZH3HsPPsJuEB8rzzb1r1xSb0lWfNFIaKqA"; //localStorage.getItem('access_token'); // Obtener token Bearer

                // Configurar proxy si es necesario (reemplazar con tu dominio)
                const PROXY_URL = "https://cors-proxy.tudominio.com/";
                const TARGET_URL = "https://siac.villahermosa.gob.mx/api/v1b/localidades";
                const FULL_URL = PROXY_URL ? PROXY_URL + TARGET_URL : TARGET_URL;

                $.ajax({
                    url: TARGET_URL,
                    method: 'GET',
                    data: { username: curp },
                    beforeSend: function(xhr) {
                        // Agregar cabeceras requeridas
                        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                        xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                        xhr.setRequestHeader('Accept', 'application/json');

                        // Cabeceras adicionales para CORS
                        xhr.setRequestHeader('Access-Control-Request-Headers', 'authorization');
                        xhr.setRequestHeader('Access-Control-Allow-Origin', '*');
                    },
                    crossDomain: true,
                    dataType: 'json',
                    success: function(response) {
                        $("#resultado").html(JSON.stringify(response));
                    },
                    error: function(xhr, status, error) {

                        // alert("error " + JSON.stringify(xhr));

                        let errorMsg = "Error: ";

                        if (xhr.status === 0) {
                            errorMsg += "Verifica tu conexión a internet o configuración CORS";
                        } else if (xhr.status === 401) {
                            errorMsg += "No autorizado. Token inválido o expirado";
                        } else if (xhr.status === 403) {
                            errorMsg += "Acceso prohibido por CORS: " + xhr.responseText;
                        } else {
                            errorMsg += xhr.status + " - " + error;
                        }

                        console.error("Detalles del error:", xhr);
                        alert(errorMsg);
                    }
                });
            });
        });
    });

</script>

</body>
</html>
