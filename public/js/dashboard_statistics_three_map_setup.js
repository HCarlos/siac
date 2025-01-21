let map;
let isCollapsed = true;
let lat = 17.9919;
let lon = -92.9303;

// Inicializar el mapa
async function initMap(dataSet) {

    const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker",);
    const infoWindow = new InfoWindow();

    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 17.9869, lng: -92.9303 }, // Coordenadas de Villahermosa (modifícalas según sea necesario)
        zoom: 15,
        mapId: localStorage.apikeymps,
    });

    const url = new URL("https://refugios.villahermosa.gob.mx:445/images/z1.png");
    const pin = new google.maps.marker.PinElement({
        scale: 1.25,
        background: "#F7D32F",
        glyph: url,

    });


    // Crear marcadores personalizados
    dataSet.forEach((dataSet) => {

        const icon = document.createElement("div");
        icon.innerHTML = '<i class="fa fa-map-marker fa-lg"></i>';

        const pin = new google.maps.marker.PinElement({
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

        const marker = new google.maps.marker.AdvancedMarkerElement({
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

}

