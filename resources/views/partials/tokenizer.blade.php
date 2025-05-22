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
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
                }
            });

            $("#myForm").on('submit', function (event) {
                event.preventDefault();
                const curp = document.getElementById('curp').value;
                var formData = {};
                formData['curp'] = curp;
                $.ajax({
                    url: 'usuariopost',
                    data: formData,
                    method: 'POST'
                }).done(function (response) {
                    if (response.mensaje === "OK") {
                        $("#resultado").html( JSON.stringify(response.data.curp) );
                    }else{
                        alert(response.data);
                    }
                }).fail(function (response) {
                    alert(response.data);
                });
            });
        });
    });

</script>

</body>
</html>
