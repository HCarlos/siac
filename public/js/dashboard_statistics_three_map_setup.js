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

// Con OpenStreetMap

// {{--    <link--}}
//     {{--        rel="stylesheet"--}}
//     {{--        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"--}}
//     {{--        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="--}}
//     {{--        crossorigin=""--}}
//     {{--    />--}}
//     {{--    <script--}}
//     {{--        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"--}}
//     {{--        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="--}}
//     {{--        crossorigin=""--}}
//     {{--    ></script>--}}


// let isCollapsed = true; // Estado inicial de colapso
// const map = L.map('map').setView([17.9869, -92.9303], 12); // Coordenadas de Villahermosa, Tabasco
// L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
// }).addTo(map);
// const marker = L.marker([17.9869, -92.9303]).addTo(map);
// marker.bindPopup('<b>Villahermosa</b><br>Marcador de ejemplo');
// let isExpanded = false;
// document.getElementById('toggle-map').addEventListener('click', () => {
//     const mapContainer = document.getElementById('map-container');
//     isExpanded = !isExpanded;
//     if (isExpanded) {
//         mapContainer.classList.add('expanded'); // Expande a pantalla completa
//         document.getElementById('toggle-map').innerText = 'Contraer';
//     } else {
//         mapContainer.classList.remove('expanded'); // Contrae al tamaño original
//         document.getElementById('toggle-map').innerText = 'Expandir';
//     }
//     map.invalidateSize(); // Ajustar el tamaño del mapa al contenedor
// });
