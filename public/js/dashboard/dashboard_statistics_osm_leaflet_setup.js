let map;
let isCollapsed = true;
let lat = 17.9919;
let lon = -92.9303;
let fullScreenControl = false;

// initMap_leafletel map
async function initMap(dataSet) {

    // alert("Initializing Map...");

    // const map = L.map('map').setView([lat, lon], 13); // Villahermosa
    // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    //

// Crear el mapa
    const map = L.map('map', {
        fullscreenControl: false, // Activar control de pantalla completa
        center: [lat, lon], // Coordenadas de Villahermosa
        zoom: 15
    });

// Añadir capa base (ej: OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    // map.addControl(L.control.fullscreen({
    //     position: 'topright', // Posición en el mapa (topright, bottomleft, etc.)
    //     title: 'Pantalla Completa', // Texto al pasar el mouse
    //     titleCancel: 'Salir de Pantalla Completa', // Texto al salir
    //     forceSeparateButton: true // Mostrar como botón independiente
    // }));


    for (const property of dataSet) {

        // Crear un marcador personalizado con la clase .property
        const el = document.createElement('div');
        el.className = 'property'; // Asignar la clase .property
        el.innerHTML = buildContentIcon(property);

        const colors = {
            rojos: '#DC0606FF',
            amarillos: '#F1C022FF',
            verdes: '#35B324FF'
        }
        const awesomeIcon = L.AwesomeMarkers.icon({
            markerColor: colors[`${property.type}s`], // Color del marcador (red, blue, green, etc.)\``
            icon: `${property.icon}`, // Nombre del icono de Font Awesome (sin el 'fa-')
            prefix: 'fa', // Prefijo de Font Awesome
            extraClasses: 'fas' // Clases adicionales (ej: 'fa-spin' para animación)
        });


        const htmlIcon = L.divIcon({
            className: 'custom-html-marker', // Clase CSS
            html: '<div style="background-color: ' + colors[`${property.type}s`] + ';" class="leaflet-marker-icon">' + '<i class="fas fa-' + property.icon + '"></i></div>',
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });


        const marker = L.marker(property.position, {
            icon: htmlIcon,
            closeButton: true,
            draggable: false // <-- Esto hace el marcador arrastrable
            })
                .bindPopup(buildContentDetail(property,"property"))
                .addTo(map);



    }





}

// initMap_mapbox
async function initMap_mapbox(dataSet) {
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
        .addControl(new mapboxgl.GeolocateControl({
            trackUserLocation: true,
            showUserHeading: true
        }));
        // .addControl(nav, 'bottom-right');

    for (const property of dataSet) {

        const colors = {
            rojos: '#DC0606FF',
            amarillos: '#F1C022FF',
            verdes: '#35B324FF'
        }


        // Crear un marcador personalizado con la clase .property
        const el = document.createElement('div');
        el.className = 'property'; // Asignar la clase .property
        el.innerHTML = buildContentIcon(property,colors[`${property.type}s`] );

        // Crear el marcador con el elemento personalizado
        const marker = new mapboxgl.Marker(el)
            .setLngLat(property.position)
            .addTo(map);

        // Crear un popup con la clase .property
        const html = buildContentDetail(property,'highlight');
        // alert(html);
        const popup = new mapboxgl.Popup({ offset: 25, closeButton: true, className: 'highlight' })
            .setHTML(html);

        // Asignar el popup al marcador
        marker.setPopup(popup);


    }
    // alert("Mapa cargado");

}


function buildContentIcon(property, bgColor) {
    return `
        <div class=" leaflet-marker-icon ${property.type}s" style="background-color: ` + bgColor + `;" >
            <i class="fa-solid fa-${property.icon} "></i>
            <span class="fa-sr-only">${property.type}</span>
        </div>
    `;
}

function buildContentDetail(property, className) {
    // console.log(className);
    return `
        <div class="`+className+`">
            <div class="details">
                <div class="servicio">
                    <span class="highlight">
                        <i class="fa-solid fa-${property.icon} ${property.type}s mr-1"></i>
                        <span class="fa-sr-only ">${property.type}</span>
                    </span>
                    ${property.servicio}
                    </div>
                <div class="denuncia">${property.denuncia}</div>
                <div class="features">
                    <div>
                        <span>
                            <i aria-hidden="true" class="fa fa-id-card fa-lg bed" title="Haga click para abrir esta solicitud"></i>
                        </span>
                        <a href="/imprimir_denuncia_ambito_respuesta/${property.uuid}" class="open_solicitud" target="_blank">
                            ${property.denuncia_id}
                        </a>
                    </div>
                    <div>
                        <i aria-hidden="true" class="fa fa-calendar fa-lg bath" title="Fecha de ingreso"></i>
                        <span title="Fecha de ingreso">${property.fecha_ingreso}</span>
                    </div>
                    <div>
                        <i aria-hidden="true" class="fa fa-building fa-lg size" title="Unidad administrativa"></i>
                        <span title="Unidad administrativa">${property.unidad} </span>
                    </div>
                    <div>
                        <i class="fa-solid fa-traffic-light fa-shop fa-lg estatus" title="Estatus"></i>
                        <span title="Estatus">${property.estatus} </span>
                    </div>
                    <div>
                        <i aria-hidden="true" class="fa-solid fa-exclamation-triangle fa-rojo fa-lg dias_vencidos" title="Días vencidos"></i>
                        <span  title="Días vencidos">${property.dias_vencidos} </span>
                    </div>
                </div>
            </div>
        </div>
    `;

}
