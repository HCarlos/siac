
jQuery(function($) {
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
            }
        });

        $("#alertNotificationImageMobile").hide();
        $("#btnDenunciaUserFullModal").attr('disabled',true);


        if ( $("#btnDenunciaUserFullModal").length > 0  ){
            $("#btnDenunciaUserFullModal").on("click", function (event) {
                event.preventDefault();

                var Url = '/showModalDenunciaUserUpdate/'+$("#usuario_id").val();

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
                        });
                });
            });
        }

        if ( $(".formFullModalAjax").length > 0  ){

            alert(action);

            $(".formFullModalAjax").on("submit", function (event) {
                event.preventDefault();

                var action = event.currentTarget.action;


                $(function () {
                    $.ajax({
                        method: "PUT",
                        url: action,
                        data: $(this).serialize()

                    })
                    .done(function (response) {
                        var d = response.data;
                        if ( $("#lblCelulares") )  {
                            $("#lblCelulares").html(d.celulares);
                            $("#lblTelefonos").html(d.telefonos);
                            $("#lblEMails").html(d.emails);
                        }

                    });
                });
            });
        }




    });
});
