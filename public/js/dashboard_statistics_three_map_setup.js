let map;
let isCollapsed = true;
let lat = 17.9919;
let lon = -92.9303;

// Inicializar el mapa
async function initMap(dataSet) {

    // const plaza = [{lat:lat, lng:lon}];
    // const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    // const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker",);
    // // The map, centered at Data
    // const map = new Map(document.getElementById("map"), {
    //     zoom: 15,
    //     center: plaza[0],
    //     mapId: localStorage.apikeymps,
    // });
    //

    const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker",);
    const infoWindow = new InfoWindow();

    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 17.9869, lng: -92.9303 }, // Coordenadas de Villahermosa (modifícalas según sea necesario)
        zoom: 15,
        mapId: localStorage.apikeymps,
    });

    // alert(map.toString());


    // Agregar marcadores en diferentes zonas
    // const locations = [
    //     { lat: 17.9889, lng: -92.9283, color: "red" }, // Zona 1
    //     { lat: 17.9919, lng: -92.9303, color: "orange" }, // Zona 2
    //     { lat: 17.9879, lng: -92.9313, color: "green" }, // Zona 3
    // ];

    const url = new URL("https://refugios.villahermosa.gob.mx:445/images/z1.png");
    const pin = new google.maps.marker.PinElement({
        scale: 1.25,
        background: "#F7D32F",
        glyph: url,

    });


    // Crear marcadores personalizados
    dataSet.forEach((dataSet) => {

        // const pin = new google.maps.marker.PinElement({
        //     scale: 1.25,
        //     background: location.color,
        //     glyph: url,
        //
        // });
        // new google.maps.Marker({
        //     position: { lat: location.lat, lng: location.lng },
        //     map: map,
        //     icon: {
        //         path: pin.element,
        //         fillColor: location.color,
        //         fillOpacity: 1,
        //         strokeWeight: 0,
        //         scale: 8,
        //     },
        // });

        const icon = document.createElement("div");
        icon.innerHTML = '<i class="fa fa-map-marker fa-lg"></i>';

        const pin = new google.maps.marker.PinElement({
            scale: 1.25,
            background: dataSet.color,
            borderColor: "#FFFFFF",
            glyphColor: "white",
            glyph: icon,

        });
        const marker = new google.maps.marker.AdvancedMarkerElement({
            map: map,
            position: { lat: dataSet.lat, lng: dataSet.lng },
            title:  "Arrastre a una nueva posición",
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

    // alert("Mapa inicializado - locations.forEach");

}

// Alternar el tamaño del mapa (expandir/contraer)
// document.getElementById("toggle-map").addEventListener("click", () => {
//     const mapContainer = document.querySelector(".container");
//     isCollapsed = !isCollapsed;
//
//     if (isCollapsed) {
//         mapContainer.classList.add("collapsed");
//         document.getElementById("toggle-map").innerText = "Expandir";
//     } else {
//         mapContainer.classList.remove("collapsed");
//         document.getElementById("toggle-map").innerText = "Contraer";
//     }
// });
//
