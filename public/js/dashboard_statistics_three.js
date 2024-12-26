// Example: Generate simple bar charts using Chart.js
document.addEventListener('DOMContentLoaded', () => {

    // const ctx1 = document.getElementById('chart1').getContext('2d');
    // new Chart(ctx1, {
    //     type: 'horizontalBar',
    //     data: {
    //         labels: ['Alumbrado', 'Espacios Públicos', 'Limpia', 'Obras', 'SAS'],
    //         datasets: [{
    //             label: 'Recibidas',
    //             data: [10, 5, 9, 37, 39],
    //             backgroundColor: '#870606'
    //         }]
    //     },
    //     options: { responsive: true }
    // });
    //
    // const ctx2 = document.getElementById('chart2').getContext('2d');
    // new Chart(ctx2, {
    //     type: 'pie',
    //     data: {
    //         labels: ['Atendidas', 'Rechazadas'],
    //         datasets: [{
    //             data: [93, 47],
    //             backgroundColor: ['#4caf50', '#f44336']
    //         }]
    //     },
    //     options: { responsive: true }
    // });
    //
    // const ctx3 = document.getElementById('chart3').getContext('2d');
    // new Chart(ctx3, {
    //     type: 'bar',
    //     data: {
    //         labels: ['Alumbrado', 'Espacios Públicos', 'Limpia', 'Obras', 'SAS'],
    //         datasets: [{
    //             label: 'Recibidas',
    //             data: [10, 5, 9, 37, 39],
    //             backgroundColor: ['#4CAF50', '#FF9800', '#03A9F4', '#E91E63', '#9C27B0']
    //         }]
    //     }
    // });
    //

    const ctx1a = document.getElementById('chart-area-1');
    const chart1a = new Chart(ctx1a, {
        type: 'bar',
        data: {
            labels: ['Alumbrado', 'Esp Púb', 'Limpia', 'Obras', 'SAS'],
            datasets: [{
                axis: 'y',
                label: 'Solicitudes',
                data: [10, 5, 9, 37, 39],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
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
                                var textX = bar.x > 170 ? bar.x - 20 : bar.x + 2;
                                ctx.fillText(data, textX, bar.y + 4);
                            });
                        }
                    });
                }
            }

        }
    });

// alert("hola");

});

