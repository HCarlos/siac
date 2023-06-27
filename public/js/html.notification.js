jQuery(function($) {
    $(document).ready(function() {


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
            }
        });

        // var Tabla;
        function evalNotificationBadge() {

            if ( $(".drop-notification-list")  ){
                $(".drop-notification-list").addClass('collapse');
                // alert( $(".drop-notification-list").attr('id') );
                var dat = $(".drop-notification-list").attr('id').split('*');
//                alert(dat[1]);
                $.ajax({
                    method: "GET",
                    url: '/'+dat[0]+'/' + dat[1]
                })
                    .done(function( response ) {
                        var html = "";
                        //alert( response.mensaje);
                        if (response.mensaje === 'OK'){
                            if (parseInt(response.data.length) > 0) {
                                $("#id-navbar-badge1").html( response.data.length );
                                $.each(response.data, function( index, value ) {
                                    html = '<a href="/listDenunciaDependenciaServicio/'+value.denuncia_id+'" id="aUno-'+index+'" ';
                                    html += 'style="background-color: thistle"> ';
                                    html += '<div> ';
                                    html += '<span id="sp1'+index+'">('+value.abreviatura+')</span> ';
                                    html += '<strong id="sp0'+index+'">'+value.denuncia_id+':</strong> ';
                                    html += '<span id="sp2'+index+'">'+value.denuncia+'</span> ';
                                    html += '<br/> ';
                                    html += '<span id="sp3'+index+'"> ';
                                    html += '<i class="far fa-clock"></i> ';
                                    html += value.fecha_movimiento ;
                                    html += '</span> ';
                                    html += '</div> ';
                                    html += '</a> ';
                                    $("#dropMenu").append(html);
                                    $("#aUno-"+index).addClass('d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary');
                                    $("#sp1-"+index).addClass('text-primary-m1 font-bolder');
                                    $("#sp2-"+index).addClass('text-grey text-90');
                                    $("#sp3-"+index).addClass('text-grey-m1 text-85');
                                });
                            }
                            $(".drop-notification-list").removeClass('collapse');
                        }else{
                            //$("#dropMenu").empty();
                        }
                    });

            }

        }

        evalNotificationBadge();

    });
});
