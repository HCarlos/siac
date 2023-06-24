jQuery(function($) {
    $(document).ready(function() {


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
            }
        });

        // var Tabla;
        function evalNotificationBadge(dependencia_id) {

            if ( $("#drop-notification-list").length > 0  ){
                $.ajax({
                    method: "GET",
                    data: formData,
                    url: '/get-notification-dependencias/' + dependencyencia_id
                })
                    .done(function( response ) {
                        var html = "";
                        if (response.result_msg == 'OK'){

                            $("#drop-notification-list").empty();

                            html = '<a className="nav-link dropdown-toggle nav-user arrow-none mr-0 bgc-success" ';
                            html += 'data-toggle="dropdown" href="#" role="button" aria-haspopup="false" ';
                            html += 'aria-expanded="false" style="background-color: darkseagreen"> ';
                            html += '<i className="fa fa-bell text-lg text-white icon-animated-bell mr-lg-2" ';
                            html += 'style="font-size: 24px"></i>';
                            html += '<span id="id-navbar-badge1" className="badge badge-lg bgc-warning text-white radius-round border-1 brc-success-tp5" style="background-color: palevioletred; font-size: 16px">3</span> </a>';
                            html += '<div className="dropdown-menu dropdown-menu-right dropdown-lg dropdown-menu-animated brc-primary-m3 ">';


                            $.each(response.data, function( index, value ) {
                                html += '<a href="#" className="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary" ';
                                html += 'style="background-color: thistle"> ';
                                html += '<div> ';
                                html += '<span className="text-primary-m1 font-bolder">Alex:</span> ';
                                html += '<span className="text-grey text-90">Ciao sociis natoque penatibus et auctor ...</span> ';
                                html += '<br/> ';
                                html += '<span className="text-grey-m1 text-85"> ';
                                html += '<i className="far fa-clock"></i> ';
                                html += 'a moment ago ';
                                html += '</span> ';
                                html += '</div> ';
                                html += '</a> ';

                            });
                            html += '</div> ';

                            $("#drop-notification-list").append(html);

                        }else{
                            $("#drop-notification-list").empty();
                        }
                    });

            }

        }
    });
});
