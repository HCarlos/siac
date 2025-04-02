@extends('layouts.app')

@section('content')

<body>
    <div class="wrapper">
        @include('partials/left-sidebar')
        <div class="content-page">
            <div class="content">
                @include('partials/topbar')

                <div class="container-fluid home">
{{--                    <h4>--}}
{{--                        @if($user->genero === 0)--}}
{{--                            Bienvenida: <strong class="text-danger">{{ $user->full_name }}</strong>--}}
{{--                        @else--}}
{{--                            Bienvenido: <strong class="text-primary">{{ $user->full_name }}</strong>--}}
{{--                        @endif--}}
{{--                    </h4>--}}

                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Profile -->
                            <div class="card bg-secondary">
                                <div class="card-body profile-user-box">

                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="media">
                                                <span class="float-left m-2 mr-4">
                                                    <img src="{{ Auth::user()->PathImageThumbProfile }}?timestamp='{{ now() }}'" style="height: 100px;" alt="" class="rounded-circle img-thumbnail">
                                                </span>
                                                <div class="media-body">
                                                    @if($user->genero === 0)
                                                        <h4 class="mt-1 mb-1 text-danger">{{ $user->full_name }}</h4>
                                                    @else
                                                        <h4 class="mt-1 mb-1 text-info">{{ $user->full_name }}</h4>
                                                    @endif
                                                    <p class="font-13 text-white-50">{{ str_replace('|',', ',$user->RoleNameStrArray) }}</p>

                                                    <ul class="mb-0 list-inline text-light">
                                                        <li class="list-inline-item mr-3">
                                                            <h5 class="mb-1">{{ str_replace('|',', ',$user->DependenciaAbreviaturaArray) }}</h5>
                                                            <p class="mb-0 font-13 text-white-50">Unidad(es)</p>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <h5 class="mb-1">{{ \Carbon\Carbon::parse($user->logged_at)->format('d-m-Y H:i:s') }}</h5>
                                                            <p class="mb-0 font-13 text-white-50">Último acceso</p>
                                                        </li>
                                                    </ul>
                                                </div> <!-- end media-body-->
                                            </div>
                                        </div> <!-- end col-->

                                        <div class="col-sm-4">
                                            <div class="text-center mt-sm-0 mt-3 text-sm-right">
                                                <a href="{{ route('edit') }}" type="button" class="btn btn-light">
                                                    <i class="mdi mdi-account-settings-variant mr-1"></i> Mi Perfil
                                                </a>
                                            </div>
                                        </div> <!-- end col-->
                                    </div> <!-- end row -->
                                </div> <!-- end card-body/ profile-user-box-->
                            </div><!--end profile/ card -->

                            <div class="card bg-default">
                                <div class="card-body profile-user-box">
                                    <div class="row">
                                        <div class="col-12 col-md-8">
                                            <div class="media align-items-center">
                                                <div class="mr-4">
{{--                                                    <h3 class="blink text-danger">Novedades</h3>--}}
{{--                                                    <ul class="list-inline mb-0 text-light">--}}
{{--                                                        <li class="list-inline-item mr-3">--}}
{{--                                                            <p class="mb-0 text-muted">--}}
{{--                                                                <i class="mdi mdi-arrow-right-bold mr-1"></i> En <b>Servicios Municipales</b>, es obligatorio capturar por lo menos el <i>número de celular</i> y <i>buscar coincidencias</i>.--}}
{{--                                                            </p>--}}
{{--                                                            <p class="mb-0 text-muted">--}}
{{--                                                                <i class="mdi mdi-arrow-right-bold mr-1"></i> <b>Limpia el cache</b> de tu navegador periódicamente para mejorar la <i>velocidad de carga</i> y la <i>seguridad</i>.--}}
{{--                                                            </p>--}}
{{--                                                        </li>--}}
{{--                                                    </ul>--}}

                                                    @if (Auth::user()->hasRole('Administrator|SysOp|test_admin|SERVICIOS_MUNICIPALES'))
{{--                                                        @if (Auth::user()->hasRole('Administrator'))--}}

                                                        <div class="title text-left">Tips para buscar algunas de estas localidades</div>
                                                        <table>
                                                            <thead>
                                                            <tr>
                                                                <th>ZONA</th>
                                                                <th>Busqueda</th>
                                                                <th>Ubicación Google</th>
                                                                <th>Observaciones</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>



                                                            <tr>
                                                                <td>SABINA</td>
                                                                <td>FRACC HACIENDA CANTABRIAS</td>
                                                                <td>W2XX+92, Sabina, 86153 Villahermosa, Tab., México</td>
                                                                <td>En algunos casos se tiene que dar zoom para encontrar las localidades</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>SABINA</td>
                                                                <td>HACIENDA SANTA RITA</td>
                                                                <td>X22X+FQ, Sabina, 86153 Villahermosa, Tab., México</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>SABINA</td>
                                                                <td>HACIENDA LAS LILIAS</td>
                                                                <td>Hacienda las Lilias Circuito 1 #313 Fraccionamiento Haciendas, Sabina, 86153 Villahermosa, Tab., México</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>SABINA</td>
                                                                <td>FRACC HACIENDAS FAMILY</td>
                                                                <td>Calle Principal s/n, Sabina, 86153 Villahermosa, Tab., México</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>SABINA</td>
                                                                <td>FRACC LAS BRISAS (GUAYABAL)</td>
                                                                <td>Cto. de Las Brisas 104, Guayabal, 86095 Villahermosa, Tab., México</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>COUNTRY</td>
                                                                <td>FRACC ZAFIRO</td>
                                                                <td>223G+34 Villahermosa, Tabasco</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>COUNTRY</td>
                                                                <td>FRACC HACIENDA CASA BLANCA</td>
                                                                <td>Blvd. Bicentenario 1, Fraccionamiento Hacienda Casa Blanca I, Villahermosa, Tab., México</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>COUNTRY</td>
                                                                <td>FRACC PUERTA MAGNA</td>
                                                                <td>Puerta Magna, Sauce 53, 86287 Villahermosa, Tab., México</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>COUNTRY</td>
                                                                <td>FRACC VALLE DEL JAGUAR</td>
                                                                <td>Valle del Jaguar, Ermitaño 12, 86287 Villahermosa, Tab., México</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>PARRILLA</td>
                                                                <td>FRACC ALBORADA</td>
                                                                <td>Prol. Juan XXIII 575, Parrilla 1ra. Secc., 86284 Parrilla, Tab., México</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>PARRILLA</td>
                                                                <td>FRACC CASA PARA TODOS (LA LIMA)</td>
                                                                <td>Laguna La Ceiba, Parrilla 1ra. Secc., Casa Para Todos, 86284 Parrilla, Tab.</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>PARRILLA</td>
                                                                <td>FRACC LOS ALMENDROS</td>
                                                                <td>Del Naranjo 1 7, Parrilla 1ra. Secc., Los Almendros, 86288 La Lima, Tab., México</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>PARRILLA</td>
                                                                <td>FRACC EL ARBOL (HUAPINOL)</td>
                                                                <td>Cedro 8, Residencial El Árbol, 86284 Guapinol, Tab., México</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>PARRILLA</td>
                                                                <td>FRACC JARDINES DE HUAPINOL</td>
                                                                <td>Tulipanes, 86284 Guapinol, Tab., México</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>



                                                            <tr>
                                                                <td>COLINAS DE SANTO DOMINGO</td>
                                                                <td>FRACC COLINAS DE SANTO DOMINGO</td>
                                                                <td>Colinas de Santo Domingo 17, Fraccionamiento Colinas Santo Domingo Centro, 86270 Fraccionamiento Ocuiltzapotlán Dos, Tab., México</td>
                                                                <td class="observaciones"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>R/A FRANCISCO I MADERO 1RA SECCIÓN</td>
                                                                <td>Francisco I Madero Primera Secc., 86270 Medellín y Pigua 3ra. Secc., Tab., México</td>
                                                                <td>Francisco I Madero Primera Secc., 86270 Medellín y Pigua 3ra. Secc., Tab., México</td>
                                                                <td class="observaciones"></td>
                                                            </tr>




                                                            <tr>
                                                                <td>FRACC FRAMBOYANES (TIERRA COLORADA)</td>
                                                                <td>Residencial Framboyanes</td>
                                                                <td>Las Palmas 11, Residencial Framboyanes, 86020 Villahermosa, Tab., México</td>
                                                                <td class="observaciones"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Carlos Pellicer</td>
                                                                <td>Medellín y Madero 2da</td>
                                                                <td>C. Tomas Díaz Bartlet 238, Carlos Pellicer Cámara, 86270 Medellín y Madero 2da. Secc., Tab., México</td>
                                                                <td class="observaciones"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>SABINA</td>
                                                                <td>FRACC REAL DE SABINA</td>
                                                                <td>Calle Principal 53, Sabina, 86153 Villahermosa, Tab., México</td>
                                                                <td class="observaciones"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>SABINA</td>
                                                                <td>FRACC LOMAS DEL DORADO</td>
                                                                <td>La Palma 103, Sabina, 86153 Villahermosa, Tab., México</td>
                                                                <td class="observaciones"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>PLAZA VILLAHERMOSA</td>
                                                                <td>FRACC CENTROPOLIS</td>
                                                                <td>Palapa Centropolis, Plaza Villahermosa, 86170 Villahermosa, Tab., México</td>
                                                                <td class="observaciones"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>

                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="media">
                                            </div>
                                        </div>
                                    </div> <!-- end row -->
                                </div> <!-- end card-body/ profile-user-box-->
                            </div><!--end profile/ card -->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->


                </div>
                <!-- container -->
            </div>
        </div>
            <!-- content -->
        @include('partials/footer')
    </div>

@include('partials.full_modal')
@include('partials/script_footer')

</body>

@endsection

@section('styles')
    <style>

    table {
    width: 100%;
    border-collapse: collapse;
    margin: 0 auto;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
    }
    th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    }
    th {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
    }
    tr:nth-child(even) {
    background-color: #f9f9f9;
    }
    tr:hover {
    background-color: #f1f1f1;
    }
    .observaciones {
    color: #888;
    font-style: italic;
    }
    .not-found {
    color: red;
    font-weight: bold;
    }
    .title {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
    font-size: 1.5em;
    }


        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
        .blink {
            animation: blink 1s linear infinite;
        }


    </style>
@endsection
