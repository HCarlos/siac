@extends('layouts.app')

@section('content')

    @section('styles')
        <link href="{{ asset('css/ace.css') }}" rel="stylesheet">
        <link href="{{ asset('js/@page-style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/ace-themes.css') }}" rel="stylesheet">
    @endsection

    <body >
        <div class="wrapper">
            @include('partials/left-sidebar')
            <div class="content-page">
                <div class="content">
                    @include('partials/topbar')
                    <div class="container-fluid home" >

                        <div class="row px-2 mt-3" id="dashboard-home" >








                            <div class="col-12 col-sm-6 col-lg-3 px-2 mb-2 mb-lg-0" >

                                <div class="bcard h-100 d-flex align-items-center p-3">

                                    <div>
                                        <span class="d-inline-block bgc-green-d1 p-3 radius-round text-center border-4 brc-green-l2">
                                             <i class="fa fa-id-card text-white text-170 w-4 h-4"></i>
                                         </span>
                                    </div>

                                    <div class="ml-3 flex-grow-1">
                                        <div class="pos-rel">
                                            <span class="text-dark-tp3 text-180">
                                                {{ $DenunciasHoy }}
                                            </span>
                                            <span class="@if($porc > 0) text-blue-m1 @else text-danger-m1 @endif  text-600 text-90 ml-15 text-nowrap">
                                                 {{ $porc }} %
                                                @if($porc > 0)
                                                     <i class="fa fa-arrow-up"></i>
                                                @elseif($porc === 0)
                                                @else
                                                    <i class="fa fa-arrow-down"></i>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="text-dark-tp4 text-110">
                                            Solicitudes de Hoy
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 px-2 mb-2 mb-lg-0">
                                <div class="bcard h-100 d-flex align-items-center p-3">
                                    <div>
                                        <span class="d-inline-block bgc-warning-d1 p-3 radius-round text-center border-4 brc-warning-l2">
                                            <i class="fa fa-id-card text-white text-170 w-4 h-4"></i>
                                        </span>
                                    </div>
                                    <div class="ml-3 flex-grow-1">
                                        <div class="pos-rel">
                                            <span class="text-dark-tp3 text-180">
                                                {{ $DenunciasAyer }}
                                            </span>
                                        </div>
                                        <div class="text-dark-tp4 text-110">
                                            Solicitudes de Ayer
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 px-2 mb-2 mb-lg-0">
                                <div class="bcard h-100 d-flex align-items-center p-3">
                                    <div>
                                        <span class="d-inline-block bgc-coral-d1 p-3 radius-round text-center border-4 brc-coral-l2">
                                            <i class="fa fa-id-card text-white text-170 w-4 h-4"></i>
                                        </span>
                                    </div>
                                    <div class="ml-3 flex-grow-1">
                                        <div class="pos-rel">
                                            <span class="text-dark-tp3 text-180">
                                                {{ $DenunciasUltimaHora }}
                                            </span>
                                            <span class="text-green-m1 text-600 text-90 ml-15 text-nowrap">
                                                 {{ $DenunciasUltima->dependencia->abreviatura }}
                                            </span>
                                            <small class="text-gray-dark text-600 text-90 ml-15 text-nowrap">
                                                ({{ $DenunciasUltima->creadopor->nombre }})
                                            </small>
                                        </div>
                                        <div class="text-dark-tp4 text-110">
                                            En la última hora
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 px-2 mb-2 mb-lg-0">
                                <div class="bcard h-100 d-flex align-items-center p-3">
                                    <div>
                                        <span class="d-inline-block bgc-info-d1 p-3 radius-round text-center border-4 brc-info-l2">
                                            <i class="fa fa-id-card text-white text-170 w-4 h-4"></i>
                                        </span>
                                    </div>
                                    <div class="ml-3 flex-grow-1">
                                        <div class="pos-rel">
                                            <span class="text-dark-tp3 text-180">
                                                {{ $DenunciasMesActual }}
                                            </span>
                                        </div>
                                        <div class="text-dark-tp4 text-110">
                                            En el mes
                                        </div>
                                        <div class="task-item mb-25 radius-3px bgc-secondary-l4 mt-1 pt-2 pb-2 pos-rel">
                                            <div class="progress position-bl w-100 h-auto">
                                                <div class="progress-bar bgc-success progress-bar-striped progress-bar-animated" role="progressbar" style="height: 6px; width: {{ $PorcResuelto }}%;" aria-valuenow="{{ $PorcResuelto }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="pl-1">
                                                <div>
                                                    Resueltos: {{$DenunciasResueltasMesActual}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="task-item mb-25 radius-3px bgc-secondary-l4 mt-1 pt-2 pb-2 pos-rel">
                                            <div class="progress position-bl w-100 h-auto">
                                                <div class="progress-bar bgc-danger progress-bar-striped progress-bar-animated" role="progressbar" style="height: 6px; width: {{ $PorcNoResuelto }}%;" aria-valuenow="{{ $PorcNoResuelto }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="pl-1">
                                                <div>
                                                    Sin Resolver: {{$DenunciasNoResueltasMesActual}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 px-2 mb-2 mb-lg-0 mt-1" >

                                <div class="card-header border-0">
                                    <div class="col-12 card-body p-3">
                                        <h5>Top <strong>5</strong> hoy</h5>
                                        @php $i = 0; @endphp
                                    @foreach($Top10Deps as $Dep)
                                            @php $valorPorc = number_format((($Dep->cantidad_dependencia/$DenunciasHoy) * 100), 0)  @endphp
                                            <div class="task-item mb-25 radius-3px bgc-secondary-l4 mt-1 pt-2 pb-2 pos-rel">
                                                <div class="progress position-bl w-100 h-auto">
                                                    <div class="progress-bar bgc-{{$colors[$i++]}} progress-bar-striped progress-bar-animated" role="progressbar" style="height: 6px; width: {{ $valorPorc }}%;" aria-valuenow="{{ $valorPorc }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="pl-1">
                                                    <div>
                                                        {{ $Dep->dependencia->abreviatura }}: <strong>{{ $Dep->cantidad_dependencia }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                    </div><!-- .card-body -->
                                </div>

                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 px-2 mb-2 mb-lg-0">
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 px-2 mb-2 mb-lg-0">
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 px-0 mb-2 mb-lg-0  mt-1">
                                <div class="card-header border-0">
                                    <div class="col-12 card-body ">
                                        <h5>Top <strong>5</strong> en el mes actual</h5>
                                        @php $i = 0; @endphp
                                        @foreach($Top10MesDeps as $Dep)
                                            @php $valorPorc = number_format((($Dep->cantidad_dependencia/$DenunciasMesActual) * 100), 0)  @endphp
                                            <div class="task-item mb-25 radius-3px bgc-secondary-l4 mt-1 pt-2 pb-2 pos-rel">
                                                <div class="progress position-bl w-100 h-auto">
                                                    <div class="progress-bar bgc-{{$colors[$i++]}} progress-bar-striped progress-bar-animated" role="progressbar" style="height: 6px; width: {{ $valorPorc }}%;" aria-valuenow="{{ $valorPorc }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="pl-1">
                                                    <div>
                                                        {{ $Dep->dependencia->abreviatura }}: <strong>{{ $valorPorc }}</strong>%
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div><!-- .card-body -->
                                </div>
                            </div>



































                        </div>
                    </div>
                <!-- content -->
            @include('partials/footer')
        </div>

    @include('partials.full_modal')

    @section('script')
        <script src="{{asset('js/ace.js')}}"></script>
        <script src="{{asset('js/@page-script.js')}}"></script>
    @endsection

    @include('partials/script_footer')


    </body>

@endsection
