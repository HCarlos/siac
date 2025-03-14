let map = null;
let isCollapsed = true;
let fullScreenControl = false;

// initMap_leafletel map
function initMap(dataSet,lat,lon) {

    if (map instanceof L.Map) map.remove();
    map = null;

    map = L.map('map', {
        fullscreenControl: true,
        fullscreenControlOptions: {
            forceSeparateButton: true,
            position: 'topright',
            title: 'Ver mapa en pantalla completa',
            titleCancel: 'Salir de pantalla completa'
        }
    }).setView([lat, lon], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    map.isFullscreen() // Is the map fullscreen?

    map.on('fullscreenchange', function () {

        if (map.isFullscreen()) {
            console.log('entered fullscreen');
        } else {
            console.log('exited fullscreen');
        }

        setTimeout(() => {
            map.invalidateSize();
        }, 200);
    });

    L.control.scale().addTo(map);

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
async function initMapinitMap_mapbox(dataSet) {
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
    }).addControl(new mapboxgl.FullscreenControl())
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
        const popup = new mapboxgl.Popup({ closeButton: true, className: 'highlight' })
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
