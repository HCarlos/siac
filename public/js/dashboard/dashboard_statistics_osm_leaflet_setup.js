let map;
let isCollapsed = true;
let lat = 17.9919;
let lon = -92.9303;
let fullScreenControl = false;

// Inicializar
// initMap_leafletel map
async function initMap_leafletel(dataSet) {

    // alert("Initializing Map...");

    const map = L.map('map').setView([lat, lon], 13); // Villahermosa
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    // alert("Mapa cargando...");

    // Función para crear marcadores arrastrables
    function crearMarcadorArrastrable(lat, lng, contenidoPopup = '¡Arrástrame!') {
        const marcador = L.marker([lat, lng], {
            draggable: true // <-- Esto hace el marcador arrastrable
        })
            .bindPopup(contenidoPopup)
            .addTo(map);

        // Actualizar pop-up al mover el marcador
        marcador.on('dragend', function(e) {
            const nuevaPos = e.target.getLatLng();
            marcador.setPopupContent(`
                    Nueva posición:<br>
                    Lat: ${nuevaPos.lat.toFixed(4)}<br>
                    Lng: ${nuevaPos.lng.toFixed(4)}
                `).openPopup();
        });

        return marcador;
    }

    // Ejemplo: Crear marcador inicial
    crearMarcadorArrastrable(lat, lon, 'Vilahermosa Tab');

    // Añadir nuevo marcador con clic
    // map.on('click', (e) => {
    //     crearMarcadorArrastrable(e.latlng.lat, e.latlng.lng);
    // });

    // alert("Mapa cargado");

}


async function initMap(dataSet) {
    // alert("init");
    // const popupCSS = buildContentCSS()
    const nav = new mapboxgl.NavigationControl({
        visualizePitch: true
    });
    mapboxgl.accessToken = 'pk.eyJ1IjoiZGV2Y2g1MyIsImEiOiJjbTg2MWx1ZmgwMDhwMmxweW9vZmw5NzRqIn0.7zm_QSwliTi7E21wmHuNCA'; // Regístrate para obtenerlo gratis
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [lon, lat], // [longitud, latitud]
        zoom: 13
    }).addControl(new mapboxgl.FullscreenControl({container: document.querySelector('body')}))
        .addControl(nav, 'bottom-right');

    // alert("Init");


    let marker = null;
    for (const property of dataSet) {

        // Crear un marcador personalizado con la clase .property
        const el = document.createElement('div');
        el.className = 'property'; // Asignar la clase .property
        el.innerHTML = buildContentIcon(property);

        // Crear el marcador con el elemento personalizado
        const marker = new mapboxgl.Marker(el)
            .setLngLat(property.position)
            .addTo(map);

        // Crear un popup con la clase .property
        const html = buildContentDetail(property);
        const popup = new mapboxgl.Popup({ offset: 25, closeButton: false, className: 'property' })
            .setHTML(html);

        // Asignar el popup al marcador
        marker.setPopup(popup);


    }

    // Función para crear marcadores arrastrables
    // function crearMarcadorArrastrable(lng, lat, contenido = '¡Arrástrame!') {
    //     const marcador = new mapboxgl.Marker({
    //         draggable: true // <-- Habilita arrastre
    //     })
    //     .setLngLat([lon, lat])
    //     .setPopup(new mapboxgl.Popup().setHTML(contenido))
    //     .addTo(mapa);
    //
    //     // Actualizar posición al mover
    //     marcador.on('dragend', () => {
    //         const nuevaPos = marcador.getLngLat();
    //         marcador.getPopup()
    //             .setHTML(`
    //                 Nueva posición:<br>
    //                 Lat: ${nuevaPos.lat.toFixed(4)}<br>
    //                 Lng: ${nuevaPos.lng.toFixed(4)}
    //             `)
    //             .addTo(mapa);
    //     });
    //
    //     marcador.on('click', (e) => {
    //         toggleHighlight(marcador, property);
    //     });
    //
    //
    //     return marcador;
    // }

    // Marcador inicial
    // let maker = crearMarcadorArrastrable(lon, lat, 'Villahermosa Tabasco');

    // Añadir nuevo marcador con clic
    // mapa.on('click', (e) => {
    //     crearMarcadorArrastrable(e.lngLat.lng, e.lngLat.lat);
    //     toggleHighlight(Marker, property);
    // });

    // const centerControlDiv = document.createElement('div');
    // const centerControl = createCenterControl(mapa,maker);
    // centerControlDiv.appendChild(centerControl);

    // mapa.controls[g oogle.maps.ControlPosition.TOP_RIGHT].push(centerControlDiv);

    // alert("Fin");

}

function toggleHighlight(markerView, property) {
    if (markerView.content.classList.contains("highlight")) {
        markerView.content.classList.remove("div-property");
        markerView.content.classList.remove("highlight");
        markerView.zIndex = null;
    } else {
        markerView.content.classList.add("div-property");
        markerView.content.classList.add("highlight");
        markerView.zIndex = 1;
    }
}

function buildContentIcon(property) {
    // const content = document.createElement("div");
    //
    // content.classList.add("property");

    return `
        <div class="icon">
            <i class="fa-solid fa-${property.icon} fa-${property.type}"></i>
            <span class="fa-sr-only">${property.type}</span>
        </div>
    `;
    // return content.innerHTML;


}


function buildContentDetail(property) {
    // const content = document.createElement("div");
    //
    // content.classList.add("property");

    return `
        <div class="property">
            <div class="icon">
                <i class="fa-solid fa-${property.icon} fa-${property.type}"></i>
                <span class="fa-sr-only">${property.type}</span>
            </div>
            <div class="details">
                <div class="servicio">${property.servicio}</div>
                <div class="denuncia">${property.denuncia}</div>
                <div class="features">
                    <div>
                        <a href="/imprimir_denuncia_ambito_respuesta/${property.uuid}" class="open_solicitud" title="Haga click para abrir esta solicitud" target="_blank">
                        <i aria-hidden="true" class="fa fa-id-card fa-lg bed" title="Haga click para abrir esta solicitud"></i>
                        <span class="fa-sr-only" title="Haga click para abrir esta solicitud">denuncia_id</span>
                        <span title="Haga click para abrir esta solicitud">${property.denuncia_id}</span>
                        </a>
                    </div>
                    <div>
                        <i aria-hidden="true" class="fa fa-calendar fa-lg bath" title="Fecha de ingreso"></i>
                        <span class="fa-sr-only" title="Fecha de ingreso">fecha_ingreso</span>
                        <span title="Fecha de ingreso">${property.fecha_ingreso}</span>
                    </div>
                    <div>
                        <i aria-hidden="true" class="fa fa-building fa-lg size" title="Unidad administrativa"></i>
                        <span class="fa-sr-only" title="Unidad administrativa">unidad</span>
                        <span title="Unidad administrativa">${property.unidad} </span>
                    </div>
                    <div>
                        <i class="fa-solid fa-traffic-light fa-shop fa-lg estatus" title="Estatus"></i>
                        <span class="fa-sr-only" title="Estatus">estatus</span>
                        <span title="Estatus">${property.estatus} </span>
                    </div>
                    <div>
                        <i aria-hidden="true" class="fa-solid fa-exclamation-triangle fa-rojo fa-lg dias_vencidos" title="Días vencidos"></i>
                        <span class="fa-sr-only" title="Días vencidos">dias_vencidos</span>
                        <span  title="Días vencidos">${property.dias_vencidos} </span>
                    </div>
                </div>
            </div>
        </div>
    `;
    // return content.innerHTML;

}

function createCenterControl() {
    const controlButton = document.createElement('button');

    // Set CSS for the control.
    controlButton.style.backgroundColor = 'rgba(239,185,165)';
    controlButton.style.border = '2px solid #fff';
    controlButton.style.borderRadius = '3px';
    controlButton.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlButton.style.color = 'rgb(54,47,47)';
    controlButton.style.cursor = 'pointer';
    controlButton.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlButton.style.fontSize = '16px';
    controlButton.style.lineHeight = '32px';
    controlButton.style.fontWeight = 'bold';
    controlButton.style.margin = '10px 10px';
    controlButton.style.padding = '0 5px';
    controlButton.style.textAlign = 'center';

    controlButton.textContent = 'Expandir';
    controlButton.title = 'Haga click para expandir el map';
    controlButton.type = 'button';

    controlButton.addEventListener('click', (event) => {

        const mapContainer = document.getElementById("map");

        if (!document.fullscreenElement) {
            // Entra en modo pantalla completa
            if (mapContainer.requestFullscreen) {
                mapContainer.requestFullscreen();
            } else if (mapContainer.webkitRequestFullscreen) { /* Safari */
                mapContainer.webkitRequestFullscreen();
            } else if (mapContainer.msRequestFullscreen) { /* IE11 */
                mapContainer.msRequestFullscreen();
            }

            controlButton.textContent = 'Reducir';
            controlButton.title = 'Haga click para reducir el map';
        } else {
            // Sale del modo pantalla completa
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) { /* Safari */
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { /* IE11 */
                document.msExitFullscreen();
            }

            controlButton.textContent = 'Expandir';
            controlButton.title = 'Haga click para expandir el map';
        }

        // Obtén el título del botón
        console.log(`Título actual del botón: ${controlButton.title}`);

        fullScreenControl = !fullScreenControl;
        console.log(fullScreenControl);

    });

    return controlButton;
}
