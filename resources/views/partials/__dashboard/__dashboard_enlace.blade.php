<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6">
            <div class="card " style="width: 100% !important;">
                <div class="card-header">
                    <h4 class="header-title">Parámetros de Consulta</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dashboard_enlace') }}">
                        @csrf
                        <div class="form-row mb-1">
                            <label for="desde" class="col-md-2 col-form-label text-right">Desde</label>
                            <div class="col-md-4">
{{--                                {{ Form::date('desde', date('Y-m-d', strtotime($FI)), ['id'=>'desde','class'=>'form-control']) }}--}}
                                <input type="date" name="desde" id="desde" value="{{ date('Y-m-d', strtotime($FI)) }}" class="form-control">
                            </div>
                            <label for="hasta" class="col-md-2 col-form-label text-right">Hasta</label>
                            <div class="col-md-4">
{{--                                {{ Form::date('hasta', date('Y-m-d', strtotime($FF)), ['id'=>'hasta','class'=>'form-control']) }}--}}
                                <input type="date" name="hasta" id="hasta" value="{{ date('Y-m-d', strtotime($FF)) }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-md-8">
                            </div>
                            <div class="col-md-4  text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
        <div class="col-lg-6">
        </div> <!-- end col-->
    </div>
</div>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6">
            <div class="card " style="width: 100% !important;">
                <div class="card-header">
                    <h4 class="header-title">Total de Solicitudes ( {{ $FI.' - '.$FF }} )</h4>
                </div>
                <div class="card-body">
                    <div class="chart-widget-list">
                        @foreach($totales as $d)
                        <p>
                            <i class="mdi mdi-square-outline " style="background: {{ strtoupper(trim( $d[ 3 ])) }} !important;"></i> {{ $d[ 1 ] }}
                            <span class="float-right"></span> {{ $d[ 17 ] }}
                        </p>
                        @endforeach
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-lg-6" style="width: 100% !important;">
            <div class="card">
                <div class="card-body">
{{--                    <div class="mb-5 mt-4" id="bar1" style="width: 100%; height: 500px;"></div>--}}
                    <h4 class="header-title">Total de Solicitudes  ( {{ $FI.' - '.$FF }} )</h4>
                    <p>&nbsp;</p>
                    <div class="step-container" style="width: 100% !important;"></div>
{{--                    <div class="bar-container-horizontal" style="width: 100%;height: 1000px;"></div>--}}
                </div>
            </div>
        </div>

        <div class="col-lg-12" style="width: 100% !important;">
            <div class="card " style="width: 100% !important;">
                <div class="card-header">
                    <h4 class="header-title">Relación de Dependencia y Estatus ( {{ $FI.' - '.$FF }} ) </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Abreviatura</th>
                                @foreach($estatus as $d => $value)
                                    <th scope="col">{{ $value }}</th>
                                @endforeach
                                <th scope="col">Total</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($totalestatus as $d)
                                <tr>
                                    <td scope="row">{{ $d[ 0 ] }}</td>
                                    <td scope="row">{{ $d[ 2 ] }}</td>
                                    <td scope="row">{{ $d[ 4 ] == '0' ? '' : $d[ 4 ] }}</td>
                                    <td scope="row">{{ $d[ 5 ] == '0' ? '' : $d[ 5 ] }}</td>
                                    <td scope="row">{{ $d[ 6 ] == '0' ? '' : $d[ 6 ] }}</td>
                                    <td scope="row">{{ $d[ 7 ] == '0' ? '' : $d[ 7 ] }}</td>
                                    <td scope="row">{{ $d[ 8 ] == '0' ? '' : $d[ 8 ] }}</td>
                                    <td scope="row">{{ $d[ 9 ] == '0' ? '' : $d[ 9 ] }}</td>
                                    <td scope="row">{{ $d[ 10 ] == '0' ? '' : $d[ 10 ] }}</td>
                                    <td scope="row">{{ $d[ 11 ] == '0' ? '' : $d[ 11 ] }}</td>
                                    <td scope="row">{{ $d[ 12 ] == '0' ? '' : $d[ 12 ] }}</td>
                                    <td scope="row">{{ $d[ 13 ] == '0' ? '' : $d[ 13 ] }}</td>
                                    <td scope="row">{{ $d[ 14 ] == '0' ? '' : $d[ 14 ] }}</td>
                                    <td scope="row">{{ $d[ 15 ] == '0' ? '' : $d[ 15 ] }}</td>
                                    <td scope="row">{{ $d[ 16 ] == '0' ? '' : $d[ 16 ] }}</td>
                                    <td scope="row">{{ $d[ 17 ] == '0' ? '' : $d[ 17 ] }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div  id="chart_div" style="width: 100% !important; height: 1600px;"></div>
                </div>
        </div>
    </div>
</div>

@section("styles")

        <link href="{{ asset('css/vendor/britecharts.min.css')}}?timestamp()" rel="stylesheet" />

@endsection


@section("script_interno")

    <script src="{{asset("js/vendor/d3.min.js")}}"></script>
    <script src="{{asset("js/demo.dashboard.js")}}"></script>
    <script src="{{asset("js/demo.vector-maps.js")}}"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" >




    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.load('visualization', '1', {packages: ['corechart', 'bar']});
    // google.setOnLoadCallback(drawChart);
    google.setOnLoadCallback(drawChartMatrix);
    //google.charts.setOnLoadCallback(drawChart);

    // google.charts.setOnLoadCallback(drawChartMatrix);
        // google.charts.setOnLoadCallback(drawBasic);

    //google.charts.setOnLoadCallback(drawChart);

//    google.charts.setOnLoadCallback(drawChartMatrix);

    // google.charts.setOnLoadCallback(Stacked);


    function drawChart() {


        var data = google.visualization.arrayToDataTable([
            ["Dependencias", "Total", { role: 'style' } ],
                @foreach($totales as $d)
                      ['{{ $d[ 2 ] }}', {{ $d[ 17 ] }}, 'color: {{ $d[ 3 ] }}' ],
                @endforeach
        ]);

        // var xx = JSON.stringify(data);

        //alert(xx);

        var options = {
            title: 'Gráfica de Captura de Solicitudes ( {{ $FI.' - '.$FF }} )',
            subtitle: 'Consulta el : @php echo date('d-m-Y H:i:s') @endphp',
            chartArea: {width: '90%'},
            colors: [
                @foreach($totales as $d)
                     '{{ strtoupper(trim(  $d[ 3 ]  ))  }}',
                @endforeach
            ],
            bars: 'horizontal',
            theme: 'material',
        };

        var chart = new google.visualization.BarChart(document.getElementById('bar1'));
        chart.draw(data, options);

    }

    function drawChartMatrix() {

        var data = new google.visualization.arrayToDataTable([
                ['Estatus','Rec','Ges','EnP','NoP','Tur','Ord','Ana','Est','Amp','Sup','Res','Cer','RyT',{ role: 'annotation' }],
            @foreach($totalestatus as $d)
                [
                '{{  $d[2 ]  }}',
                {{ intval( $d[4] ) ?? '' }},
                {{ intval( $d[ 5 ] ) ?? 0 }},
                {{ intval( $d[ 6 ] ) ?? 0 }},
                {{ intval( $d[ 7 ] ) ?? 0 }},
                {{ intval( $d[ 8 ] ) ?? 0 }},
                {{ intval( $d[ 9 ] ) ?? 0 }},
                {{ intval( $d[ 10 ] ) ?? 0 }},
                {{ intval( $d[ 11 ] ) ?? 0 }},
                {{ intval( $d[ 12 ] ) ?? 0 }},
                {{ intval( $d[ 13 ] ) ?? 0 }},
                {{ intval( $d[ 14 ] ) ?? 0 }},
                {{ intval( $d[ 15 ] ) ?? 0 }},
                {{ intval( $d[ 16 ] ) ?? 0 }},
                '{{ intval( $d[ 17 ] ) ?? 0 }}'
            ],
        @endforeach

        ]);

        var options = {
            title: 'Gráfico de Estatus por Dependencia ( {{ $FI.' - '.$FF }} )',
            subtitle: 'SIAC',

            hwidth: 1400,
            height: 1600,
            isStacked: true,
            axes: {
                x: {
                    0: { side: 'top', label: 'Percentage'} // Top x-axis.
                }
            },
            bar: { groupWidth: "90%" },
            theme: 'material'

        };

        //alert(options);

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
        // alert(chart);

    }

    var stepData = [
            @foreach($totales as $d)
        { key: "{{ strtoupper(trim(  $d[ 2 ]  ))  }}", value: {{ $d[ 17 ] }} },
        @endforeach

    ];


    </script>

        <script src="{{asset('js/demo.chartjs.js')}}"></script>
        <script src="{{asset('js/vendor/britecharts.min.js')}}"></script>
        <script src="{{asset('js/demo.britechart.js')}}"></script>

@endsection()
