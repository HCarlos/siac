<div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
{{--            <h1><a href="/home">CENTRO</a></h1>--}}
{{--            <p>Honestidad y Resultados<br>2024-2027</p>--}}
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
            <h2 class="main-title">Explora las Estadísticas Generales</h2>
            <p class="subtitle">Selecciona un filtro de tiempo para ver los datos detallados</p>
        </div>
        <form action="{{ url('/dashboard-statistics-general') }}" method="POST" id="formFilter">
            @csrf
            <header class="header">
                    <div class="radio-group">
                        <label class="radio-button">
                            <input type="radio" name="filter" value="hoy" @if(  $filter === 'hoy') checked @endif >
                            <span>Hoy</span>
                        </label>
                        <label class="radio-button">
                            <input type="radio" name="filter" value="mes" @if(  $filter === 'mes') checked @endif >
                            <span>Mes Actual</span>
                        </label>
                        <label class="radio-button">
                            <input type="radio" name="filter" value="anio" @if( $filter === 'anio') checked @endif >
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
                        <button class="search-btn" type="submit" >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="search-icon">
                                <path d="M10 2a8 8 0 105.29 14.29l4.35 4.35a1 1 0 001.42-1.42l-4.35-4.35A8 8 0 0010 2zm0 2a6 6 0 014.66 9.74 1 1 0 00-.14 1.41l4.35 4.35a1 1 0 001.42-1.42l-4.35-4.35a1 1 0 00-1.41.14A6 6 0 1110 4z" />
                            </svg>
                        </button>
                    </div>
            </header>
        </form>

        <!-- Stats -->
        <section class="stats">
            <div class="stat">
                <h2 id="h2Recibidas">0</h2>
                <p>Recibidas</p>
            </div>
            <div class="stat">
                <h2 id="h2EnProceso">0</h2>
                <p>En Proceso</p>
            </div>
            <div class="card-stat">
                <div class="card-left">
                    <h1 class="count green" id="h2Atendidas">0</h1>
                    <p>Atendidas</p>
                </div>
                <div class="card-right">
                    <p><strong id="h2Aatendidas">0</strong> A TIEMPO</p>
                    <p><strong id="h2Abtendidas">0</strong> CON REZAGO</p>
                </div>
            </div>
            <div class="stat">
                <h2 style="color: red;" id="h2Rechazadas">0</h2>
                <p>Rechazadas</p>
            </div>
            <div class="stat">
                <h2 id="h2Cerradas">0</h2>
                <p>Cerradas</p>
            </div>
            <div class="stat">
                <h2 id="h2Observadas">0</h2>
                <p>Observadas</p>
            </div>
            <div class="stat">
                <h2 id="h2Total">0</h2>
                <p>Todas</p>
            </div>
        </section>

        <div class="dashboard-container">
            <!-- Sección de solicitudes por área -->
            <div class="section">
                <div class="card">
                    <h3>Recibidas</h3>
                    <div class="chart">
                        <canvas id="chart-area-1"></canvas>
                    </div>
                </div>
                <div class="card">
                    <h3>En proceso</h3>
                    <div class="chart">
                        <canvas id="chart-area-2">[Gráfico de Barras]</canvas>
                    </div>
                </div>
                <div class="card">
                    <h3>Atendidas</h3>
                    <div class="chart">
                        <canvas id="chart-area-3">[Gráfico de Barras]</canvas>
                    </div>
                </div>
                <div class="card">
                    <h3>Rechazadas</h3>
                    <div class="chart">
                        <canvas id="chart-area-4">[Gráfico de Barras]</canvas>
                    </div>
                </div>
                <div class="card">
                    <h3>Cerradas</h3>
                    <div class="chart">
                        <canvas id="chart-area-5">[Gráfico de Barras]</canvas>
                    </div>
                </div>
                <div class="card">
                    <h3>Observadas</h3>
                    <div class="chart">
                        <canvas id="chart-area-6">[Gráfico de Barras]</canvas>
                    </div>
                </div>
            </div>
            <div class="section">
                <div class="card" >
                    <h3>Por zona</h3>
                    <div class="map-container" id="map-container">
                        <div id="map"></div>
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

        </div>
    </main>
</div>

<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
({key: "{{env('GOOGLE_MAPS_KEY')}}", v: "weekly"});</script>

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
                initLoadData(data[0],data[1],data[2],data[3],data[4]);
            } catch (error) {
                console.error(error);
            }
        }


        function initLoadData(Estatus,Unidades,Servicios,Georeferencias,Otros) {

            // alert(data.estatus[0].Unidades[0].Total);

            // Recibidas
            // data.unidades.forEach((estatus) => {
            //     console.log(`Estatus: ${estatus.Estatus}`);
            //     console.log("Unidades:");
            //     estatus.Unidades.forEach((unidad) => {
            //         console.log(`- ${unidad.Unidad}: Total = ${unidad.Total}, Porcentaje = ${unidad.Porcentaje}%`);
            //     });
            // });
            let data1data = [];
            let data2data = [];
            let data3data = [];
            let data4data = [];
            let data5data = [];
            let data6data = [];

            let dataatiempo = [];
            let datarezago = [];

            document.getElementById("h2Recibidas").innerHTML = Estatus.estatus[0].Total;
            document.getElementById("h2EnProceso").innerHTML = Estatus.estatus[1].Total;

            document.getElementById("h2Atendidas").innerHTML = Estatus.estatus[2].Total;
            document.getElementById("h2Aatendidas").innerHTML = Estatus.estatus[2].a_tiempo;
            document.getElementById("h2Abtendidas").innerHTML = Estatus.estatus[2].con_rezago;

            document.getElementById("h2Rechazadas").innerHTML = Estatus.estatus[3].Total;
            document.getElementById("h2Cerradas").innerHTML = Estatus.estatus[5].Total;
            document.getElementById("h2Observadas").innerHTML = Estatus.estatus[4].Total;

            document.getElementById("h2Total").innerHTML = Estatus.estatus[0].Total + Estatus.estatus[1].Total + Estatus.estatus[2].Total + Estatus.estatus[3].Total + Estatus.estatus[4].Total + Estatus.estatus[5].Total;

            Estatus.estatus[0].Unidades.forEach( (unidad) => {data1data.push(unidad.Total); });
            Estatus.estatus[1].Unidades.forEach( (unidad) => {data2data.push(unidad.Total); });
            Estatus.estatus[2].Unidades.forEach( (unidad) => {data3data.push(unidad.Total); });
            Estatus.estatus[3].Unidades.forEach( (unidad) => {data4data.push(unidad.Total); });
            Estatus.estatus[4].Unidades.forEach( (unidad) => {data5data.push(unidad.Total); });
            Estatus.estatus[5].Unidades.forEach( (unidad) => {data6data.push(unidad.Total); });

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
                {type: 'bar',label: 'En tiempo', data: dataatiempo, backgroundColor: 'rgba(54, 162, 235, 0.6)', borderColor: 'rgba(54, 162, 235, 1)', borderWidth: 1, hoverBackgroundColor: 'rgba(54, 162, 235, 0.6)', hoverBorderColor: 'rgba(54, 162, 235, 1)' },
                {type: 'bar',label: 'Con rezago', data: datarezago, backgroundColor: 'rgba(255, 99, 132, 0.2)', borderColor: 'rgba(255, 99, 132, 1)', borderWidth: 1, hoverBackgroundColor: 'rgba(255, 99, 132, 0.4)', hoverBorderColor: 'rgba(255, 99, 132, 1)'},
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

            // Cerradas
            const ctx5a = document.getElementById('chart-area-5');
            const chart5a = new Chart(ctx5a, {
                type: 'bar',
                data: data1(data5data),
                options: opciones1()
            });

            // Observadas
            const ctx6a = document.getElementById('chart-area-6');
            const chart6a = new Chart(ctx6a, {
                type: 'bar',
                data: data1(data6data),
                options: opciones1()
            });

            // % Atendidas vs Rechazadas
            const ctx7a = document.getElementById('solicitudesChart');
            const chart7a = new Chart(ctx7a, {
                type: 'bar',
                data: data3([Otros.otros[0].atendidas, Otros.otros[0].rechazadas]),
                options: opciones3()
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
                    },
                    uuid: geo.uuid,
                    colonia_delegacion: geo.colonia_delegacion,
                    colonia_delegacion_id: geo.colonia_delegacion_id
                });

            });

            // console.log(dataSetLocations);

            window.onload = async () => initMap(dataSetLocations);
            initMap(dataSetLocations);


        }

        window.onload = loadJSON( "/storage/{{ $file_output }}" );


        document.querySelectorAll('.radio-button input').forEach((input) => {
            input.addEventListener('change', function (event) {
                // Envía el formulario cuando se selecciona una opción
                if (event.currentTarget.value !== 'free') {
                    document.getElementById('formFilter').submit();
                }
            });
        });



    });


    {{--document.addEventListener("DOMContentLoaded",()=>{async function e(e){try{let a=await fetch(e);if(!a.ok)throw Error(`Error al cargar JSON: ${a.statusText}`);let o=await a.json();t(o[0],o[1],o[2],o[3],o[4])}catch(r){console.error(r)}}function t(e,t,a,o,r){let n=[],s=[],d=[],i=[],l=[],u=[],c=[],h=[];document.getElementById("h2Recibidas").innerHTML=e.estatus[0].Total,document.getElementById("h2EnProceso").innerHTML=e.estatus[1].Total,document.getElementById("h2Atendidas").innerHTML=e.estatus[2].Total,document.getElementById("h2Aatendidas").innerHTML=e.estatus[2].a_tiempo,document.getElementById("h2Abtendidas").innerHTML=e.estatus[2].con_rezago,document.getElementById("h2Rechazadas").innerHTML=e.estatus[3].Total,document.getElementById("h2Cerradas").innerHTML=e.estatus[4].Total,document.getElementById("h2Observadas").innerHTML=e.estatus[5].Total,document.getElementById("h2Total").innerHTML=e.estatus[0].Total+e.estatus[1].Total+e.estatus[2].Total+e.estatus[3].Total+e.estatus[4].Total+e.estatus[5].Total,e.estatus[0].Unidades.forEach(e=>{n.push(e.Total)}),e.estatus[1].Unidades.forEach(e=>{s.push(e.Total)}),e.estatus[2].Unidades.forEach(e=>{d.push(e.Total)}),e.estatus[3].Unidades.forEach(e=>{i.push(e.Total)}),e.estatus[4].Unidades.forEach(e=>{l.push(e.Total)}),e.estatus[5].Unidades.forEach(e=>{u.push(e.Total)}),e.estatus[2].Unidades.forEach(e=>{c.push(e.a_tiempo),h.push(e.con_rezago)});var g=0;t.unidades.forEach(e=>{document.getElementById("u"+g).innerHTML=e.Unidad,document.getElementById("u"+g+"p").innerHTML=e.Porcentaje+"%",g++});let p=document.getElementById("chart-area-1");new Chart(p,{type:"bar",data:data1(n),options:opciones1()});let y=document.getElementById("chart-area-2");new Chart(y,{type:"bar",data:data1(s),options:opciones1()});let E=document.getElementById("chart-area-3");new Chart(E,{type:"bar",data:data2([{type:"bar",label:"En tiempo",data:c,backgroundColor:"rgba(54, 162, 235, 0.6)",borderColor:"rgba(54, 162, 235, 1)",borderWidth:1,hoverBackgroundColor:"rgba(54, 162, 235, 0.6)",hoverBorderColor:"rgba(54, 162, 235, 1)"},{type:"bar",label:"Con rezago",data:h,backgroundColor:"rgba(255, 99, 132, 0.2)",borderColor:"rgba(255, 99, 132, 1)",borderWidth:1,hoverBackgroundColor:"rgba(255, 99, 132, 0.4)",hoverBorderColor:"rgba(255, 99, 132, 1)"},]),options:opciones2()});let T=document.getElementById("chart-area-4");new Chart(T,{type:"bar",data:data1(i),options:opciones1()});let b=document.getElementById("chart-area-5");new Chart(b,{type:"bar",data:data1(l),options:opciones1()});let m=document.getElementById("chart-area-6");new Chart(m,{type:"bar",data:data1(u),options:opciones1()});let B=document.getElementById("solicitudesChart");new Chart(B,{type:"bar",data:data3([r.otros[0].atendidas,r.otros[0].rechazadas]),options:opciones3()});let f=document.getElementById("closedRequestsChart");new Chart(f,{type:"doughnut",data:data4([r.otros[0].porcAtendidas,r.otros[0].porcPendientes]),options:opciones4()});let I=[],_=[],v=[];a.servicios.forEach(e=>{_.push(e.Total),v.push(e.Servicio),g++});let C=document.getElementById("servicesChart");new Chart(C,{type:"bar",data:data5(v,_),options:opciones5()}),o.georeferencias.forEach(e=>{I.push({denuncia_id:e.denuncia_id,fecha_ingreso:e.fecha_ingreso,unidad:e.abreviatura,denuncia:e.denuncia,description:e.ciudadano,servicio:e.servicio,estatus:e.ultimo_estatus,type:e.type,icon:e.icon,dias_vencidos:e.dias_vencidos,position:{lat:e.latitud,lng:e.longitud}})}),window.onload=async()=>initMap(I),initMap(I)}window.onload=e("/storage/{{ $file_output }}"),document.querySelectorAll(".radio-button input").forEach(e=>{e.addEventListener("change",function(e){"free"!==e.currentTarget.value&&document.getElementById("formFilter").submit()})})});--}}


</script>

