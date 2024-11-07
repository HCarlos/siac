<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Error</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset( '/images/favicon/favicon.png' ) }}">

        <!-- App css -->
        <link href="{{ asset( 'css/icons.min.css' ) }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset( 'css/app.min.css' ) }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset( 'css/atemun.css' ) }}" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card">
                            <!-- Logo -->
                            <div class="card-header pt-4 pb-4 text-center bgc-coral-l2">
                                <a href="index.html">
                                    <span><img src="/images/web/logo-0.png" alt="" /></span>
                                </a>
                            </div>

                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h1 class="text-error"><i class="mdi mdi-emoticon-sad"></i></h1>
                                    <h4 class="text-uppercase text-danger mt-3">Acceso Denegado</h4>
                                    <p class="text-muted mt-3">Lo sentimos, no tiene permisos para ejecutar esta acción.</p>

                                    <a class="btn btn-info mt-3" href="/"><i class="mdi mdi-reply"></i> Regresar al inicio</a>
                                </div>
                            </div> <!-- end card-body-->
                        </div>
                        <!-- end card -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
            Error
        </footer>

        <!-- App js -->
        <script src="{{ asset( 'js/app.min.js' ) }}"></script>
    </body>
</html>
