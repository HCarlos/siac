<div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <!-- LOGO -->
            <a href="/listDenunciasAmbito2"  >
                <img src="{{asset('images/web/logo-0.png')}}" alt="" >
            </a>

        </div>
        <nav class="menu">
            @include('shared.ui_kit.__menu_dashboard_static')
        </nav>
    </aside>

    <!-- Main Content -->
    <main id="contenedor">
        <!-- Header -->
        <div class="title-wrapper">
            <h2 class="main-title--">{{ $titulo }}</h2>
            <p class="subtitle">Selecciona un filtro de tiempo para ver los datos detallados</p>
        </div>
        <form action="{{ url('/dashboard-statistics-custom-unity-post') }}" method="POST" id="formFilter">
            @csrf
            <header class="header">
                    <div class="radio-group">
                        <label class="radio-button">
                            <input type="radio" name="filter" value="hoy" class="filter-btn" @if(  $filter === 'hoy') checked @endif >
                            <span>Hoy</span>
                        </label>
                        <label class="radio-button">
                            <input type="radio" name="filter" value="mes" class="filter-btn" @if(  $filter === 'mes') checked @endif >
                            <span>Mes Actual</span>
                        </label>
                        <label class="radio-button">
                            <input type="radio" name="filter" value="anio" class="filter-btn" @if( $filter === 'anio') checked @endif >
                            <span>Año Actual</span>
                        </label>
                        <label class="radio-button">
                            <input type="radio" name="filter" value="free" class="filter-btn" @if( $filter === 'free') checked @endif>
                            <span>Rango de fecha</span>
                        </label>
                    </div>
                    <div class="date-picker">
                        <label for="start_date">F. Inicial</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $start_date }}">
                    </div>
                <div class="date-picker">
                        <label for="end_date">F. Final</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $end_date }}">
                    </div>
                    <div class="search-container">
                        <button class="search-btn" type="submit" >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="search-icon">
                                <path d="M10 2a8 8 0 105.29 14.29l4.35 4.35a1 1 0 001.42-1.42l-4.35-4.35A8 8 0 0010 2zm0 2a6 6 0 014.66 9.74 1 1 0 00-.14 1.41l4.35 4.35a1 1 0 001.42-1.42l-4.35-4.35a1 1 0 00-1.41.14A6 6 0 1110 4z" />
                            </svg>
                        </button>
                    </div>
            </header>
            <input type="hidden" name="unity_id" value="{{ $unity_id }}">
        </form>

        <!-- Stats -->
        <section class="stats">
            <div class="stat">
                <h2 id="h2Recibidas">0</h2>
                <p>Recibidas</p>
            </div>
            <div class="card-stat">
                <div class="card-left">
                    <h2 id="h2EnProcesoTotal">0</h2>
                    <p>En Proceso</p>
                </div>
                <div class="card-right">
                    <p><strong id="h2EnProcesoEP">0</strong> EN PROCESO</p>
                    <p><strong id="h2ObservadasEP">0</strong> OBSERVADAS</p>
                </div>
            </div>
            <div class="card-stat-2">
                <div class="card-left">
                    <h1 class="count green" id="h2Atendidas">0</h1>
                    <p>Atendidas</p>
                </div>
                <div class="card-right">
                    <table width="100%">
                        <tr>
                            <td colspan="4">
                                <div style="display: flex; justify-content: space-between;">
                                    <div class="card-right">
                                        <p><strong id="h2AtendidasAT">0</strong> ATENDIDAS<br>
                                            <strong id="h2CerradasAT">0</strong> CERRADAS</p>
                                    </div>
                                    <div style="text-align: left;" class="card-right">
                                        <p><strong id="h2Aatendidas">0</strong> A TIEMPO<br>
                                            <strong id="h2Abtendidas">0</strong> CON REZAGO</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-stat">
                <div class="card-left">
                    <h2 style="color: red;" id="h2RechazadasTotal">0</h2>
                    <p>Rechazadas</p>
                </div>
                <div class="card-right">
                    <p><strong id="h2RechazadasREC">0</strong> RECHAZADAS</p>
                    <p><strong id="h2CerradasREC">0</strong> CERRADAS</p>
                </div>
            </div>
{{--            <div class="stat">--}}
{{--                <h2 id="h2Cerradas">0</h2>--}}
{{--                <p>Cerradas</p>--}}
{{--            </div>--}}
{{--            <div class="stat">--}}
{{--                <h2 id="h2Observadas">0</h2>--}}
{{--                <p>Observadas</p>--}}
{{--            </div>--}}
            <div class="stat">
                <h2 id="h2Total">0</h2>
                <p>Todas</p>
            </div>
        </section>

        <div class="dashboard-container">
            <!-- Sección de solicitudes por área -->
            <div class="section">
                <div class="card" >

                    <div class="card-header">
                        <form class="form-modern">
                            <div class="form-group">
                                <label for="servicios">Servicios:</label>
                                <select class="form-select" name="servicios" id="servicios">
                                    <option value="0">Todos</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="delegaciones">Delegaciones:</label>
                                <select class="form-select delegaciones select2" name="delegaciones" id="delegaciones" data-toggle="select2" size="1" >
                                    <option value="0">Todas</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="colonias">Colonia:</label>
                                <select class="form-select colonias select2" name="colonias" id="colonias" data-toggle="select2" size="1" >
                                    <option value="0">Todas</option>
                                </select>
                            </div>
                            <button type="button" id="frmFilter" class="btn btn-primary btn-submit ms-auto">Filtrar</button>
                            <div class="form-group">
                                <label for="items">Items:</label>
                                <input type="text" name="items" id="items" value="0" class="totalItems" disabled>
                            </div>
                            <button type="button" id="frmFilterDataExport" class="btn btn-primary btn-export-excel ms-auto">
                                <i class="fas fa-file-excel text-white"></i> Exportar
                            </button>
                            @if( (int)$unity_id === 47 )
                            <button type="button" id="frmResumenBasicoExport" class="btn btn-primary btn-resume-basico ms-auto">
                                <i class="fas fa-file-excel text-white"></i> Resumen
                            </button>
                            @endif
                        </form>
                    </div>

                    <div class="map-container" id="map-container">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
            <!-- Charts Section -->
{{--            <div class="section">--}}
{{--                <div class="card">--}}
{{--                    <h3>Top 5 de servicios</h3>--}}
{{--                    <div class="top-requests">--}}
{{--                        <div><span id="u0"></span><span id="u0p" class="ml-1"></span></div>--}}
{{--                        <div><span id="u1"></span><span id="u1p" class="ml-1"></span></div>--}}
{{--                        <div><span id="u2"></span><span id="u2p" class="ml-1"></span></div>--}}
{{--                        <div><span id="u3"></span><span id="u3p" class="ml-1"></span></div>--}}
{{--                        <div><span id="u4"></span><span id="u4p" class="ml-1"></span></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card">--}}
{{--                    <div class="chart-container">--}}
{{--                        <h3>Solicitudes cerradas</h3>--}}
{{--                        <canvas id="closedRequestsChart" class="canvas_uno"></canvas>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--                <div class="card">--}}
{{--                    <div class="chart-container">--}}
{{--                        <h3>% solicitudes atendidas / rechazadas</h3>--}}
{{--                        <canvas id="solicitudesChart"></canvas>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

        </div>
    </main>
    <input type="hidden" id="zona" name="zona" value="0">
    <input type="hidden" id="denuncias" name="denuncias" value="">
</div>


{{--<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})--}}
{{--({key: "{{env('GOOGLE_MAPS_KEY')}}", v: "weekly"});</script>--}}

{{--<script src="/js/dashboard/dashboard_statistics_map_setup.js" type="text/javascript"></script>--}}
<script src="/js/dashboard/dashboard_statistics_osm_leaflet_setup.js" type="text/javascript"></script>

<script>

    document.addEventListener('DOMContentLoaded', () => {

        async function loadJSON(file_output) {
            try {
                // Solicita el archivo JSON (cámbialo al nombre de tu archivo)
                // alert(file_output);
                const response = await fetch(file_output);

                // Verifica si la solicitud fue exitosa
                if (!response.ok) {
                    throw new Error(`Error al cargar JSON: ${response.statusText}`);
                }
                // Convierte la respuesta a JSON
                const data = await response.json();

                // Llama a la función para renderizar los datos
                // console.log(data);
                initLoadData(data[0],data[1],data[2],data[3],data[4],data[5],data[6],data[7],data[8]);
            } catch (error) {
                console.error(error);
            }
        }


        function initLoadData(Estatus,Unidades,Servicios,Georeferencias,Otros,FiltroUnidades,FiltroServicios,FiltroColonias,FiltroDelegaciones) {

            let data1data = [];
            let data2data = [];
            let data3data = [];
            let data4data = [];
            let data5data = [];
            let data6data = [];

            let dataatiempo = [];
            let datarezago = [];

            let frmFilterDataExport = document.getElementById("frmFilterDataExport");
            frmFilterDataExport.disabled = true;

            let frmResumenBasicoExport = document.getElementById("frmResumenBasicoExport");
            frmResumenBasicoExport ? frmResumenBasicoExport.disabled = true : console.warn("El elemento con ID 'frmResumenBasicoExport' no se encontró en el DOM.");

            document.getElementById("h2Recibidas").innerHTML = Estatus.estatus[0].Total;
            document.getElementById("h2EnProcesoTotal").innerHTML = Estatus.estatus[1].Total + Estatus.estatus[4].Total;
            document.getElementById("h2EnProcesoEP").innerHTML = Estatus.estatus[1].Total;
            document.getElementById("h2ObservadasEP").innerHTML = Estatus.estatus[4].Total;

            document.getElementById("h2Atendidas").innerHTML = Estatus.estatus[2].Total + Estatus.estatus[5].Total;
            document.getElementById("h2AtendidasAT").innerHTML = Estatus.estatus[2].Total;
            document.getElementById("h2CerradasAT").innerHTML = Estatus.estatus[5].Total;
            document.getElementById("h2Aatendidas").innerHTML = Estatus.estatus[2].a_tiempo + Estatus.estatus[5].a_tiempo;
            document.getElementById("h2Abtendidas").innerHTML = Estatus.estatus[2].con_rezago + Estatus.estatus[5].con_rezago;

            document.getElementById("h2RechazadasTotal").innerHTML = Estatus.estatus[3].Total + Estatus.estatus[6].Total;
            document.getElementById("h2RechazadasREC").innerHTML = Estatus.estatus[3].Total;
            document.getElementById("h2CerradasREC").innerHTML = Estatus.estatus[6].Total;

            // document.getElementById("h2Cerradas").innerHTML = Estatus.estatus[5].Total;
            // document.getElementById("h2Observadas").innerHTML = Estatus.estatus[4].Total;

            document.getElementById("h2Total").innerHTML = Estatus.estatus[0].Total + Estatus.estatus[1].Total + Estatus.estatus[2].Total + Estatus.estatus[3].Total + Estatus.estatus[4].Total + Estatus.estatus[5].Total + Estatus.estatus[6].Total;

            Estatus.estatus[2].Unidades.forEach( (unidad) => {
                dataatiempo.push(unidad.a_tiempo);
                datarezago.push(unidad.con_rezago);
            });

            let j = 0;
            Servicios.servicios.forEach( (servicio) => {
                if ( document.getElementById("u" + j) ){
                    document.getElementById("u" + j).innerHTML = servicio.Servicio;
                    document.getElementById("u" + j + "p").innerHTML = servicio.Total;
                    j++;
                }
            });



            // % Atendidas vs Rechazadas
            // const ctx7a = document.getElementById('solicitudesChart');
            // const chart7a = new Chart(ctx7a, {
            //     type: 'bar',
            //     data: data3([Otros.otros[0].atendidas, Otros.otros[0].rechazadas]),
            //     options: opciones3()
            // });
            //
            // const ctx8a = document.getElementById('closedRequestsChart');
            // const chart8a = new Chart(ctx8a, {
            //     type: 'doughnut',
            //     data: data4([Otros.otros[0].atendidas, Otros.otros[0].observadas]),
            //     options: opciones4()
            // });
            //
            // Llamar a la función de inicialización cuando la página cargue

            // let Services = [];
            // let LabelServices = [];
            // Servicios.servicios.forEach( (servicio) => {
            //     Services.push(servicio.Total);
            //     LabelServices.push(servicio.Servicio);
            //     i++;
            // });

            // const ctx9a = document.getElementById('servicesChart');
            // const chart9a = new Chart(ctx9a, {
            //     type: 'bar',
            //     data: data5(LabelServices,Services),
            //     options: opciones5()
            // });

            const inputDenuncias = document.getElementById('denuncias');

            let dataSetLocations = [];
            let denuncias_id     = [];
            Georeferencias.georeferencias.forEach( (geo) => {
                dataSetLocations.push(setDataLocations(geo,denuncias_id));
            });
            inputDenuncias.value = denuncias_id.join(',');
            frmFilterDataExport.disabled = false;
            // frmResumenBasicoExport.disabled = false;
            frmResumenBasicoExport ? frmResumenBasicoExport.disabled = false : console.warn("");

            const selectZona = document.getElementById('zona');
            const selectServicios = document.getElementById('servicios');
            const selectColonias = document.getElementById('colonias');
            const selectDelegaciones = document.getElementById('delegaciones');
            const items = document.getElementById('items');

            selectZona.value = FiltroUnidades.filtro_unidades[0].dependencia_id;

            FiltroServicios.filtro_servicios.forEach(item => {
                if (parseInt(item.dependencia_id) === parseInt(selectZona.value)) {
                    const opcion = document.createElement('option');
                    opcion.value = item.sue_id;
                    opcion.text = item.servicio;
                    selectServicios.add(opcion);
                }
            });

            FiltroDelegaciones.filtro_delegaciones.forEach(del => {
                const opcion = document.createElement('option');
                opcion.value = del.delegacion_id;
                opcion.text = del.delegacion;
                selectDelegaciones.add(opcion);
            });


            selectDelegaciones.addEventListener('change', (event) => {
                {{--alert("@");--}}
                const selectedValue = selectDelegaciones.value;
                selectColonias.innerHTML = '<option value="0">Todos</option>';
                FiltroColonias.filtro_colonias.forEach(item => {
                    // alert(selectedValue +" - "+ item.delegacion_id)
                    if (selectedValue == item.delegacion_id) {
                        const opcion = document.createElement('option');
                        opcion.value = item.id;
                        opcion.text = item.colonia_delegacion;
                        selectColonias.add(opcion);
                    }
                });
            });


            document.getElementById('frmFilter').addEventListener('click', (event) => {
                event.preventDefault();
                filterMap(Georeferencias,frmFilterDataExport);
            })

            const btnFilterDataExport = document.getElementById('frmFilterDataExport');
            btnFilterDataExport.addEventListener('click', function () {
                // Deshabilita el botón si es necesario
                btnFilterDataExport.disabled = true;
                const inputDenuncias = document.getElementById('denuncias');
                var PARAMS = {
                    search : "",
                    items : inputDenuncias.value,
                    fileoutput : "fmt_lista_denuncias_sm.xlsx",
                    indice : 3,
                    _token : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };

                var temp=document.createElement("form");
                temp.action='/exportDataFilterMap3';
                temp.method="POST";
                temp.target="_blank";
                temp.style.display="none";
                for(var x in PARAMS) {
                    var opt=document.createElement("textarea");
                    opt.name=x;
                    opt.value=PARAMS[x];
                    temp.appendChild(opt);
                }
                document.body.appendChild(temp);
                temp.submit();
                return temp;

            });


            const btnResumenBasicoExport = document.getElementById('frmResumenBasicoExport');
            if (btnResumenBasicoExport) {
                btnResumenBasicoExport.addEventListener('click', function () {
                    btnResumenBasicoExport.disabled = true;
                    const inputDenuncias = document.getElementById('denuncias');
                    var PARAMS = {
                        items : inputDenuncias.value,
                        start_date : "{{ $start_date }}",
                        end_date : "{{ $end_date }}",
                        unity_id: {{ $unity_id }},
                        fileoutput : "fmt_resumen_basico_01.xlsx",
                        indice : 4,
                        _token : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    };

                    var temp=document.createElement("form");
                    temp.action='/resumenBasico01Export';
                    temp.method="POST";
                    temp.target="_blank";
                    temp.style.display="none";
                    for(var x in PARAMS) {
                        var opt=document.createElement("textarea");
                        opt.name=x;
                        opt.value=PARAMS[x];
                        temp.appendChild(opt);
                    }
                    document.body.appendChild(temp);
                    temp.submit();
                    return temp;
                });
            }


            let lat = 17.9919;
            let lon = -92.9303;
            window.onload = async () => initMap(dataSetLocations, lat, lon);
            initMap(dataSetLocations, lat, lon);

            items.value = getCommaSeparatedTwoDecimalsNumber(dataSetLocations.length);

        }

        window.onload = loadJSON( "/storage/{{ $file_output }}" );

        document.querySelectorAll('.radio-button input').forEach((input) => {
            input.addEventListener('change', function (event) {
                document.getElementById('formFilter').submit();
            });
        });

    });

    function filterMap(Georeferencias, frmFilterDataExport) {
        const selectZona = document.getElementById('zona');
        const selectServicios = document.getElementById('servicios');
        const selectColonias = document.getElementById('colonias');
        const selectDelegaciones = document.getElementById('delegaciones');
        const inputDenuncias = document.getElementById('denuncias');
        const map = document.getElementById('map');
        const selectedZona = selectZona.value;
        const selectedServicio = selectServicios.value;
        const selectedColonia = selectColonias.value;
        const selectedDelegacion = selectDelegaciones.value;
        const dataSetLocations = [];
        const denuncias_id = [];
        let lat = 17.9919;
        let lon = -92.9303;

        Georeferencias.georeferencias.forEach( (geo) => {
            var dep = geo.dependencia_id;
            var ser = geo.sue_id;
            var col = geo.colonia_delegacion_id;
            var del = geo.delegacion_id;
            if (selectedZona == dep && selectedServicio == 0 && selectedColonia == 0 && selectedDelegacion == 0) {
                console.log("1");
                dataSetLocations.push(setDataLocations(geo, denuncias_id));
            }else if (selectedZona == dep && selectedServicio == 0 && selectedColonia == 0 && selectedDelegacion == del){
                    console.log("2");
                    dataSetLocations.push(setDataLocations(geo, denuncias_id));
            }else if (selectedZona == dep && selectedServicio == 0 && selectedColonia == col && selectedDelegacion == del){
                console.log("3");
                dataSetLocations.push(setDataLocations(geo, denuncias_id));
            }else if (selectedZona == dep && selectedServicio == ser && selectedColonia == 0 && selectedDelegacion == 0){
                console.log("4");
                dataSetLocations.push(setDataLocations(geo, denuncias_id));
            }else if (selectedZona == dep && selectedServicio == ser && selectedColonia == 0 && selectedDelegacion == del){
                console.log("6");
                dataSetLocations.push(setDataLocations(geo, denuncias_id));
            }else if (selectedZona == dep && selectedServicio == ser && selectedColonia == col && selectedDelegacion == del) {
                console.log("7");
                dataSetLocations.push(setDataLocations(geo, denuncias_id));
            }
            lat = geo.latitud;
            lon = geo.longitud;
        });
        inputDenuncias.value = denuncias_id.join(',');

        items.value = getCommaSeparatedTwoDecimalsNumber(dataSetLocations.length);

        console.log(dataSetLocations);

        // window.onload = async () => initMap(dataSetLocations, lat, lon);

        initMap(dataSetLocations, lat, lon);

        if (dataSetLocations.length == 0) {
            frmFilterDataExport.disabled = true;
            btnResumenBasicoExport ? frmResumenBasicoExport.disabled = true : console.log("");

            alert("No hay datos para mostrar");
        }else{
            frmFilterDataExport.disabled = false;
            btnResumenBasicoExport ? frmResumenBasicoExport.disabled = false : console.log("");

        }

    }

    function setDataLocations(geo, denuncias_id) {
        denuncias_id.push(geo.denuncia_id);
        return {
            denuncia_id:geo.denuncia_id,
            fecha_ingreso: geo.fecha_ingreso,
            unidad: geo.abreviatura,
            denuncia: geo.denuncia,
            description: geo.ciudadano,
            servicio: geo.servicio,
            estatus: geo.ultimo_estatus,
            type: geo.type,
            icon: geo.icon,
            dias_vencidos: geo.dias_vencidos,
            position: {
                lat: geo.latitud,
                lng: geo.longitud,
            },
            uuid: geo.uuid,
            colonia_delegacion_id: geo.colonia_delegacion_id,
            colonia_delegacion: geo.colonia_delegacion,
            delegacion_id: geo.delegacion_id,
            delegacion: geo.delegacion,
        };
   }

    function getCommaSeparatedTwoDecimalsNumber(number) {
        const fixedNumber = Number.parseFloat(number).toFixed(0);
        return String(fixedNumber).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    }





    {{--document.addEventListener("DOMContentLoaded",()=>{async function e(e){try{let a=await fetch(e);if(!a.ok)throw Error(`Error al cargar JSON: ${a.statusText}`);let o=await a.json();t(o[0],o[1],o[2],o[3],o[4])}catch(r){console.error(r)}}function t(e,t,a,o,r){let n=[],s=[],d=[],i=[],l=[],u=[],c=[],h=[];document.getElementById("h2Recibidas").innerHTML=e.estatus[0].Total,document.getElementById("h2EnProceso").innerHTML=e.estatus[1].Total,document.getElementById("h2Atendidas").innerHTML=e.estatus[2].Total,document.getElementById("h2Aatendidas").innerHTML=e.estatus[2].a_tiempo,document.getElementById("h2Abtendidas").innerHTML=e.estatus[2].con_rezago,document.getElementById("h2Rechazadas").innerHTML=e.estatus[3].Total,document.getElementById("h2Cerradas").innerHTML=e.estatus[4].Total,document.getElementById("h2Observadas").innerHTML=e.estatus[5].Total,document.getElementById("h2Total").innerHTML=e.estatus[0].Total+e.estatus[1].Total+e.estatus[2].Total+e.estatus[3].Total+e.estatus[4].Total+e.estatus[5].Total,e.estatus[0].Unidades.forEach(e=>{n.push(e.Total)}),e.estatus[1].Unidades.forEach(e=>{s.push(e.Total)}),e.estatus[2].Unidades.forEach(e=>{d.push(e.Total)}),e.estatus[3].Unidades.forEach(e=>{i.push(e.Total)}),e.estatus[4].Unidades.forEach(e=>{l.push(e.Total)}),e.estatus[5].Unidades.forEach(e=>{u.push(e.Total)}),e.estatus[2].Unidades.forEach(e=>{c.push(e.a_tiempo),h.push(e.con_rezago)});var g=0;t.unidades.forEach(e=>{document.getElementById("u"+g).innerHTML=e.Unidad,document.getElementById("u"+g+"p").innerHTML=e.Porcentaje+"%",g++});let p=document.getElementById("chart-area-1");new Chart(p,{type:"bar",data:data1(n),options:opciones1()});let y=document.getElementById("chart-area-2");new Chart(y,{type:"bar",data:data1(s),options:opciones1()});let E=document.getElementById("chart-area-3");new Chart(E,{type:"bar",data:data2([{type:"bar",label:"En tiempo",data:c,backgroundColor:"rgba(54, 162, 235, 0.6)",borderColor:"rgba(54, 162, 235, 1)",borderWidth:1,hoverBackgroundColor:"rgba(54, 162, 235, 0.6)",hoverBorderColor:"rgba(54, 162, 235, 1)"},{type:"bar",label:"Con rezago",data:h,backgroundColor:"rgba(255, 99, 132, 0.2)",borderColor:"rgba(255, 99, 132, 1)",borderWidth:1,hoverBackgroundColor:"rgba(255, 99, 132, 0.4)",hoverBorderColor:"rgba(255, 99, 132, 1)"},]),options:opciones2()});let T=document.getElementById("chart-area-4");new Chart(T,{type:"bar",data:data1(i),options:opciones1()});let b=document.getElementById("chart-area-5");new Chart(b,{type:"bar",data:data1(l),options:opciones1()});let m=document.getElementById("chart-area-6");new Chart(m,{type:"bar",data:data1(u),options:opciones1()});let B=document.getElementById("solicitudesChart");new Chart(B,{type:"bar",data:data3([r.otros[0].atendidas,r.otros[0].rechazadas]),options:opciones3()});let f=document.getElementById("closedRequestsChart");new Chart(f,{type:"doughnut",data:data4([r.otros[0].porcAtendidas,r.otros[0].porcPendientes]),options:opciones4()});let I=[],_=[],v=[];a.servicios.forEach(e=>{_.push(e.Total),v.push(e.Servicio),g++});let C=document.getElementById("servicesChart");new Chart(C,{type:"bar",data:data5(v,_),options:opciones5()}),o.georeferencias.forEach(e=>{I.push({denuncia_id:e.denuncia_id,fecha_ingreso:e.fecha_ingreso,unidad:e.abreviatura,denuncia:e.denuncia,description:e.ciudadano,servicio:e.servicio,estatus:e.ultimo_estatus,type:e.type,icon:e.icon,dias_vencidos:e.dias_vencidos,position:{lat:e.latitud,lng:e.longitud}})}),window.onload=async()=>initMap(I),initMap(I)}window.onload=e("/storage/{{ $file_output }}"),document.querySelectorAll(".radio-button input").forEach(e=>{e.addEventListener("change",function(e){"free"!==e.currentTarget.value&&document.getElementById("formFilter").submit()})})});--}}


</script>

