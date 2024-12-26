<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard_statistics_three.css">
    <script src="js/dashboard_statistics_three.js" crossorigin="anonymous"></script>
{{--    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>--}}
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
    <main>
        <!-- Header -->
        <header class="header">
            <button class="filter-btn">Hoy</button>
            <button class="filter-btn">Mes Actual</button>
            <button class="filter-btn">Año Actual</button>
            <div class="date-picker">
                <label for="start-date">F. Inicial</label>
                <input type="date" id="start-date">
            </div>
            <div class="date-picker">
                <label for="end-date">F. Final</label>
                <input type="date" id="end-date">
            </div>
            <button class="search-btn">🔍</button>
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
            <div class="stat">
                <h2 style="color: green;">435</h2>
                <p>Atendidas</p>
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

        <!-- Charts Section -->
{{--        <section class="charts">--}}
{{--            <div class="chart">--}}
{{--                <h3>Por área:</h3>--}}
{{--                <canvas id="chart1"></canvas>--}}
{{--            </div>--}}
{{--            <div class="chart">--}}
{{--                <h3>Por área:</h3>--}}
{{--                <canvas id="chart2"></canvas>--}}
{{--            </div>--}}
{{--            <div class="chart">--}}
{{--                <h3>Por área:</h3>--}}
{{--                <canvas id="chart3"></canvas>--}}
{{--            </div>--}}
{{--            <div class="chart">--}}
{{--                <h3>Por área:</h3>--}}
{{--                <canvas id="chart4"></canvas>--}}
{{--            </div>--}}
{{--            <div class="chart">--}}
{{--                <h3>Por área:</h3>--}}
{{--                <canvas id="chart5"></canvas>--}}
{{--            </div>--}}
{{--            <div class="chart">--}}
{{--                <h3>Por zona:</h3>--}}
{{--                <div id="map"></div>--}}
{{--            </div>--}}
{{--        </section>--}}

        <div class="dashboard-container">
            <!-- Sección de solicitudes por área -->
            <div class="section">
                <div class="card">
                    <h3>Recibidas:</h3>

{{--                    <canvas class="chart" id="chart-area-1">[Gráfico de Barras]</canvas>--}}

                                <div class="chart">
                                    <canvas id="chart-area-1"></canvas>
                                </div>

                </div>
                <div class="card">
                    <h3>En proceso / programadas:</h3>
                    <div class="chart" id="chart-area-2">[Gráfico de Barras]</div>
                </div>
                <div class="card">
                    <h3>Atendidas:</h3>
                    <div class="chart" id="chart-area-3">[Gráfico de Barras]</div>
                </div>
                <div class="card">
                    <h3>Rechazadas:</h3>
                    <div class="chart" id="chart-area-5">[Gráfico de Barras]</div>
                </div>
                <div class="card">
                    <h3>Cerradas:</h3>
                    <div class="chart" id="chart-area-5">[Gráfico de Barras]</div>
                </div>
                <div class="card">
                    <h3>Observadas:</h3>
                    <div class="chart" id="chart-area-5">[Gráfico de Barras]</div>
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
                <h3>% solicitudes atendidas / rechazadas</h3>
                <div class="chart" id="chart-attended">[Gráfico de Barras]</div>
            </div>
            <div class="card">
                <h3>% solicitudes cerradas</h3>
                <div class="chart" id="chart-closed">[Gráfico de Donut]</div>
            </div>
            <div class="card">
                <h3>Por zona:</h3>
                <div class="map-container" id="map">[Mapa Interactivo]</div>
            </div>
        </div>

        </div>

    </main>
</div>
</body>
</html>
