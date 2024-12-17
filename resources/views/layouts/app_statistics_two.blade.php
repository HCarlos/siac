<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Grid</title>
{{--    <script src="https://kit.fontawesome.com/dda7334082.js" crossorigin="anonymous"></script>--}}
    <link rel="stylesheet" href="css/dashboard_statistics_two.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
{{--    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="grid-container">
    <!-- Generar 8 filas x 3 columnas = 24 celdas -->
    <div class="grid-item">
        <button class="expand-btn"><i class="fas fa-expand"></i></button>
        <button class="collapse-btn"><i class="fas fa-compress"></i></button>
        <canvas class="chart" width="100" height="100"></canvas>
    </div>
    <div class="grid-item">
        <button class="expand-btn"><i class="fas fa-expand"></i></button>
        <button class="collapse-btn"><i class="fas fa-compress"></i></button>
        <canvas class="chart" width="100" height="100"></canvas>
    </div>
    <div class="grid-item">
        <button class="expand-btn"><i class="fas fa-expand"></i></button>
        <button class="collapse-btn"><i class="fas fa-compress"></i></button>
        <canvas class="chart" width="100" height="100"></canvas>
    </div>
    <div class="grid-item">
        <button class="expand-btn"><i class="fas fa-expand"></i></button>
        <button class="collapse-btn"><i class="fas fa-compress"></i></button>
        <canvas class="chart" width="100" height="100"></canvas>
    </div>
    <div class="grid-item">
        <button class="expand-btn"><i class="fas fa-expand"></i></button>
        <button class="collapse-btn"><i class="fas fa-compress"></i></button>
        <canvas class="chart" width="100" height="100"></canvas>
    </div>
    <div class="grid-item">
        <button class="expand-btn"><i class="fas fa-expand"></i></button>
        <button class="collapse-btn"><i class="fas fa-compress"></i></button>
        <canvas class="chart" width="100" height="100"></canvas>
    </div>
    <div class="grid-item">
        <button class="expand-btn"><i class="fas fa-expand"></i></button>
        <button class="collapse-btn"><i class="fas fa-compress"></i></button>
        <canvas class="chart" width="100" height="100"></canvas>
    </div>
    <div class="grid-item">
        <button class="expand-btn"><i class="fas fa-expand"></i></button>
        <button class="collapse-btn"><i class="fas fa-compress"></i></button>
        <canvas class="chart" width="100" height="100"></canvas>
    </div>
    <div class="grid-item">
        <button class="expand-btn"><i class="fas fa-expand"></i></button>
        <button class="collapse-btn"><i class="fas fa-compress"></i></button>
        <canvas class="chart" width="100" height="100"></canvas>
    </div>
    <!-- Resto de las celdas -->
    <div class="grid-item">
        <button class="expand-btn"><i class="fas fa-expand"></i></button>
        <button class="collapse-btn"><i class="fas fa-compress"></i></button>
        <div id="gauge-chart"></div>
    </div>
</div>
</body>

<script>
    $(document).ready(function () {
        // Expandir el div al hacer clic en el botón "Expand"
        $('.expand-btn').on('click', function (e) {
            e.stopPropagation(); // Prevenir la propagación del clic
            const parentDiv = $(this).parent();

            // Ocultar otros divs y expandir el actual
            $('.grid-item').not(parentDiv).hide();
            parentDiv.addClass('expanded');
        });

        // Contraer el div al hacer clic en el botón "Collapse"
        $('.collapse-btn').on('click', function (e) {
            e.stopPropagation(); // Prevenir la propagación del clic
            const parentDiv = $(this).parent();

            // Mostrar todos los divs y restaurar el diseño original
            parentDiv.removeClass('expanded');
            $('.grid-item').show();
        });

        // Inicializar gráficos en los canvas
        $('.chart').each(function () {
            const ctx = this.getContext('2d');

            // Crear un gráfico tipo "doughnut" para simular el arco
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'Remaining'],
                    datasets: [{
                        label: 'Progress',
                        data: [65, 35], // 65% completado, 35% restante
                        backgroundColor: ['#4caf50', '#e0e0e0'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%', // Proporción del grosor del arco
                    plugins: {
                        tooltip: { enabled: false }, // Desactivar tooltip
                        legend: { display: false }  // Desactivar leyenda
                    }
                }
            });
        });

        // Valor dinámico
        let value = 24;

        // Configuración del gráfico responsivo
        var options = {
            chart: {
                type: "radialBar",
                height: "90%",
                width: "90%"
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    hollow: {
                        margin: 15,
                        size: "65%"
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            offsetY: 10,
                            fontSize: "22px",
                            color: "#333"
                        }
                    }
                }
            },
            series: [value], // Valor del gráfico
            labels: ["Progress"],
            colors: ["#00BFFF"], // Color de la barra
            responsive: [{
                breakpoint: 600,
                options: {
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                size: "50%"
                            },
                            dataLabels: {
                                value: {
                                    fontSize: "18px"
                                }
                            }
                        }
                    }
                }
            }]
        };

        // Renderizar el gráfico
        var chart = new ApexCharts(document.querySelector("#gauge-chart"), options);
        chart.render();




    });
</script>
</html>
