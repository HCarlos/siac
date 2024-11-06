<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-4" style="padding: 0 !important;">
            <div class="card rounded-bottom rounded-top  card-force-1" style="height: 400px !important;">
                <div class="card-body rounde-bottom rounded-top " style="padding: 0 !important;">
                    <div class="title-bar-block title-bar-block-primary " >
                        <h5 class="float-left text-white mt-2">Solicitudes: <small class="ml-1">{{ $rango_de_consulta }}</small></h5>
                        <h5 class="float-right text-white text-150 mt-1 ">{{ $srvTotal }}</h5>
                    </div>
                    <div class="title-bar-block title-bar-block-lightgray " >
                        <strong class="float-left">Solicitudes por área</strong>
                    </div>
                    <ul class="circle-fill radius-round text-center align-items-center w-100 p-0 mb-3">
                        <li>
                            <div>
{{--                                <div class=" rounded-circle bg-primary border-4 "></div>--}}
{{--                                <h4 class="rounded-circle flexbox-100">12</h4>--}}

                                <div>
                                    <span class="d-inline-block bgc-primary p-3 w-100 radius-round text-center border-4 brc-primary-l2">
                                         <span class="text-white text-170 w-10">{{ $srvLimpia }}</span>
                                     </span>
                                </div>
                            </div>
                            <strong>Solicitudes <br>de limpia</strong>
                        </li>
                        <li>
                            <div class="d-inline-block w-60-percent">
                                <span class="d-inline-block bgc-orange p-3 radius-round text-center border-4 brc-orange-l2">
                                     <span class="text-white text-170 ">{{ $srvOP }}</span>
                                </span>
                            </div>
                            <strong>Solicitudes <br>de Obras</strong>
                        </li>
                        <li>
                            <div>
                                <span class="d-inline-block bgc-green p-3 radius-round text-center border-4 brc-green-l2">
                                     <span class="text-white text-170 w-10">{{ $srvSAS }}</span>
                                </span>
                            </div>
                            <strong>Solicitudes <br>del SAS</strong>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card rounded-bottom rounded-top card-force-1" style="height: 500px !important;" >
                <div class="card-body rounde-bottom rounded-top " style="padding: 0 !important;">
                    <ul class="charts-1  text-center align-items-center ">
{{--                        <li>--}}
{{--                            <div class="mt-3" >--}}
{{--                                <div id="apex-chart-bar-1" ></div>--}}
{{--                            </div>--}}
{{--                            <strong class="font-bold font-18">Solicitud por tipo de servicio</strong>--}}
{{--                        </li>--}}
                        <li>
                            <div class="mt-3"  >
                                <div id="apex-chart-radialbar-1" ></div>
                                <strong class="font-bold font-18">Estatus de solicitudes atendidas</strong><br>
                                <small>{{ $selServ }} : <strong>{{ $srvTotal }}</strong></small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="card rounded-bottom rounded-top  card-force-1" >
                <div class="card-body rounde-bottom rounded-top " style="padding: 0 !important;">
                    <div class="form-row mb-1 col-sm-12">
                        <div class="col-sm-10 ml-1 mt-1">{{ $selServ }}</div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-xs px-2 btn-green mb-1 btnFullModal float-right mr-1" data-toggle="modal" data-target="#optionsModal">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <ul class="charts-2 text-center align-items-center w-100 p-0 mb-3">
                        <li>
                            <div id="apex-chart-bar-column-1"></div>
                            <strong class="font-bold font-18">Estatus de solicitudes : <strong>{{ $srvTotal }}</strong></strong>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card rounded-bottom rounded-top card-force-1" >
                <div class="card-body rounde-bottom rounded-top " style="padding: 0 !important;">
                    <ul class="charts-2  text-center align-items-center ">
                        <li>
                            <div class="w-100 h-100 mb-3" >
                                <div>
                                    <div class="mt-3" >
                                        <div id="apex-chart-bar-1" ></div>
                                    </div>
                                    <strong class="font-bold font-18">Solicitud por tipo de servicio : <strong>{{ $srvTotal }}</strong></strong>
                                </div>
{{--                                <div id="map"></div>--}}
                            </div>
{{--                            <strong class="font-bold font-18">Ubicaciones</strong>--}}
                        </li>
                    </ul>
                </div>
            </div>

    </div>
        <div class="col-lg-4">
            <div class="card rounded-bottom rounded-top  card-force-1" >
                <div class="card-body rounde-bottom rounded-top " style="padding: 0 !important;">
                    <div class="orm-row mb-1 col-sm-12" >

                        <div class="col-sm-10 ml-1 mt-1">{{ $selServ }}</div>
                        <div class="col-sm-1">
                        </div>

                    </div>
                    <ul class="table-one text-left align-items-center w-100 p-0 mb-3">
                        <li class="w-100">
                            <div class="btn-strong-filter-1 font-bold font-14 w-100-center">Solicitudes próximas a vencer: {{ $arrSrv4->count() }}</div>
                            <div id="table-0" class="w-100">
                                <div class="table-n-dashboard-statistics" >
                                    <table class=" table table-bordered table-striped dt-responsive nowrap font-14" >
                                        <thead>
                                        <tr class="">
                                            <th>Servicio</th>
                                            <th>Unidad</th>
                                            <th>F. Lim.</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody >
                                        @foreach($arrSrv4 as $item)
                                            <tr class="@if ( date('Y-m-d') > $item->fecha_ejecucion ) bgc-danger-l3 @endif">
                                                <td><small> {{ $item->nombre_corto_ss }} </small>
                                                    <small class="chikirimbita text-blue ">
                                                        <a href="{{route($item->firmado == true ? 'imprimir_denuncia_archivo' . '/' : 'imprimir_denuncia_respuesta' . '/', ['uuid'=>$item->uuid])}}" target="_blank">
                                                            {{ $item->id }}
                                                        </a>
                                                    </small>
                                                </td>
                                                <td><small> {{ $item->abreviatura }} </small></td>
                                                <td><small> {{ $item->fecha_ejecucion }} </small></td>
                                                <td><small> {{ $item->estatus }} </small></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </li>
                        <li class="w-100">
                            <div class="btn-strong-filter-1 font-bold font-14 w-100-center">Solicitudes urgentes: {{ $arrSrv5->count() }}</div>
                            <div id="table-1" class="w-100">
                                <div class="table-n-dashboard-statistics">
                                    <table class=" table table-bordered table-striped dt-responsive nowrap font-14" >
                                        <thead>
                                        <tr class="">
                                            <th>Servicio</th>
                                            <th>Unidad</th>
                                            <th>F. Lim.</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody >
                                        @foreach($arrSrv5 as $item)
                                            <tr class="@if ( date('Y-m-d') > $item->fecha_ejecucion ) bgc-danger-l3 @endif">
                                                <td><small> {{ $item->nombre_corto_ss }} </small>
                                                    <small class="chikirimbita text-blue ">
                                                        <a href="{{route($item->firmado == true ? 'imprimir_denuncia_archivo' . '/' : 'imprimir_denuncia_respuesta' . '/', ['uuid'=>$item->uuid])}}" target="_blank">
                                                            {{ $item->id }}
                                                        </a>
                                                    </small>
                                                </td>
                                                <td><small> {{ $item->abreviatura }} </small></td>
                                                <td><small> {{ $item->fecha_ingreso }} </small></td>
                                                <td><small> {{ $item->estatus }} </small></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </li>
                        <li class="w-100">
                            <div class="btn-strong-filter-1 font-bold font-14 w-100-center">Solicitudes prioritarias: {{ $arrSrv6->count() }}</div>
                            <div id="table-2" class="w-100">
                                <div class="table-n-dashboard-statistics">
                                    <table class=" table table-bordered table-striped dt-responsive nowrap font-14" >
                                        <thead>
                                        <tr class="">
                                            <th>Servicio</th>
                                            <th>Unidad</th>
                                            <th>F. Lim.</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody >
                                        @foreach($arrSrv6 as $item)
                                            <tr class="@if ( date('Y-m-d') > $item->fecha_ejecucion ) bgc-danger-l3 @endif">
                                                <td><small> {{ $item->nombre_corto_ss }} </small>
                                                    <small class="chikirimbita text-blue ">
                                                        <a href="{{route($item->firmado == true ? 'imprimir_denuncia_archivo' . '/' : 'imprimir_denuncia_respuesta' . '/', ['uuid'=>$item->uuid])}}" target="_blank">
                                                            {{ $item->id }}
                                                        </a>
                                                    </small>
                                                </td>
                                                <td><small> {{ $item->abreviatura }} </small></td>
                                                <td><small> {{ $item->fecha_ingreso }} </small></td>
                                                <td><small> {{ $item->estatus }} </small></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal de Opciones -->
<div class="modal fade m-0 p-0" id="optionsModal" tabindex="-1" role="dialog" aria-labelledby="optionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 640px; padding: 0px !important;">
        <div class="modal-content shadow border-none radius-2 ">
            <div class="modal-header modal-colored-header bg-info m">
                <h4 class="modal-title" id="modalHeaderFull">Opciones de Consulta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body col-sm-12">
                <form method="POST" action="dashboard-statistics" id="formFullModal" class="row">
                    {{ csrf_field() }}
                    <div class="form-group row col-sm-12">
                        <label for = "fecha_inicial" class="col-form-label col-sm-2">F. Inicial</label>
                        <input type="date" class="form-control col-sm-4" name="fecha_inicial" id="fecha_inicial" value="{{ $inicio_mes }}" />
                        <label for = "fecha_final" class="col-form-label col-sm-2">F. Final</label>
                        <input type="date" class="form-control col-sm-4" name="fecha_final" id="fecha_final" value="{{ $fin_mes }}" />
                    </div>

                    <div class="form-group row col-sm-12">
                        <label for = "servicio_id" class="col-form-label col-sm-2">Servicio</label>
                        <select id="servicio_id" name="servicio_id" class="form-control col-sm-10" size="1">
                            <option value="0" selected >Todos los servicio</option>
                            @foreach($servicios as $t)
                                <option value="{{$t->id}}" >{{ $t->nombre_corto_ss.' ('.$t->abreviatura_dependencia.')'  }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-12">
                        <button type="submit" class="btn btn-sm btn-primary btn-block px-4 text-600 radius-1 ">
                            Consultar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" >

    /* Solicitudes por tipo de Servicio */

    var sts1data = [@foreach($arrSrv1 as $d){{ $d->data }},@endforeach];
    var sts1cate = [@foreach($arrSrv1 as $d)"{{ $d->name }}",@endforeach];
    var optionsHorizontalBars = {
        series: [{
            name: 'Solicitudes',
            data: sts1data
        }],
        chart: {
            type: 'bar',
            height: 400,
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                borderRadiusApplication: 'end',
                horizontal: true,
            }
        },
        colors: ['#EFB9A5D8', '#E91E63'],
        dataLabels: {
            enabled: true,
            textAnchor: 'middle',
            style: {
                colors: ['#737171']
            },
            distributed: false,
        },
        xaxis: {
            categories: sts1cate,
        }
    };
    var chart = new ApexCharts(document.querySelector("#apex-chart-bar-1"), optionsHorizontalBars);
    chart.render();

    /* Estatus de solicitud */
    var optionsRadialBar = {
        series: [ {{ $atendidas }} ],
        chart: {
            height: 300,
            type: 'radialBar',
            offsetY: -20,
            sparkline: {
                enabled: false
            },
        },
        plotOptions: {
            radialBar: {
                startAngle: -90,
                endAngle: 90,
                track: {
                    background: "#e7e7e7",
                    strokeWidth: '97%',
                    margin: 5, // margin is in pixels
                    dropShadow: {
                        enabled: true,
                        top: 2,
                        left: 0,
                        color: '#999',
                        opacity: 1,
                        blur: 2
                    }
                },
                dataLabels: {
                    name: {
                        show: false
                    },
                    value: {
                        offsetY: -2,
                        fontSize: '22px'
                    }
                }
            }
        },
        grid: {
            padding: {
                top: -10
            },
        },
        fill: {
            type: 'solid',
            colors: ['#35b324'],
            gradient: {
                shade: 'dark',
                shadeIntensity: 0.4,
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 50, 53, 91],
            },
        },
        labels: ['Atendidas','Pendientes'],
        title: {
            text: 'Atendidas',
            align: 'center',
            floating: true,
            offsetX: 0,
            style: {
                fontSize: '12px',
                color: undefined,
                fontFamily: undefined,
                color:  '#263238',
            }
        },
        tooltip: {
            enabled: false,
        },
    };
    var chart = new ApexCharts(document.querySelector("#apex-chart-radialbar-1"), optionsRadialBar);
    chart.render();

    /* Estatus por mes */
    var colors = ["#24aa03", "#edb606", "#870606"];
    var optionsBarColumn1 = {
        series: [{
            name: 'Solicitudes',
            data: [{{$arrPorStatus[0]['porcentaje']}}, {{$arrPorStatus[1]['porcentaje']}}, {{$arrPorStatus[2]['porcentaje']}}],
        }],
        chart: {
            height: 250,
            type: 'bar',
            events: {
                click: function(chart, w, e) {
                    // console.log(chart, w, e)
                }
            },
            toolbar: {
                show: false,
            },
        },
        colors: colors,
        plotOptions: {
            bar: {
                columnWidth: '80%',
                height:'auto',
                borderRadius: 5,
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
                distributed: true,
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val + "%";
            },
            offsetY: -25,
            style: {
                fontSize: '12px',
                colors: ["#304758"]
            }
        },
        legend: {
            show: false

        },
        xaxis: {
            categories: ["Atendidas: "+{{$arrPorStatus[0]['atendidas']}}, "En Proceso: "+{{$arrPorStatus[1]['en_proceso']}}, "Pendientes: "+{{$arrPorStatus[2]['pendientes']}}],
            position: 'bottom',
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: {
                enabled: false,
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: true,
                formatter: function (val) {
                    return val + "%";
                }
            }

        },
    };
    var chart = new ApexCharts(document.querySelector("#apex-chart-bar-column-1"), optionsBarColumn1);
    chart.render();

    /* Inicia mapa */
    async function initMap() {
        // The location of Uluru
        const Data = [];
        Data.push([{lat:17.984446, lng:-92.948792}, "Juanita Ramos",12588,"Recibió apoyos de láminas"]);
        Data.push([{lat:17.985481666299027, lng:-92.94758644733166}, "Juan Lopez",854178,"Se reparó un bache en su calle"]);
        Data.push([{lat:17.984593866561635, lng:-92.94830527932858}, "Arnulfo Sánchez Acosta",52548,"Se le apoyó con Cemento"]);
        Data.push([{lat:17.984527042023625, lng:-92.94802163672213}, "Tiburcio Hernandez Rus",12588,"Se le apoyó con Pollitas ponedoras"]);
        Data.push([{lat:17.984838282787656, lng:-92.94864390919706}, "Macario Contreras",12588,"Recibió un molino eléctrico como apoyo"]);
        Data.push([{lat:17.98436513451899, lng:-92.94846748271176}, "Benancio Montesinos",12588,"Se arregló una fuga de agua frente a su domicilio"]);
        Data.push([{lat:17.984203266353163, lng:-92.94889836470196}, "Justina Hernández Pérez",12588,"Se cambió las luminarias que estaban apagadas enm su calle por nuevas."]);
        // Request needed libraries.
        //@ts-ignore
        const { Map, InfoWindow } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary(
            "marker",
        );
        // The map, centered at Data
        const map = new Map(document.getElementById("map"), {
            zoom: 18.5,
            center: Data[0][0],
            mapId: "{{ env('GOOGLE_MAPS_KEY') }}",
        });
        const infoWindow = new InfoWindow();

        Data.forEach(([position, title, id, apoyo], i) => {
            const pin = new PinElement({
                glyph: `${i + 1}`,
                scale: 1.5,
            });
            const marker = new AdvancedMarkerElement({
                map: map,
                position: position,
                title: "<h3>"+id+" "+title+"</h3><br><h4>"+apoyo+"</h4>",
                content:pin.element,
                gmpClickable: true,
                gmpDraggable: true,
            });
            marker.addListener("click", ({ domEvent, latLng }) => {
                const { target } = domEvent;
                infoWindow.close();
                infoWindow.setContent(marker.title);
                infoWindow.open(marker.map, marker);
                google.maps.event.removeListener(clickListener);
            });

        });
    }
    if (document.getElementById("map")){
        initMap();
    }
    /* Finaliza mapa */



</script>

