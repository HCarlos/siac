<script>

    var strElements = "label, input, select, checkbox, textarea, radio, file, im, span";
    if( $("#formFullModal") ){
        $("#alertError").hide();
        $("#loader").hide();
        $("#formFullModal").unbind("submit");
        $("#formFullModal").on("submit", function (event) {
            event.preventDefault();
            $("#loader").show();
            $(".btnSaveLoader").prop("disabled", true);
            var $form = $(this);
            var url = $form.attr('action');
            var formData = {};
            $form.find(strElements).each(function() {
                formData[ $(this).attr('name') ] = $(this).val();
            });
            $.post(url, formData, function(response) {
                if (response.data === "OK") {
                    alert(response.mensaje);
                    $("#modalFull").modal('hide');
                    location.reload();
                }
            }).fail(function(response) {
                var err = JSON.stringify(response.responseJSON);
                if ( response.responseJSON.errors === undefined ) {
                    fillArray(response.responseJSON, $form)
                }else{
                    sayErrors(response.responseJSON.errors, $form);
                }
            });
        });
    }

    function sayErrors(errors, $form){
        if (typeof errors === 'string'){
            $("#alertError").show();
            $(".Error").html(errors);
            return false;
        }
        $form.find(strElements).each(function() {
            $(this).removeClass('has-error form-error');
        });
        $('.text-danger').empty();
        fillArray(errors, $form)
    }

    function fillArray(errors, $form){
        $.each( errors, function( key, val ) {
            $form.find('#' + key ).addClass('has-error form-error');
            $form.find('.has-' + key ).find('.text-danger').text(val);
            $form.find('.has-' + key ).addClass('text-danger');
        });
    }



</script>
