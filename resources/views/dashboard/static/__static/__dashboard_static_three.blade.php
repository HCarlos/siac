<div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <h1>CENTRO</h1>
            <p>Honestidad y Resultados<br>2024-2027</p>
        </div>
        <nav class="menu">
            <button class="menu-item active">Inicio</button>
            <button class="menu-item">Alumbrado</button>
            <button class="menu-item">Espacios Públicos</button>
            <button class="menu-item">Limpia</button>
            <button class="menu-item">Obras</button>
            <button class="menu-item">SAS</button>
            <button class="menu-item">Encuestas</button>
            <button class="menu-item">Reportes</button>
        </nav>
    </aside>

    <!-- Main Content -->
    <main id="contenedor">
        <!-- Header -->
        <header class="header">
            <button class="filter-btn active">Hoy</button>
            <button class="filter-btn">Mes Actual</button>
            <button class="filter-btn">Año Actual</button>
            <div class="date-picker">
                <label for="start_date">F. Inicial</label>
                <input type="date" id="start_date" name="start_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
            </div>
            <div class="date-picker">
                <label for="end_date">F. Final</label>
                <input type="date" id="end_date" name="end_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
            </div>
            <div class="search-container">
                <button class="search-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="search-icon">
                        <path d="M10 2a8 8 0 105.29 14.29l4.35 4.35a1 1 0 001.42-1.42l-4.35-4.35A8 8 0 0010 2zm0 2a6 6 0 014.66 9.74 1 1 0 00-.14 1.41l4.35 4.35a1 1 0 001.42-1.42l-4.35-4.35a1 1 0 00-1.41.14A6 6 0 1110 4z" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- Stats -->
        <section class="stats">
            <div class="stat">
                <h2 id="h2Recibidas">0</h2>
                <p>Recibidas</p>
            </div>
            <div class="stat">
                <h2 id="h2EnProceso">0</h2>
                <p>En Proceso / Programadas</p>
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
        </section>

        <div class="dashboard-container">
            <!-- Sección de solicitudes por área -->
            <div class="section">
                <div class="card">
                    <h3>Recibidas:</h3>
                    <div class="chart">
                        <canvas id="chart-area-1"></canvas>
                    </div>
                </div>
                <div class="card">
                    <h3>En proceso / programadas:</h3>
                    <div class="chart">
                        <canvas id="chart-area-2">[Gráfico de Barras]</canvas>
                    </div>
                </div>
                <div class="card">
                    <h3>Atendidas:</h3>
                    <div class="chart">
                        <canvas id="chart-area-3">[Gráfico de Barras]</canvas>
                    </div>
                </div>
                <div class="card">
                    <h3>Rechazadas:</h3>
                    <div class="chart">
                        <canvas id="chart-area-4">[Gráfico de Barras]</canvas>
                    </div>
                </div>
                <div class="card">
                    <h3>Cerradas:</h3>
                    <div class="chart">
                        <canvas id="chart-area-5">[Gráfico de Barras]</canvas>
                    </div>
                </div>
                <div class="card">
                    <h3>Observadas:</h3>
                    <div class="chart">
                        <canvas id="chart-area-6">[Gráfico de Barras]</canvas>
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
                <div class="card">
                    <h3>Por zona:</h3>
                    <div class="map-container" id="map-container">
                        <div id="map"></div>
                    </div>
                </div>
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

{{--<b style="color: #f50606"></b>--}}

<script
    src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_KEY')}}&libraries=marker&v=weekly"
    async
    defer
></script>
<script src="js/dashboard_statistics_three_map_setup.js" type="text/javascript"></script>

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
                initLoadData(data[0],data[1],data[2],data[3]);
            } catch (error) {
                console.error(error);
            }
        }


        function initLoadData(Estatus,Unidades,Servicios,Georeferencias) {

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
            document.getElementById("h2Cerradas").innerHTML = Estatus.estatus[4].Total;
            document.getElementById("h2Observadas").innerHTML = Estatus.estatus[5].Total;

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
                data: data3([@php echo 93 @endphp, @php echo 47 @endphp]),
                options: opciones3()
            });

            const ctx8a = document.getElementById('closedRequestsChart');
            const chart8a = new Chart(ctx8a, {
                type: 'doughnut',
                data: data4([@php echo 12.69 @endphp, @php echo 100 - 12.69 @endphp]),
                options: opciones4()
            });

            // Llamar a la función de inicialización cuando la página cargue

            // const dataSetLocations = [
            //     { lat: 17.9889, lng: -92.9283, color: "red" }, // Zona 1
            //     { lat: 17.9919, lng: -92.9303, color: "orange" }, // Zona 2
            //     { lat: 17.9879, lng: -92.9313, color: "green" }, // Zona 3
            // ];
            //

            let dataSetLocations = [];

            // servicio: geo.servicio, fecha_ingreso: geo.fecha_ingreso,dias_a_tiempo: geo.dias_a_tiempo,
            //     ultimo_estatus: geo.ultimo_estatus, fecha_ejecucion_minima: geo.fecha_ejecucion_minima,
            //     fecha_ejecucion_maxima: geo.fecha_ejecucion_maxima

            Georeferencias.georeferencias.forEach( (geo) => {
                dataSetLocations.push({
                    denuncia_id:geo.denuncia_id, lat: geo.latitud, lng: geo.longitud, color: geo.semaforo,
                    denuncia: geo.denuncia, ciudadano: geo.ciudadano, unidad: geo.abreviatura
                });
            });

            // console.log(dataSetLocations);

            window.onload = async () => initMap(dataSetLocations);

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

        }

        // Llama a la función para cargar el JSON al iniciar
        {{--let urlFile = "{{ Storage::disk('public')->url($file_output) }}";--}}

        {{--alert("/storage/{{ $file_output }}" );--}}
        loadJSON( "/storage/{{ $file_output }}" );


    });

</script>

