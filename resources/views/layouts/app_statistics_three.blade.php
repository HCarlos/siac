<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard_statistics_three.css">
    <script src="js/dashboard_statistics_three_setup.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
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
                <h2>1538</h2>
                <p>Recibidas</p>
            </div>
            <div class="stat">
                <h2>546</h2>
                <p>En Proceso / Programadas</p>
            </div>
            <div class="card-stat">
                <div class="card-left">
                    <h1 class="count green">435</h1>
                    <p>Atendidas</p>
                </div>
                <div class="card-right">
                    <p><strong>281</strong> EN TIEMPO</p>
                    <p><strong>154</strong> CON REZAGO</p>
                </div>
            </div>
            <div class="stat">
                <h2 style="color: red;">239</h2>
                <p>Rechazadas</p>
            </div>
            <div class="stat">
                <h2>195</h2>
                <p>Cerradas</p>
            </div>
            <div class="stat">
                <h2>123</h2>
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
                    <div><span>1 SAS</span><span>74%</span></div>
                    <div><span>2 Obras</span><span>54%</span></div>
                    <div><span>3 Alumbrado</span><span>21%</span></div>
                    <div><span>4 Limpia</span><span>8%</span></div>
                    <div><span>5 Espacios públicos</span><span>2%</span></div>
                </div>
            </div>
            <div class="card">
                <div class="chart-container">
                    <h3>% solicitudes atendidas / rechazadas</h3>
                    <canvas id="solicitudesChart"></canvas>
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
{{--                <div class="toggle-button" id="toggle-map">Expandir</div>--}}
                <div id="map"></div>
                </div>
            </div>
        </div>

        </div>

    </main>
</div>

<script
    src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_KEY')}}&libraries=marker&v=weekly"
    async
    defer
></script>

<script src="js/dashboard_statistics_three_map_setup.js" type="text/javascript"></script>




<script>

    document.addEventListener('DOMContentLoaded', () => {

        // Recibidas
        const ctx1a = document.getElementById('chart-area-1');
        const chart1a = new Chart(ctx1a, {
            type: 'bar',
            data: data1([@php echo 25 @endphp, 5, 9, 37, 40]),
            options: opciones1()
        });

        // En Proceso
        const ctx2a = document.getElementById('chart-area-2');
        const chart2a = new Chart(ctx2a, {
            type: 'bar',
            data: data1([@php echo 25 @endphp, 5, 9, 37, 40]),
            options: opciones1()
        });

        var ds_atendidas = [
            {type: 'bar',label: 'En tiempo', data: [5,45,25,75,45], backgroundColor: 'rgba(54, 162, 235, 0.6)', borderColor: 'rgba(54, 162, 235, 1)', borderWidth: 1, hoverBackgroundColor: 'rgba(54, 162, 235, 0.6)', hoverBorderColor: 'rgba(54, 162, 235, 1)' },
            {type: 'bar',label: 'Con rezago', data: [95,55,75,25,55], backgroundColor: 'rgba(255, 99, 132, 0.2)', borderColor: 'rgba(255, 99, 132, 1)', borderWidth: 1, hoverBackgroundColor: 'rgba(255, 99, 132, 0.4)', hoverBorderColor: 'rgba(255, 99, 132, 1)'},
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
            data: data1([@php echo 25 @endphp, 5, 9, 37, 40]),
            options: opciones1()
        });

        // Cerradas
        const ctx5a = document.getElementById('chart-area-5');
        const chart5a = new Chart(ctx5a, {
            type: 'bar',
            data: data1([@php echo 25 @endphp, 5, 9, 37, 40]),
            options: opciones1()
        });

        // Observadas
        const ctx6a = document.getElementById('chart-area-6');
        const chart6a = new Chart(ctx6a, {
            type: 'bar',
            data: data1([@php echo 25 @endphp, 5, 9, 37, 40]),
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
        const dataSetLocations = [
            { lat: 17.9889, lng: -92.9283, color: "red" }, // Zona 1
            { lat: 17.9919, lng: -92.9303, color: "orange" }, // Zona 2
            { lat: 17.9879, lng: -92.9313, color: "green" }, // Zona 3
        ];

        window.onload = async () => initMap(dataSetLocations);



    });



</script>




</body>
</html>
