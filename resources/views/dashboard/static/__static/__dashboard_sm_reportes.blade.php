<div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <!-- LOGO -->
            <a href="/listDenunciasAmbito2"  >
                <img src="{{asset('images/web/logo-0.png')}}" alt="" >
            </a>

        </div>

        <nav class="menu">
            @include('shared.ui_kit.__menu_dashboard_static')
        </nav>
    </aside>

    <!-- Main Content -->
    <main id="contenedor">
        <!-- Header -->
        <div class="title-wrapper">
            <h2 class="main-title--">Reportes Servicios Municipales Monitoreados</h2>
            <p class="subtitle">Selecciona un filtro de tiempo para ver los datos detallados</p>
        </div>
        <form action="{{ url('/dssp-reportes') }}" method="POST" id="formFilter">
            @csrf
            <header class="header">
                <div class="date-picker">
                    <label for="start_date">F. Inicial</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $start_date }}">
                </div>
                <div class="date-picker">
                    <label for="end_date">F. Final</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $end_date }}">
                </div>
{{--                <div class="search-container">--}}
{{--                    <button class="search-btn" type="submit" >--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="search-icon">--}}
{{--                            <path d="M10 2a8 8 0 105.29 14.29l4.35 4.35a1 1 0 001.42-1.42l-4.35-4.35A8 8 0 0010 2zm0 2a6 6 0 014.66 9.74 1 1 0 00-.14 1.41l4.35 4.35a1 1 0 001.42-1.42l-4.35-4.35a1 1 0 00-1.41.14A6 6 0 1110 4z" />--}}
{{--                        </svg>--}}
{{--                    </button>--}}
{{--                </div>--}}
                <button type="button" id="frmReporteDiarioNov" class="btn btn-info btn-reporte-diario ms-auto">
                    <i class="fas fa-file-fragment text-white"></i> Reporte Diario
                </button>

            </header>
        </form>

        <div class="dashboard-container">
            <!-- Sección de solicitudes por área -->
            <!-- Zona del Mapa -->
            <div class="section">
                <div class="card shadow-sm" >

{{--                    <div class="card-header">--}}
{{--                        <form class="form-modern">--}}
{{--                            <div class="btn-group">--}}
{{--                                <button type="button" id="frmReporteDiarioNov" class="btn btn-info btn-reporte-diario ms-auto">--}}
{{--                                    <i class="fas fa-file-fragment text-white"></i> Reporte Diario--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}

                    <div class="card-body">
                        <div class="map-container" id="map-container">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <input type="hidden" id="denuncias" name="denuncias" value="">
    <input type="hidden" id="ddse_id" name="ddse_id" value="">

</div>


<script>




    document.addEventListener('DOMContentLoaded', () => {

        // function initLoadData() {

            // let frmReporteDiarioNov = document.getElementById("frmReporteDiarioNov");
            // frmReporteDiarioNov.disabled = true;


            // document.getElementById("h2Total").innerHTML = getCommaSeparatedTwoDecimalsNumber(Estatus.estatus[0].Total + Estatus.estatus[1].Total + Estatus.estatus[2].Total + Estatus.estatus[3].Total + Estatus.estatus[4].Total + Estatus.estatus[5].Total + Estatus.estatus[6].Total);


            const btnReporteDiario = document.getElementById('frmReporteDiarioNov');
            const _start_date = document.getElementById('start_date').value;
            const _end_date = document.getElementById('end_date').value;
            btnReporteDiario.addEventListener('click', function () {
                // btnReporteDiario.disabled = true;
                var PARAMS = {
                    search : "",
                    start_date : _start_date,
                    end_date : _end_date,
                    _token : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };

                var temp=document.createElement("form");
                temp.action='reporteDiarioExcelNov1';
                temp.method="POST";
                temp.target="_blank";
                temp.style.display="none";
                for(var x in PARAMS) {
                    var opt=document.createElement("textarea");
                    opt.name=x;
                    opt.value=PARAMS[x];
                    temp.appendChild(opt);
                }
                document.body.appendChild(temp);
                temp.submit();
                // btnReporteDiario.disabled = false;
                // btnReporteSemanal.disabled = false;
                return temp;

            });


        // }



        // document.querySelectorAll('.radio-button input').forEach((input) => {
        //     input.addEventListener('change', function (event) {
        //         document.getElementById('formFilter').submit();
        //     });
        // });



    });


    // function filterMap(Georeferencias, frmFilterDataExport) {
    //     const selectZona = document.getElementById('zona');
    //     const selectServicios = document.getElementById('servicios');
    //     const selectColonias = document.getElementById('colonias');
    //     const selectDelegaciones = document.getElementById('delegaciones');
    //     const inputDenuncias = document.getElementById('denuncias');
    //     const inputDDSE = document.getElementById('ddse_id');
    //     const selectedZona = selectZona.value;
    //     const selectedServicio = selectServicios.value;
    //     const selectedColonia = selectColonias.value;
    //     const selectedDelegacion = selectDelegaciones.value;
    //     const dataSetLocations = [];
    //     const denuncias_id = [];
    //     const ddse_id = [];
    //     Georeferencias.georeferencias.forEach( (geo) => {
    //         var dep = geo.dependencia_id;
    //         var ser = geo.sue_id;
    //         var col = geo.colonia_delegacion_id;
    //         var del = geo.delegacion_id;
    //
    //         if (selectedZona == 0 && selectedServicio == 0 && selectedColonia == 0 && selectedDelegacion == 0) {
    //             console.log("01");
    //             dataSetLocations.push(setDataLocations(geo, denuncias_id, ddse_id));
    //         }else if (selectedZona == 0 && selectedServicio == 0 && selectedColonia == 0 && selectedDelegacion == del){
    //             console.log("02");
    //             dataSetLocations.push(setDataLocations(geo, denuncias_id, ddse_id));
    //         }else if (selectedZona == 0 && selectedServicio == 0 && selectedColonia == col && selectedDelegacion == del){
    //             console.log("03");
    //             dataSetLocations.push(setDataLocations(geo, denuncias_id, ddse_id));
    //         }else if (selectedZona == 0 && selectedServicio == ser && selectedColonia == 0 && selectedDelegacion == 0){
    //             console.log("04");
    //             dataSetLocations.push(setDataLocations(geo, denuncias_id, ddse_id));
    //         }else if (selectedZona == 0 && selectedServicio == ser && selectedColonia == 0 && selectedDelegacion == del){
    //             console.log("06");
    //             dataSetLocations.push(setDataLocations(geo, denuncias_id, ddse_id));
    //         }else if (selectedZona == 0 && selectedServicio == ser && selectedColonia == col && selectedDelegacion == del) {
    //             console.log("07");
    //             dataSetLocations.push(setDataLocations(geo, denuncias_id, ddse_id));
    //         }else if (selectedZona == dep && selectedServicio == 0 && selectedColonia == 0 && selectedDelegacion == 0) {
    //             console.log("11");
    //             dataSetLocations.push(setDataLocations(geo, denuncias_id, ddse_id));
    //         }else if (selectedZona == dep && selectedServicio == 0 && selectedColonia == 0 && selectedDelegacion == del){
    //             console.log("12");
    //             dataSetLocations.push(setDataLocations(geo, denuncias_id, ddse_id));
    //         }else if (selectedZona == dep && selectedServicio == 0 && selectedColonia == col && selectedDelegacion == del){
    //             console.log("13");
    //             dataSetLocations.push(setDataLocations(geo, denuncias_id, ddse_id));
    //         }else if (selectedZona == dep && selectedServicio == ser && selectedColonia == 0 && selectedDelegacion == 0){
    //             console.log("14");
    //             dataSetLocations.push(setDataLocations(geo, denuncias_id, ddse_id));
    //         }else if (selectedZona == dep && selectedServicio == ser && selectedColonia == 0 && selectedDelegacion == del){
    //             console.log("16");
    //             dataSetLocations.push(setDataLocations(geo, denuncias_id, ddse_id));
    //         }else if (selectedZona == dep && selectedServicio == ser && selectedColonia == col && selectedDelegacion == del) {
    //             console.log("17");
    //             dataSetLocations.push(setDataLocations(geo, denuncias_id, ddse_id));
    //         }
    //
    //     });
    //     inputDenuncias.value = denuncias_id.join(',');
    //     inputDDSE.value = ddse_id.join(',');
    //
    //     items.value = getCommaSeparatedTwoDecimalsNumber(dataSetLocations.length);
    //
    //     let lat = 17.9919;
    //     let lon = -92.9303;
    //     window.onload = async () => initMap(dataSetLocations, lat, lon);
    //     initMap(dataSetLocations, lat, lon);
    //
    //     if (dataSetLocations.length == 0) {
    //         frmFilterDataExport.disabled = true;
    //         // frmReporteDiarioNov.disabled = true;
    //         frmReporteSemanal.disabled = true;
    //         frmResumenBasicoExport.disabled = true;
    //         alert("No hay datos para mostrar");
    //     }else{
    //         frmFilterDataExport.disabled = false;
    //         // frmReporteDiarioNov.disabled = false;
    //         frmReporteSemanal.disabled = false;
    //         frmResumenBasicoExport.disabled = false;
    //     }
    //
    // }
    //
    // function setDataLocations(geo,denuncias_id,ddse_id) {
    //     denuncias_id.push(geo.denuncia_id);
    //     ddse_id.push(geo.ddse_id);
    //     return {
    //         denuncia_id:geo.denuncia_id,
    //         fecha_ingreso: geo.fecha_ingreso,
    //         unidad: geo.abreviatura,
    //         denuncia: geo.denuncia,
    //         description: geo.ciudadano,
    //         servicio: geo.servicio,
    //         estatus: geo.ultimo_estatus,
    //         type: geo.type,
    //         icon: geo.icon,
    //         dias_vencidos: geo.dias_vencidos,
    //         position: {
    //             lat: geo.latitud,
    //             lng: geo.longitud,
    //         },
    //         uuid: geo.uuid,
    //         colonia_delegacion: geo.colonia_delegacion,
    //         delegado: geo.delegado,
    //         colonia_delegacion_id: geo.colonia_delegacion_id
    //     };
    // }
    //
    // function getCommaSeparatedTwoDecimalsNumber(number) {
    //     const fixedNumber = Number.parseFloat(number).toFixed(0);
    //     return String(fixedNumber).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //
    // }



    {{--document.addEventListener("DOMContentLoaded",()=>{async function e(e){try{let a=await fetch(e);if(!a.ok)throw Error(`Error al cargar JSON: ${a.statusText}`);let o=await a.json();t(o[0],o[1],o[2],o[3],o[4])}catch(r){console.error(r)}}function t(e,t,a,o,r){let n=[],s=[],d=[],i=[],l=[],u=[],c=[],h=[];document.getElementById("h2Recibidas").innerHTML=e.estatus[0].Total,document.getElementById("h2EnProceso").innerHTML=e.estatus[1].Total,document.getElementById("h2Atendidas").innerHTML=e.estatus[2].Total,document.getElementById("h2Aatendidas").innerHTML=e.estatus[2].a_tiempo,document.getElementById("h2Abtendidas").innerHTML=e.estatus[2].con_rezago,document.getElementById("h2Rechazadas").innerHTML=e.estatus[3].Total,document.getElementById("h2Total").innerHTML=e.estatus[0].Total+e.estatus[1].Total+e.estatus[2].Total+e.estatus[3].Total+e.estatus[4].Total+e.estatus[5].Total;var g=[0,0,0,0,0,0];e.estatus[0].Unidades.forEach((e,t=0)=>{n.push(e.Total),g[t]+=e.Total}),e.estatus[1].Unidades.forEach((e,t=0)=>{s.push(e.Total),g[t]+=e.Total}),e.estatus[2].Unidades.forEach((e,t=0)=>{d.push(e.Total),g[t]+=e.Total}),e.estatus[3].Unidades.forEach((e,t=0)=>{i.push(e.Total),g[t]+=e.Total}),e.estatus[4].Unidades.forEach((e,t=0)=>{l.push(e.Total),g[t]+=e.Total}),e.estatus[5].Unidades.forEach((e,t=0)=>{u.push(e.Total),g[t]+=e.Total}),console.log(g),e.estatus[2].Unidades.forEach(e=>{c.push(e.a_tiempo),h.push(e.con_rezago)});var p=0;t.unidades.forEach(e=>{document.getElementById("u"+p).innerHTML=e.Unidad,document.getElementById("u"+p+"p").innerHTML=e.Porcentaje+"%",p++});let T=document.getElementById("chart-area-1");new Chart(T,{type:"bar",data:data1(n),options:opciones1()});let y=document.getElementById("chart-area-2");new Chart(y,{type:"bar",data:data1(s),options:opciones1()});let E=document.getElementById("chart-area-3");new Chart(E,{type:"bar",data:data2([{type:"bar",label:"En tiempo",data:c,backgroundColor:"rgba(54, 162, 235, 0.6)",borderColor:"rgba(54, 162, 235, 1)",borderWidth:1,hoverBackgroundColor:"rgba(54, 162, 235, 0.6)",hoverBorderColor:"rgba(54, 162, 235, 1)"},{type:"bar",label:"Con rezago",data:h,backgroundColor:"rgba(255, 99, 132, 0.2)",borderColor:"rgba(255, 99, 132, 1)",borderWidth:1,hoverBackgroundColor:"rgba(255, 99, 132, 0.4)",hoverBorderColor:"rgba(255, 99, 132, 1)"},]),options:opciones2()});let b=document.getElementById("chart-area-4");new Chart(b,{type:"bar",data:data1(i),options:opciones1()});let $=document.getElementById("chart-area-7");new Chart($,{type:"bar",data:data1(g),options:opciones1()});let m=document.getElementById("solicitudesChart");new Chart(m,{type:"pie",data:data3([r.otros[0].atendidas,r.otros[0].rechazadas]),options:opciones3pie(),plugins:[ChartDataLabels]});let B=document.getElementById("closedRequestsChart");new Chart(B,{type:"doughnut",data:data4([r.otros[0].porcAtendidas,r.otros[0].porcPendientes]),options:opciones4()});let f=[],_=[],I=[];a.servicios.forEach(e=>{_.push(e.Total),I.push(e.Servicio),p++});let v=document.getElementById("servicesChart");new Chart(v,{type:"bar",data:data5(I,_),options:opciones5()}),o.georeferencias.forEach(e=>{f.push({denuncia_id:e.denuncia_id,fecha_ingreso:e.fecha_ingreso,unidad:e.abreviatura,denuncia:e.denuncia,description:e.ciudadano,servicio:e.servicio,estatus:e.ultimo_estatus,type:e.type,icon:e.icon,dias_vencidos:e.dias_vencidos,position:{lat:e.latitud,lng:e.longitud}})}),window.onload=async()=>initMap(f),initMap(f)}window.onload=e("/storage/{{ $file_output }}"),document.querySelectorAll(".radio-button input").forEach(e=>{e.addEventListener("change",function(e){"free"!==e.currentTarget.value&&document.getElementById("formFilter").submit()})})});--}}

</script>

