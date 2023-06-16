@section("script_extra_modal")
    <script >
        jQuery(function($) {
            $(document).ready(function() {

                if ( $(".removeItemListModal").length > 0  ){
                    $('.removeItemListModal').on('click', function(event) {
                        event.preventDefault();
                        var aID = event.currentTarget.id.split('-');
                        var x = confirm("Desea eliminar el registro: "+aID[1]);

                        if (!x){
                            return false;
                        }

                        var Url = '/'+aID[0]+'/'+aID[1];

                        $(function() {
                            $.ajax({
                                method: "GET",
                                url: Url
                            })
                                .done(function( response ) {
                                    if (response.data == 'OK'){
                                        alert(response.mensaje);
                                        window.location.reload();
                                    }else{
                                        alert(response.mensaje);
                                    }
                                })
                        });
                    });
                }

            });
        });

    </script>

@endsection