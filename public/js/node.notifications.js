
jQuery(function($) {
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
            }
        });

        i = 0;
        window.Echo.channel('test-channel')
            .listen('.InserUpdateDeleteEvent', (data) => {
                if ( $("#pantallaMobileMaster") != null  ) {
                    alert(data.status + '\n' +
                        data.msg.status + '\n' +
                        data.msg.msg + '\n' +
                        data.msg.access_token + '\n' +
                        data.msg.token_type);
                }
                i++;
                $('#power').html(parseInt(data.power) * i);
                console.log(data.power)
            })
            .listen('.IUQDenunciaEvent', (data) => {
                if (parseInt(localStorage.isToast) === 1) {
                    // alert(Boolean(localStorage.isToast));
                    $.toast({
                        heading: 'SIAC',
                        text: data.msg,
                        icon: data.icon,
                        loader: true,
                        hideAfter: false,
                        loaderBg: '#9EC600',
                        position: 'top-right',
                    })
                }
                i++;
                $("#power").html(parseInt(data.power) * i);
                console.log(data.denuncia_id + " :: " + data.user_id);

                if ($('#dashboard-home').length > 0) {
                    if (data.trigger_type === 0) {
                        localStorage.last_denuncia_id = data.denuncia_id
                        localStorage.last_user_id = data.user_id
                        $('#denuncias_hoy').html(data.denuncias_hoy)
                        $('#porcentaje_hoy').removeClass('text-blue-m1')
                        $('#porcentaje_hoy').removeClass('text-danger-m1')
                        if (parseInt(data.porcentaje_hoy) > 0) {
                            $('#porcentaje_hoy').addClass('text-blue-m1');
                            $('#porcentaje_hoy').html(data.porcentaje_hoy + '% <i class="fa fa-arrow-up"></i>')
                        } else {
                            $('#porcentaje_hoy').addClass('text-danger-m1')
                            $('#porcentaje_hoy').html(data.porcentaje_hoy + '% <i class="fa fa-arrow-down"></i>')
                        }
                        // window.location.reload();

                        //evalNotificationBadge();
                    }
                }
            })
            .listen('.ChangeStatusEvent', (data) => {
                    // if ( parseInt(localStorage.isToast) === 1) {
                        $.toast({
                            heading: 'SIAC',
                            text: data.msg,
                            icon: data.icon,
                            loader: true,
                            hideAfter: false,
                            loaderBg: '#9EC600',
                            position: 'top-left',
                        });
                        alert(data.msg);
                    // }
                });


        localStorage.setItems = 0;
        window.Echo.channel('api-channel')
            .listen('.APIDenunciaEvent', (data) => {
                if ( parseInt(data.status) === 200 ){
                    i++;
                    // alert(data.power);
                    $('#power').html(parseInt(data.power) * i);
                    if ( $("#pantallaMobileMaster") != null ) {
                        localStorage.setItems++;
                        $("#alertNotificationImageMobile").show();
                        $("#labelTextMobile").html("Hay "+localStorage.setItems+" nuevo(s)");
                    }
                    console.log(data.denuncia_id+" : Mobile : "+data.user_id);
                }
            });


        window.Echo.channel('channel-update-denuncia-estatus-atendida')
            .listen('.DenunciaAtendidaEvent', (data) => {
                // if ( parseInt(localStorage.isToast) === 1) {
                    $.toast({
                        heading: 'SIAC',
                        text: data.msg,
                        icon: data.icon,
                        loader: true,
                        hideAfter: false,
                        loaderBg: '#9EC600',
                        position: 'top-left',
                    })
                // }
            });


    });

});

