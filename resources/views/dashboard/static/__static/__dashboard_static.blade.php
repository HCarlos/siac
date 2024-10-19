<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-4" style="padding: 0 !important;">

            <div class="card rounded-bottom rounded-top  card-force-1" style="height: 400px !important;">
                <div class="card-body rounde-bottom rounded-top " style="padding: 0 !important;">
                    <div class="title-bar-block title-bar-block-primary " >
                        <h4 class="float-left text-white">Solicitudes:</h4>
                        <h4 class="float-right text-white text-80">179</h4>
                    </div>
                    <div class="title-bar-block title-bar-block-lightgray " >
                        <strong class="float-left">Solicitudes por área</strong>
                    </div>
                    <ul class="circle-fill radius-round text-center align-items-center w-100 p-0 mb-3">
                        <li>
                            <div>
                                <div class=" rounded-circle bg-primary border-4 "></div>
                                <h4 class="rounded-circle flexbox-100">12</h4>
                            </div>
                            <strong class="font-bold font-18">Solicitudes <br>de limpia</strong>
                        </li>
                        <li>
                            <div class=" rounded-circle bg-primary ml-2 border-4 brc-blue-l2">
                                <h4 class="rounded-circle flexbox-100">65</h4>
                            </div>
                            <strong class="font-bold font-18">Solicitudes <br>de Obras</strong>
                        </li>
                        <li>
                            <div class=" rounded-circle bg-primary ml-2">
                                <h4 class="rounded-circle flexbox-100">102</h4>
                            </div>
                            <strong class="font-bold font-18">Solicitudes <br>del SAS</strong>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card rounded-bottom rounded-top card-force-1" style="height: 500px !important;" >
                <div class="card-body rounde-bottom rounded-top " style="padding: 0 !important;">
                    <ul class="charts-1  text-center align-items-center ">
                        <li>
                            <div class="mt-3" >
                                <div id="apex-chart-bar-1" ></div>
                            </div>
                            <strong class="font-bold font-18">Solicitud por tipo de servicio</strong>
                        </li>
                        <li>
                            <div class="mt-3" >
                                <div id="apex-chart-radialbar-1" ></div>
                            </div>
                            <strong class="font-bold font-18">Estatus de solicitudes atendidas</strong>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="card rounded-bottom rounded-top  card-force-1" >
                <div class="card-body rounde-bottom rounded-top " style="padding: 0 !important;">
                    <div class="title-bar-block title-bar-block-primary " >
                        <h4 class="float-left text-white">Solicitudes:</h4>
                        <h4 class="float-right text-white text-80">179</h4>
                    </div>
                    <ul class="charts-2 text-center align-items-center w-100 p-0 mb-3">
                        <li>
                            <div id="apex-chart-bar-column-1"></div>
                            <strong class="font-bold font-18">Estatus de solicitudes por mes</strong>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card rounded-bottom rounded-top card-force-1" >
                <div class="card-body rounde-bottom rounded-top " style="padding: 0 !important;">
                    <ul class="charts-2  text-center align-items-center ">
                        <li>
                            <div class="w-100 h-100 mb-3" >
                                <div id="map"></div>
                            </div>
                            <strong class="font-bold font-18">Ubicaciones</strong>
                        </li>
                    </ul>
                </div>
            </div>

    </div>
        <div class="col-lg-4">
            <div class="card rounded-bottom rounded-top  card-force-1" >
                <div class="card-body rounde-bottom rounded-top " style="padding: 0 !important;">
                    <div class="title-bar-block title-bar-block-primary " >
                        <button type="button" class="btn btn-secondary">
                            Solicitudes por día
                            <i class="fa fa-calendar-alt"></i>
                        </button>
                        <button type="button" class="btn btn-primary">
                            Solicitudes por mes
                            <i class="fa fa-calendar"></i>
                        </button>
                        <button type="button" class="btn btn-default">
                            Solicitudes por año
                            <i class="fa fa-calendar-plus"></i>
                        </button>
                    </div>
                    <ul class="table-one text-left align-items-center w-100 p-0 mb-3">
                        <li class="w-100">
                            <strong class="btn-strong-filter-1 font-bold font-18 w-100">Solicitudes próximas a vencer</strong>
                            <div id="table-1" class="w-100">


                                <div class="table-responsive-sm">
                                    <table class="table table-centered mb-0">
                                        <thead>
                                        <tr>
                                            <th>Servicio</th>
                                            <th>Unidad</th>
                                            <th>Proceso</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="bg-danger text-white">
                                            <td>Fuga de agua</td>
                                            <td>SAS</td>
                                            <td>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar progress-lg bg-dark" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td><i class="mdi mdi-circle text-gris-oscuro-1"></i> Vencidas</td>
                                        </tr>
                                        <tr>
                                            <td>Reparación de baches</td>
                                            <td>DOOTSM</td>
                                            <td>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar progress-lg bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td><i class="mdi mdi-circle text-warning"></i> Resuelto</td>
                                        </tr>
                                        <tr class="bg-success text-white">
                                            <td>Recoleción de basura</td>
                                            <td>CLRRS</td>
                                            <td>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar progress-lg bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td><i class="mdi mdi-circle text-info"></i> En proceso</td>
                                        </tr>
                                        <tr>
                                            <td>Reparación de luminarias</td>
                                            <td>SAPYE</td>
                                            <td>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar progress-lg bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td><i class="mdi mdi-circle text-success"></i> Resuelto</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive-->



                            </div>
                        </li>
                        <li>
                            <strong class="btn-strong-filter-1 font-bold font-18">Solicitudes urgentes</strong>
                            <div id="table-2"></div>
                        </li>
                        <li>
                            <strong class="btn-strong-filter-1 font-bold font-18">Solicitudes Prioritarias</strong>
                            <div id="table-3"></div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" >

    /* Solicitudes por tipo de Servicio */
    var optionsHorizontalBars = {
        series: [{
            name: 'Solicitudes',
            data: [1, 3, 8, 3, 2, 4, 9]
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
            enabled: false
        },
        xaxis: {
            categories: ['Poda de árboles', 'Reparacionde alcantarillas', 'Fuga de agua', 'Baches', 'Luminarias', 'Limpieza de drenajes', 'Recolecion de basura'],
        }
    };
    var chart = new ApexCharts(document.querySelector("#apex-chart-bar-1"), optionsHorizontalBars);
    chart.render();

    /* Estatus de solicitud */
    var optionsRadialBar = {
        series: [76],
        height:400,
        chart: {
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
            }
        },
        fill: {
            type: 'solid',
            colors: ['#B32824', '#EFB9A5D8'],
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
        }
    };
    var chart = new ApexCharts(document.querySelector("#apex-chart-radialbar-1"), optionsRadialBar);
    chart.render();

    /* Estatus por mes */
    var colors = ["#24aa03", "#edb606", "#870606"];
    var optionsBarColumn1 = {
        series: [{
            name: 'Solicitudes',
            data: [43, 15, 7]
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
            categories: ["Atendidas", "En Proceso", "Pendientes"],
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
                enabled: true,
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
            mapId: "AIzaSyBUl6Jk2_5yVYdnwidOuU9c8_ZBk7gGnfo",
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
    initMap();
    /* Finaliza mapa */



</script>

