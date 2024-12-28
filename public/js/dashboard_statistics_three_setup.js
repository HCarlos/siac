// Example: Generate simple bar charts using Chart.js

    function data1(dataSet) {
        console.log(dataSet);
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
        console.log(dataSet);
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



