@section("script_extra")
<script >
    jQuery(function($) {
        $(document).ready(function() {
            if( $(".preloader") ){
                $(".preloader").hide();
            }

            if  ($("#fromPhotoProfile") ){
                $("#fromPhotoProfile").on("submit",function(event){
                    // event.preventDefault();
                    $("#btnSavePhoto").hide();
                    $(".preloader").show();
                })
            }

            if  ($("#frmComunidad") ){
                $("#frmComunidad").on("submit",function(event){
                    $("#cd_id").val( $("#ciudad_id").val() );
                    $("#mun_id").val( $("#municipio_id").val() );
                    $("#edo_id").val( $("#estado_id").val() );
                })
            }


        });
    });

</script>

@endsection
