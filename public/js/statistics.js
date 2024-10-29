
jQuery(function($) {
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
            }
        });

        if ( $(".btnFullModal").length > 0  ){
            $(".btnFullModal").on("click", function (event) {
                event.preventDefault();
            });
        }


    });

});
