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
                                                            <h5 class="mb-1">{{ \Carbon\Carbon::parse($user->logged_at)->format('d-m-Y h:m') }}</h5>
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
