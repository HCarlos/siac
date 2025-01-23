let map;
let isCollapsed = true;
let lat = 17.9919;
let lon = -92.9303;

// Inicializar el mapa
async function initMap(dataSet) {

    const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker",);
    const infoWindow = new InfoWindow();

    map = new Map(document.getElementById("map"), {
        center: { lat: 17.9869, lng: -92.9303 }, // Coordenadas de Villahermosa (modifícalas según sea necesario)
        zoom: 15,
        mapId: localStorage.apikeymps,
    });

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
    }


/*
    const url = new URL("https://refugios.villahermosa.gob.mx:445/images/z1.png");
    const pin = new PinElement({
        scale: 1.25,
        background: "#F7D32F",
        glyph: url,

    });


    // Crear marcadores personalizados
    dataSet.forEach((dataSet) => {

        const icon = document.createElement("div");
        icon.innerHTML = '<i class="fa fa-map-marker fa-lg text-danger"></i>';

        const pin = new PinElement({
            scale: 1.25,
            background: dataSet.color,
            borderColor: "#FFFFFF",
            glyphColor: "white",
            glyph: icon,

        });

        let srcHtml = "<b>Solicitud:</b> "+dataSet.denuncia+"<br>"+
                             "<b>Solicitante:</b> "+dataSet.ciudadano+"<br>"+
                             "<b>Unidad:</b> "+dataSet.unidad+"<br>"+
                             "<b>Servicio:</b> "+dataSet.servicio+"<br>"+
                             "<b>Último estatus:</b> "+dataSet.ultimo_estatus+"<br>"+
                             "<b>Fecha de Ingreso:</b> "+dataSet.fecha_ingreso+"<br>"+
                             "<b>Fecha de Ejecución Mínima:</b> "+dataSet.fecha_ejecucion_minima+"<br>"+
                             "<b>Fecha de Ejecución Máxima:</b> "+dataSet.fecha_ejecucion_maxima+"<br>"+
                             "<b>Id:</b> "+dataSet.denuncia_id;

        const marker = new AdvancedMarkerElement({
            map: map,
            position: { lat: dataSet.lat, lng: dataSet.lng },
            title:  srcHtml,
            content: pin.element,
            gmpClickable: true,
            gmpDraggable: false,
        });

        marker.addListener("click", ({ domEvent, latLng }) => {
            const { target } = domEvent;
            infoWindow.close();
            infoWindow.setContent(marker.title);
            infoWindow.open(marker.map, marker);
        });

    });
*/

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
    // <i aria-hidden="true" className="fs fs--solid fs--${property.icon} text-white" title="${property.icon}"></i>

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
                <a href="/editDenunciaAmbito/${property.denuncia_id}" class="open_solicitud" title="Haga click para abrir esta solicitud">
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
                <i aria-hidden="true" class="fa-solid fa-exclamation-triangle fa-rojo fa-lg dias_vencidos" title="Díías vencidos"></i>
                <span class="fa-sr-only" title="Días vencidos">dias_vencidos</span>
                <span  title="Días vencidos">${property.dias_vencidos} </span>
            </div>
        </div>
    </div>
    `;
    return content;


    /*
        <div className="features">
            <div>
                <i aria-hidden="true" className="fa fa-bed fa-lg bed" title="bedroom"></i>
                <span className="fa-sr-only">bedroom</span>
                <span>${property.bed}</span>
            </div>
            <div>
                <i aria-hidden="true" className="fa fa-bath fa-lg bath" title="bathroom"></i>
                <span className="fa-sr-only">bathroom</span>
                <span>${property.bath}</span>
            </div>
            <div>
                <i aria-hidden="true" className="fa fa-ruler fa-lg size" title="size"></i>
                <span className="fa-sr-only">size</span>
                <span>${property.size} ft<sup>2</sup></span>
            </div>
        </div>
    */

}
