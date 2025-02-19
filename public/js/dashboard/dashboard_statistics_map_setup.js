let map;
let isCollapsed = true;
let lat = 17.9919;
let lon = -92.9303;
let fullScreenControl = false;

// Inicializar el mapa
async function initMap(dataSet) {

    const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker",);
    const infoWindow = new InfoWindow();

    map = new Map(document.getElementById("map"), {
        center: { lat: 17.9869, lng: -92.9303 }, // Coordenadas de Villahermosa (modifícalas según sea necesario)
        zoom: 15,
        mapId: localStorage.apikeymps,
        fullscreenControl: fullScreenControl
    });

    let marker = null;
    for (const property of dataSet) {
        const Marker = new AdvancedMarkerElement({
            map,
            content: buildContent(property),
            position: property.position,
            title: property.description,
        });

        Marker.addListener("click", () => {
            toggleHighlight(Marker, property);
        });

        marker = Marker;

    }

    const centerControlDiv = document.createElement('div');
    const centerControl = createCenterControl(map,marker);
    centerControlDiv.appendChild(centerControl);
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(centerControlDiv);

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

function buildContent(property) {
    const content = document.createElement("div");

    content.classList.add("property");

    content.innerHTML = `
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
    `;
    return content;

}

function createCenterControl(map, marker) {
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
    controlButton.title = 'Haga click para expandir el mapa';
    controlButton.type = 'button';

    // Setup the click event listeners: simply set the map to Chicago.
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
            controlButton.title = 'Haga click para reducir el mapa';
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
            controlButton.title = 'Haga click para expandir el mapa';
        }

        // Obtén el título del botón
        console.log(`Título actual del botón: ${controlButton.title}`);

        fullScreenControl = !fullScreenControl;
        console.log(fullScreenControl);

    });

    return controlButton;
}
