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
                    stacked: false,
                    ticks: {
                        font: {
                            size: 8
                        }
                    }
                },
                y: {
                    stacked: false,
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

    const sliceOffsets = [0, 0, 0, 0, 0, 0];

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
                borderWidth: 2,
                borderColor: [
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)'
                ],
                borderRadius: 1,
                barThickness: 50,
                maxBarThickness: 50
            }]
        }
    }
    function opciones3pie(){
        return {
            responsive: true,
            maintainAspectRatio: false,
            elements: {
                arc: {
                    borderRadius: 0
                }
            },
            // Evento onClick para alternar el desplazamiento del segmento clicado
            onClick: (event, activeSegments) => {
                const OFFSET_VALUE = 20; // Introducir constante para el valor del desplazamiento

                if (activeSegments.length > 0) {
                    const segmentIndex = activeSegments[0].index; // Renombrar a un nombre más descriptivo
                    toggleSegmentOffset(segmentIndex); // Extraer lógica en una función
                    //this.data.update();
                }

                function toggleSegmentOffset(index) {
                    sliceOffsets[index] = sliceOffsets[index] === 0 ? OFFSET_VALUE : 0;
                }
            },
            plugins: {
                datalabels: {
                    color: 'rgba(54,47,47,0.85)',
                    display: true,
                    anchor: 'end',    // ancla la etiqueta al borde exterior del segmento
                    align: 'start',   // posiciona la etiqueta hacia afuera
                    offset: 10,       // separa la etiqueta un poco del borde
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: (value, context) => {
                        return value;  // Muestra el valor numérico de cada segmento
                    }
                },
                legend: {
                    display: false,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.raw} solicitudes`;
                        }
                    }
                }
            },

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
                                var textX = bar.x > 180 ? bar.x - 18 : bar.x + 4;
                                ctx.fillText(data, textX, bar.y + 4);
                            });
                        }
                    });
                }
            }
        }
    }

function data3pie(dataSetLabels,dataSet) {
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
