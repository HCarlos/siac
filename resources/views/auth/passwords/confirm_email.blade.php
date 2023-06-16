@extends('layouts.app')

@section('content')


<body class="auth-fluid-pages bg-registry  pb-0 m-0" >

<div class="auth-fluid m-0 p-0">
    <!--Auth fluid left content -->
    <div class=" p-0 m-0 bg-form" >
        <div class="d-flex h-15 " >
            @include('shared.code.__logo_guest')
        </div>
        <div class="align-items-center " >
            <div class="card-body">

                <!-- email send icon with text-->
                <div class="text-center m-auto">
                    <h4 class="text-white-50 text-center mt-4 font-weight-bold">Por favor, revisa tu email</h4>
                    <p class="text-white-50 mb-4">
                        Se ha enviado un email a: <br><b>{{$email}}</b>.<br>
                        Ingrese a su cuenta de correo y <br>haga click en el enlace que aparece <br>en la parte de abajo para cambiar <br>su contraseña.<br><br>
                        <a href="{{ route('login') }}" class="btn btn-danger-primary btn-block text-white ml-1"><b>INICIAR SESIÓN</b></a>
                    </p>
                </div>

                <!-- Footer-->

            </div> <!-- end .card-body -->
        </div> <!-- end .align-items-center.d-flex.h-100-->
    </div>
    <!-- end auth-fluid-form-box-->

    <!-- Auth fluid right content -->
    <div class="auth-fluid-right  m-0 p-0" >
        <img src="/images/web/bg-auth-login.png" height="100%" width="100%"  />
    </div>
    <!-- end Auth fluid right content -->
</div>
<!-- end auth-fluid-->

<!-- App js -->
@include('partials/script_footer')

</body>
@endsection
