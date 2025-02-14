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
            @foreach($menu as $m)
                <button class="{{ $m->clase }}" onclick="window.location.href='{{ $m->url }}'">{{ $m->title_menu }}</button>
            @endforeach
        </nav>
    </aside>

    <!-- Main Content -->
    <main id="contenedor">
        <!-- Header -->
        <div class="title-wrapper">
            <h2 class="main-title--">Explora las Estadísticas de los Servicios Municipales Monitoreados</h2>
            <p class="subtitle">Selecciona un filtro de tiempo para ver los datos detallados</p>
        </div>
        <form action="{{ url('/dashboard-statistics-servicios-principales') }}" method="POST" id="formFilter">
            @csrf
            <header class="header">
                    <div class="radio-group">
                        <label class="radio-button">
                            <input type="radio" name="filter" value="hoy" @if(  $filter === 'hoy') checked @endif >
                            <span>Hoy</span>
                        </label>
                        <label class="radio-button">
                            <input type="radio" name="filter" value="mes"@if(  $filter === 'mes') checked @endif >
                            <span>Mes Actual</span>
                        </label>
                        <label class="radio-button">
                            <input type="radio" name="filter" value="anio"@if( $filter === 'anio') checked @endif >
                            <span>Año Actual</span>
                        </label>

                        <label class="radio-button">
                            <input type="radio" name="filter" value="free" @if( $filter === 'free') checked @endif>
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
{{--                    <button class="search-btn" type="submit" >--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="search-icon">--}}
{{--                            <path d="M10 2a8 8 0 105.29 14.29l4.35 4.35a1 1 0 001.42-1.42l-4.35-4.35A8 8 0 0010 2zm0 2a6 6 0 014.66 9.74 1 1 0 00-.14 1.41l4.35 4.35a1 1 0 001.42-1.42l-4.35-4.35a1 1 0 00-1.41.14A6 6 0 1110 4z" />--}}
{{--                        </svg>--}}
{{--                    </button>--}}
                </div>

            </header>
        </form>

        <div class="dashboard-container">
            <!-- Sección de solicitudes por área -->
            <div class="section">
                <div class="card">
                    <div class="stat-2">
                        <h1 class="count" id="h2Recibidas">0</h1>
                        <p>Recibidas</p>
                    </div>
                    <div class="chart">
                        <canvas id="chart-area-1"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="stat-2">
                        <h1 class="count yellow" id="h2EnProceso">0</h1>
                        <p>En Proceso / Programadas</p>
                    </div>
                    <div class="chart">
                        <canvas id="chart-area-2">[Gráfico de Barras]</canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-stat-2">
                        <div class="card-left">
                            <h1 class="count green" id="h2Atendidas">0</h1>
                            <p>Atendidas</p>
                        </div>
                        <div class="card-right">
                            <p><strong id="h2Aatendidas">0</strong> A TIEMPO</p>
                            <p><strong id="h2Abtendidas">0</strong> CON REZAGO</p>
                        </div>
                    </div>
                    <div class="chart">
                        <canvas id="chart-area-3">[Gráfico de Barras]</canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="stat-2">
                        <h1  class="count red" id="h2Rechazadas">0</h1>
                        <p>Rechazadas</p>
                    </div>
                    <div class="chart">
                        <canvas id="chart-area-4">[Gráfico de Barras]</canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="stat-2">
                        <h1 class="count" id="h2Total">0</h1>
                        <p>Todas</p>
                    </div>
                    <div class="chart">
                        <canvas id="chart-area-7">[Gráfico de Barras]</canvas>
                    </div>
                </div>
            </div>
            <!-- Charts Section -->
            <div class="section">
                <div class="card">
                    <h3>Top de solicitudes</h3>
                    <div class="top-requests">
                        <div><span id="u0"></span><span id="u0p"></span></div>
                        <div><span id="u1"></span><span id="u1p"></span></div>
                        <div><span id="u2"></span><span id="u2p"></span></div>
                        <div><span id="u3"></span><span id="u3p"></span></div>
                        <div><span id="u4"></span><span id="u4p"></span></div>
                    </div>
                </div>
                <div class="card">
                    <div class="chart-container">
                        <h3>Servicios Municipales Monitoreados</h3>
                        <canvas id="servicesChart"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="chart-container">
                        <h3>% solicitudes cerradas</h3>
                        <canvas id="closedRequestsChart" class="canvas_uno"></canvas>
                    </div>

                </div>
                {{--                <div class="card">--}}
                {{--                    <h3>Por zona:</h3>--}}
                {{--                    <div class="map-container" id="map-container">--}}
                {{--                        <div id="map"></div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="card">
                    <div class="chart-container">
                        <h3>% solicitudes atendidas / rechazadas</h3>
                        <canvas id="solicitudesChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Zona del Mapa -->
            <div class="section">
                <div class="card shadow-sm" >

                    <div class="card-header">
                        <form class="form-modern">
                            <div class="form-group">
                                <label for="zona control-select">Unidades:</label>
                                <select class="control-select " name="zona" id="zona">
                                    <option value="0">Todas</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="servicios">Servicios:</label>
                                <select class="form-select" name="servicios" id="servicios">
                                    <option value="0">Todos</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="items">Items:</label>
                                <input type="text" name="items" id="items" value="0" class="totalItems" disabled>
                            </div>
                            <button type="button" id="frmFilter" class="btn btn-primary btn-submit ms-auto">Filtrar</button>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="map-container" id="map-container">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>


<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
({key: "{{env('GOOGLE_MAPS_KEY')}}", v: "weekly"});</script>

<script src="/js/dashboard/dashboard_statistics_map_setup.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>




    document.addEventListener('DOMContentLoaded', () => {

        async function loadJSON(file_output) {
            try {
                const response = await fetch(file_output);
                if (!response.ok) {
                    throw new Error(`Error al cargar JSON: ${response.statusText}`);
                }
                const data = await response.json();
                initLoadData(data[0],data[1],data[2],data[3],data[4],data[5],data[6]);
            } catch (error) {
                console.error(error);
            }
        }


        function initLoadData(Estatus,Unidades,Servicios,Georeferencias,Otros,FiltroUnidades,FiltroServicios) {
            let data1data = [];
            let data2data = [];
            let data3data = [];
            let data4data = [];
            let data5data = [];
            let data6data = [];

            let dataatiempo = [];
            let datarezago = [];


            document.getElementById("h2Recibidas").innerHTML  = getCommaSeparatedTwoDecimalsNumber(Estatus.estatus[0].Total);
            document.getElementById("h2EnProceso").innerHTML  = getCommaSeparatedTwoDecimalsNumber(Estatus.estatus[1].Total);

            document.getElementById("h2Atendidas").innerHTML  = getCommaSeparatedTwoDecimalsNumber(Estatus.estatus[2].Total);
            document.getElementById("h2Aatendidas").innerHTML = getCommaSeparatedTwoDecimalsNumber(Estatus.estatus[2].a_tiempo);
            document.getElementById("h2Abtendidas").innerHTML = getCommaSeparatedTwoDecimalsNumber(Estatus.estatus[2].con_rezago);

            document.getElementById("h2Rechazadas").innerHTML = getCommaSeparatedTwoDecimalsNumber(Estatus.estatus[3].Total);

            document.getElementById("h2Total").innerHTML = getCommaSeparatedTwoDecimalsNumber(Estatus.estatus[0].Total + Estatus.estatus[1].Total + Estatus.estatus[2].Total + Estatus.estatus[3].Total + Estatus.estatus[4].Total + Estatus.estatus[5].Total);

            var arr = [0, 0, 0, 0, 0, 0];
            Estatus.estatus[0].Unidades.forEach( (unidad, i=0) => {data1data.push(unidad.Total); arr[i] += unidad.Total; });
            Estatus.estatus[1].Unidades.forEach( (unidad, i=0) => {data2data.push(unidad.Total); arr[i] += unidad.Total; });
            Estatus.estatus[2].Unidades.forEach( (unidad, i=0) => {data3data.push(unidad.Total); arr[i] += unidad.Total; });
            Estatus.estatus[3].Unidades.forEach( (unidad, i=0) => {data4data.push(unidad.Total); arr[i] += unidad.Total; });
            Estatus.estatus[4].Unidades.forEach( (unidad, i=0) => {data5data.push(unidad.Total); arr[i] += unidad.Total; });
            Estatus.estatus[5].Unidades.forEach( (unidad, i=0) => {data6data.push(unidad.Total); arr[i] += unidad.Total; });

            console.log(arr);

            Estatus.estatus[2].Unidades.forEach( (unidad) => {
                dataatiempo.push(unidad.a_tiempo);
                datarezago.push(unidad.con_rezago);
            });

            var i = 0;
            Unidades.unidades.forEach( (unidad) => {
                document.getElementById("u" + i).innerHTML = unidad.Unidad;
                document.getElementById("u" + i + "p").innerHTML = unidad.Porcentaje+"%";
                i++;
            });

            // alert(data.unidades);

            const ctx1a = document.getElementById('chart-area-1');
            const chart1a = new Chart(ctx1a, {
                type: 'bar',
                data: data1(data1data),
                options: opciones1()
            });

            // En Proceso
            const ctx2a = document.getElementById('chart-area-2');
            const chart2a = new Chart(ctx2a, {
                type: 'bar',
                data: data1(data2data),
                options: opciones1()
            });

            var ds_atendidas = [
                {label: 'En tiempo', data: dataatiempo, backgroundColor: 'rgba(54, 162, 235, 0.6)', borderColor: 'rgba(54, 162, 235, 1)', borderWidth: 1, hoverBackgroundColor: 'rgba(54, 162, 235, 0.6)', hoverBorderColor: 'rgba(54, 162, 235, 1)', fill: false, borderwidth: 1},
                {label: 'Con rezago', data: datarezago, backgroundColor: 'rgba(255, 99, 132, 0.2)', borderColor: 'rgba(255, 99, 132, 1)', borderWidth: 1, hoverBackgroundColor: 'rgba(255, 99, 132, 0.4)', hoverBorderColor: 'rgba(255, 99, 132, 1)', fill: false, borderwidth: 1},
            ];


            // Atendidas
            const ctx3a = document.getElementById('chart-area-3');
            const chart3a = new Chart(ctx3a, {
                type: 'bar',
                data: data2(ds_atendidas),
                options: opciones2()
            });

            // Rechazadas
            const ctx4a = document.getElementById('chart-area-4');
            const chart4a = new Chart(ctx4a, {
                type: 'bar',
                data: data1(data4data),
                options: opciones1()
            });

            // Observadas
            const ctx6b = document.getElementById('chart-area-7');
            const chart6b = new Chart(ctx6b, {
                type: 'bar',
                data: data1(arr),
                options: opciones1()
            });

            // % Atendidas vs Rechazadas
            const ctx7a = document.getElementById('solicitudesChart');
            const chart7a = new Chart(ctx7a, {
                type: 'pie',
                data: data3([Otros.otros[0].atendidas, Otros.otros[0].rechazadas]),
                options: opciones3pie(),
                plugins: [ChartDataLabels] // Registramos el plugin
            });

            const ctx8a = document.getElementById('closedRequestsChart');
            const chart8a = new Chart(ctx8a, {
                type: 'doughnut',
                data: data4([Otros.otros[0].porcAtendidas, Otros.otros[0].porcPendientes]),
                options: opciones4()
            });

            // Llamar a la función de inicialización cuando la página cargue

            let dataSetLocations = [];

            let Services = [];
            let LabelServices = [];
            Servicios.servicios.forEach( (servicio) => {
                Services.push(servicio.Total);
                LabelServices.push(servicio.Servicio);
                i++;
            });

            const ctx9a = document.getElementById('servicesChart');
            const chart9a = new Chart(ctx9a, {
                type: 'bar',
                data: data5(LabelServices,Services),
                options: opciones5()
            });

            Georeferencias.georeferencias.forEach( (geo) => {

                dataSetLocations.push({
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
                    }
                });

            });

            const selectZona = document.getElementById('zona');
            const selectServicios = document.getElementById('servicios');
            const items = document.getElementById('items');

            FiltroUnidades.filtro_unidades.forEach(zona => {
                const opcion = document.createElement('option');
                opcion.value = zona.dependencia_id;
                opcion.text = zona.dependencia;
                selectZona.add(opcion);
            });

            selectZona.addEventListener('change', () => {
                const selectedValue = selectZona.value;
                selectServicios.innerHTML = '<option value="0">Todos</option>';
                FiltroServicios.filtro_servicios.forEach(item => {
                    if (selectedValue == item.dependencia_id) {
                        const opcion = document.createElement('option');
                        opcion.value = item.sue_id;
                        opcion.text = item.servicio;
                        selectServicios.add(opcion);
                    }
                });
            });
            selectServicios.innerHTML = '<option value="0">Todos</option>';

            document.getElementById('frmFilter').addEventListener('click', (event) => {
                event.preventDefault();
                filterMap(Georeferencias);

            })
            window.onload = async () => initMap(dataSetLocations);
            initMap(dataSetLocations);

            items.value = getCommaSeparatedTwoDecimalsNumber(dataSetLocations.length);

        }



        window.onload = loadJSON( "/storage/{{ $file_output }}" );

        document.querySelectorAll('.radio-button input').forEach((input) => {
            input.addEventListener('change', function (event) {
                document.getElementById('formFilter').submit();
            });
        });



    });


    function filterMap(Georeferencias) {
        const selectZona = document.getElementById('zona');
        const selectServicios = document.getElementById('servicios');
        const selectedZona = selectZona.value;
        const selectedServicio = selectServicios.value;
        const dataSetLocations = [];
        Georeferencias.georeferencias.forEach( (geo) => {
            var dep = geo.dependencia_id;
            var ser = geo.sue_id;

            if (selectedZona == 0 && selectedServicio == 0) {
                dataSetLocations.push(setDataLocations(geo));
            }else{
                if (selectedZona > 0 ) {
                    if (dep == selectedZona && selectedServicio == 0) {
                        dataSetLocations.push(setDataLocations(geo));
                    }else{
                        if (dep == selectedZona && ser == selectedServicio) {
                            dataSetLocations.push(setDataLocations(geo));
                        }
                    }
                }
            }

        });
        items.value = getCommaSeparatedTwoDecimalsNumber(dataSetLocations.length);
        window.onload = async () => initMap(dataSetLocations);
        initMap(dataSetLocations);

    }

    function setDataLocations(geo) {
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
            }
        };
    }

    function getCommaSeparatedTwoDecimalsNumber(number) {
        const fixedNumber = Number.parseFloat(number).toFixed(0);
        return String(fixedNumber).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    }


{{--document.addEventListener("DOMContentLoaded",()=>{async function e(e){try{let a=await fetch(e);if(!a.ok)throw Error(`Error al cargar JSON: ${a.statusText}`);let o=await a.json();t(o[0],o[1],o[2],o[3],o[4])}catch(r){console.error(r)}}function t(e,t,a,o,r){let n=[],s=[],d=[],i=[],l=[],u=[],c=[],h=[];document.getElementById("h2Recibidas").innerHTML=e.estatus[0].Total,document.getElementById("h2EnProceso").innerHTML=e.estatus[1].Total,document.getElementById("h2Atendidas").innerHTML=e.estatus[2].Total,document.getElementById("h2Aatendidas").innerHTML=e.estatus[2].a_tiempo,document.getElementById("h2Abtendidas").innerHTML=e.estatus[2].con_rezago,document.getElementById("h2Rechazadas").innerHTML=e.estatus[3].Total,document.getElementById("h2Total").innerHTML=e.estatus[0].Total+e.estatus[1].Total+e.estatus[2].Total+e.estatus[3].Total+e.estatus[4].Total+e.estatus[5].Total;var g=[0,0,0,0,0,0];e.estatus[0].Unidades.forEach((e,t=0)=>{n.push(e.Total),g[t]+=e.Total}),e.estatus[1].Unidades.forEach((e,t=0)=>{s.push(e.Total),g[t]+=e.Total}),e.estatus[2].Unidades.forEach((e,t=0)=>{d.push(e.Total),g[t]+=e.Total}),e.estatus[3].Unidades.forEach((e,t=0)=>{i.push(e.Total),g[t]+=e.Total}),e.estatus[4].Unidades.forEach((e,t=0)=>{l.push(e.Total),g[t]+=e.Total}),e.estatus[5].Unidades.forEach((e,t=0)=>{u.push(e.Total),g[t]+=e.Total}),console.log(g),e.estatus[2].Unidades.forEach(e=>{c.push(e.a_tiempo),h.push(e.con_rezago)});var p=0;t.unidades.forEach(e=>{document.getElementById("u"+p).innerHTML=e.Unidad,document.getElementById("u"+p+"p").innerHTML=e.Porcentaje+"%",p++});let T=document.getElementById("chart-area-1");new Chart(T,{type:"bar",data:data1(n),options:opciones1()});let y=document.getElementById("chart-area-2");new Chart(y,{type:"bar",data:data1(s),options:opciones1()});let E=document.getElementById("chart-area-3");new Chart(E,{type:"bar",data:data2([{type:"bar",label:"En tiempo",data:c,backgroundColor:"rgba(54, 162, 235, 0.6)",borderColor:"rgba(54, 162, 235, 1)",borderWidth:1,hoverBackgroundColor:"rgba(54, 162, 235, 0.6)",hoverBorderColor:"rgba(54, 162, 235, 1)"},{type:"bar",label:"Con rezago",data:h,backgroundColor:"rgba(255, 99, 132, 0.2)",borderColor:"rgba(255, 99, 132, 1)",borderWidth:1,hoverBackgroundColor:"rgba(255, 99, 132, 0.4)",hoverBorderColor:"rgba(255, 99, 132, 1)"},]),options:opciones2()});let b=document.getElementById("chart-area-4");new Chart(b,{type:"bar",data:data1(i),options:opciones1()});let $=document.getElementById("chart-area-7");new Chart($,{type:"bar",data:data1(g),options:opciones1()});let m=document.getElementById("solicitudesChart");new Chart(m,{type:"pie",data:data3([r.otros[0].atendidas,r.otros[0].rechazadas]),options:opciones3pie(),plugins:[ChartDataLabels]});let B=document.getElementById("closedRequestsChart");new Chart(B,{type:"doughnut",data:data4([r.otros[0].porcAtendidas,r.otros[0].porcPendientes]),options:opciones4()});let f=[],_=[],I=[];a.servicios.forEach(e=>{_.push(e.Total),I.push(e.Servicio),p++});let v=document.getElementById("servicesChart");new Chart(v,{type:"bar",data:data5(I,_),options:opciones5()}),o.georeferencias.forEach(e=>{f.push({denuncia_id:e.denuncia_id,fecha_ingreso:e.fecha_ingreso,unidad:e.abreviatura,denuncia:e.denuncia,description:e.ciudadano,servicio:e.servicio,estatus:e.ultimo_estatus,type:e.type,icon:e.icon,dias_vencidos:e.dias_vencidos,position:{lat:e.latitud,lng:e.longitud}})}),window.onload=async()=>initMap(f),initMap(f)}window.onload=e("/storage/{{ $file_output }}"),document.querySelectorAll(".radio-button input").forEach(e=>{e.addEventListener("change",function(e){"free"!==e.currentTarget.value&&document.getElementById("formFilter").submit()})})});--}}

</script>

