// Example: Generate simple bar charts using Chart.js
    function data1(dataSet) {
        // console.log(dataSet);
        return {
            labels: ['Alumbrado', 'Esp Púb', 'Limpia', 'Obras', 'SAS'],
            datasets: [{
                axis: 'y',
                label: 'Solicitudes',
                data: dataSet,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

    }
    function opciones1(){
        return {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
            x: {
                ticks: {
                    font: {
                        size: 8
                    }
                }
            },
            y: {
                ticks: {
                    font: {
                        size: 8
                    }
                }
            },
        },
            plugins: {
                legend: {
                    display: false
                }
            },
            animation: {
                duration: 400,
                    onComplete: function() {
                    ctx = this.ctx;
                    ctx.font = Chart.helpers.fontString(8, 'normal', Chart.defaults.font.family);
                    chartinst = this;
                        this.data.datasets.forEach(function(dataset, i) {
                        if (chartinst.isDatasetVisible(i)) {
                            var meta = chartinst.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                var data = dataset.data[index];
                                // alert(bar.x);
                                var textX = bar.x > 160 ? bar.x - 20 : bar.x + 2;
                                ctx.fillText(data, textX, bar.y + 4);
                            });
                        }
                    });
                }
            }

        }

    }

    function data2(dataSet) {
        // console.log(dataSet);
        return {
            labels: ['Alumbrado', 'Esp Púb', 'Limpia', 'Obras', 'SAS'],
            datasets: dataSet,
        };
    }
    function opciones2(){
        return {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
                x: {
                    stacked: true,
                    ticks: {
                        font: {
                            size: 8
                        }
                    }
                },
                y: {
                    stacked: true,
                    ticks: {
                        font: {
                            size: 8
                        }
                    }
                },
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            interaction: {
                intersect: true,
            },
            animation: {
                duration: 400,
                onComplete: function() {
                    ctx = this.ctx;
                    ctx.font = Chart.helpers.fontString(8, 'normal', Chart.defaults.font.family);
                    chartinst = this;
                    this.data.datasets.forEach(function(dataset, i) {
                        if (chartinst.isDatasetVisible(i)) {
                            var meta = chartinst.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                var data = dataset.data[index];
                                // alert(bar.x);
                                var textX = bar.x > 100 ? bar.x - 12 : bar.x + 4;
                                ctx.fillText(data, textX, bar.y + 4);
                            });
                        }
                    });
                }
            }

        }

    }

    function data3(dataSet) {
        return {
            labels: ['Atendidas', 'Rechazadas (No procede)'],
            datasets: [{
                label: '% de solicitudes',
                data: dataSet,
                backgroundColor: [
                    'rgba(76, 175, 80, 0.8)',  // Verde para atendidas
                    'rgba(229, 57, 53, 0.8)'   // Rojo para rechazadas
                ],
                borderColor: [
                    'rgba(76, 175, 80, 1)',
                    'rgba(229, 57, 53, 1)'
                ],
                borderWidth: 1,
                borderRadius: 5,
                barThickness: 50
            }]
        }
    }
    function opciones3(){
        return {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'x',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.raw} solicitudes`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: true
                    },
                    ticks: {
                        color: '#333',
                        font: {
                            size: 9
                        },
                        display: true
                    }
                },
                y: {
                    beginAtZero: true,
                    min: 0,
                    max:100,
                    grid: {
                        color: '#e0e0e0',
                        drawBorder: true
                    },
                    ticks: {
                        stepSize: 5,
                        color: '#333',
                        font: {
                            size: 8
                        },
                        display: true
                    }
                }
            },
            interaction: {
                intersect: true,
            },
            animation: {
                duration: 400,
                onComplete: function() {
                    ctx = this.ctx;
                    ctx.font = Chart.helpers.fontString(8, 'normal', Chart.defaults.font.family);
                    chartinst = this;
                    this.data.datasets.forEach(function(dataset, i) {
                        if (chartinst.isDatasetVisible(i)) {
                            var meta = chartinst.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                var data = dataset.data[index];
                                // alert(bar.y);
                                var textY =data > 95 ? bar.y + 10 : bar.y - 5;
                                ctx.fillText(data, bar.x - 7, textY);
                            });
                        }
                    });
                }
            }

        }
    }

    function data4(dataSet) {
        return {
            labels: ['Cerradas', 'Pendientes'],
            datasets: [{
                data: dataSet,
                backgroundColor: [
                    'rgba(76, 175, 80, 0.8)',  // Verde para cerradas
                    'rgba(189, 189, 189, 0.8)' // Gris para pendientes
                ],
                borderWidth: 2,
                borderColor: [
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)'
                ],
            }]
        }
    }
    function opciones4(){
        return {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    enabled: true // Deshabilitar tooltips para que se enfoque en la visualización
                },
                legend: {
                    display: false // Ocultar leyenda para simplificar el diseño
                },
                title: {
                    display: true
                }
            },
            cutout: '70%', // Hace que el gráfico sea un semicírculo
            rotation: -90, // Rota el gráfico para iniciar desde la parte superior
            circumference: 180, // Muestra solo la mitad del gráfico (semicírculo)
            interaction: {
                intersect: true,
            },
            animation: {
                duration: 0,
                onComplete: function() {
                    ctx = this.ctx;
                    ctx.font = Chart.helpers.fontString(12, 'normal', Chart.defaults.font.family);
                    chartinst = this;
                    this.data.datasets.forEach(function(dataset, i) {
                        if (chartinst.isDatasetVisible(i)) {
                            var meta = chartinst.getDatasetMeta(i);
                            meta.data.forEach(function(bar) {
                                var data = dataset.data[0];
                                ctx.fillText(data, bar.x - 15, bar.y - 0);
                            });
                        }
                    });
                }
            }

        }
    }


// labels: [
//     'Bacheo en vialidades',
//     'Desazolve de drenaje',
//     'Fuga de agua potable',
//     'Recolección de residuos sólidos',
//     'Reparación de alcantarilla',
//     'Reparación de luminarias',
// ],
function data5(dataSetLabels,dataSet) {
    return {
        labels: dataSetLabels,
        datasets: [{
            label: 'Cantidad de servicios',
            data: dataSet,
            backgroundColor: [
                '#6a0dad', // Morado
                '#0044cc', // Azul oscuro
                '#00bfff', // Cian
                '#32cd32', // Verde
                '#ffc107', // Amarillo
                '#dc3545', // Rojo
            ],
            borderWidth: 1,
            borderColor: '#ffffff', // Bordes blancos
            borderRadius: 3, // Bordes redondeados
            barPercentage: 0.8, // Grosor de las barras
        }]
    }
}
function opciones5(){
    return {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',
        scales: {
            x: {
                stacked: true,
                ticks: {
                    font: {
                        size: 8
                    }
                }
            },
            y: {
                stacked: true,
                ticks: {
                    font: {
                        size: 8
                    }
                }
            },
        },
        plugins: {
            legend: {
                display: false
            }
        },
        interaction: {
            intersect: true,
        },
        animation: {
            duration: 0,
            onComplete: function() {
                ctx = this.ctx;
                ctx.font = Chart.helpers.fontString(8, 'normal', Chart.defaults.font.family);
                chartinst = this;
                this.data.datasets.forEach(function(dataset, i) {
                    if (chartinst.isDatasetVisible(i)) {
                        var meta = chartinst.getDatasetMeta(i);
                        meta.data.forEach(function(bar, index) {
                            var data = dataset.data[index];
                            // alert(bar.x);
                            var textX = bar.x > 180 ? bar.x - 12 : bar.x + 4;
                            ctx.fillText(data, textX, bar.y + 4);
                        });
                    }
                });
            }
        }
    }
}

