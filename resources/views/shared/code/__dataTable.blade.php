
@section('script_extra')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"> </script>
    <script>
        jQuery(function($) {
            $(document).ready(function() {

                $("#preloaderLocal").hide();
                $('#tblCat').removeClass('hide');

                var nCols = $('#tblCat').find("tbody > tr:first td").length;
                var aCol = [];

                for (i = 0; i < nCols - 1; i++) {aCol[i] = {};}
                aCol[nCols - 1] = {"sorting": false};

                oTable = $('#tblCat').DataTable({
                    "oLanguage": {
                        "sLengthMenu": "_MENU_ registros por página",
                        "oPaginate": {
                            "sPrevious": "&lsaquo;",
                            "sNext": "&rsaquo;"
                        },
                        "sSearch": "Buscar",
                        "sProcessing":"Procesando...",
                        "sLoadingRecords":"Cargando...",
                        "sZeroRecords": "No hay registros",
                        "sInfo": "_START_ - _END_ de _TOTAL_ registros",
                        "sInfoEmpty": "No existen datos",
                        "sInfoFiltered": "(De _MAX_ registros)"
                    },
                    "aaSorting": [[ 0, "desc" ]],
                    "aoColumns": aCol,
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                    "bRetrieve": true,
                    "bDestroy": false
                });

                $('.btnAction1').on('click', function(event) {
                    event.preventDefault();
                    $("#myModal .modal-body").empty();
                    $("#myModal .modal-body").html('<div class="fa-2x"><i class="fa fa-cog fa-spin"></i> Cargado datos...</div>');
                    $("#myModal").modal('show');
                    // alert( event.currentTarget.id);
                    var aID = event.currentTarget.id.split('-');
                    var Url = aID[0] + aID[1] + "/" + aID[2];
                    $(function () {
                        $.ajax({
                            method: "get",
                            url: Url
                        })
                            .done(function (response) {
                                $("#myModal .modal-body").html(response);
                            });
                    });
                });
            });
        });

    </script>
@endsection