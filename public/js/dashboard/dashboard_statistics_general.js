/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

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
        document.getElementById("h2Cerradas").innerHTML = Estatus.estatus[4].Total;
        document.getElementById("h2Observadas").innerHTML = Estatus.estatus[5].Total;

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
            // dataSetLocations.push({
            //     denuncia_id:geo.denuncia_id, lat: geo.latitud, lng: geo.longitud, color: geo.semaforo,
            //     ciudadano: geo.ciudadano, unidad: geo.abreviatura, denuncia: geo.denuncia,
            //     servicio: geo.servicio, fecha_ingreso: geo.fecha_ingreso,dias_a_tiempo: geo.dias_a_tiempo,
            //     ultimo_estatus: geo.ultimo_estatus, fecha_ejecucion_minima: geo.fecha_ejecucion_minima,
            //     fecha_ejecucion_maxima: geo.fecha_ejecucion_maxima
            // });

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
                }
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
