
document.addEventListener('DOMContentLoaded', () => {


    const ctx1a = document.getElementById('chart-area-1');
    const chart1a = new Chart(ctx1a, {
        type: 'bar',
        data: data1([10, 5, 9, 37, 40]),
        options: opciones1()
    });

// alert("hola");

});

