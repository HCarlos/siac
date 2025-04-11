// Variables globales
let lat = 17.998887170641467;
let lon = -92.94474352674484;

let marcador;
let autocompletar;
const plaza = [{lat:lat, lng:lon}];

let map;

alert(localStorage.apikeymps);


// Inicializar map
function inicializarMapa() {
    // Configuración inicial del map (centrado en Argentina)
    const configuracionInicial = {
        center: plaza[0],
        zoom: 5,
        mapTypeId: 'roadmap',
        mapId: localStorage.apikeymps
    };

    map = new google.maps.Map(document.getElementById('map'), configuracionInicial);

    // Inicializar autocompletado
    const input = document.getElementById('#search_google');
    autocompletar = new google.maps.places.Autocomplete(input, {
        types: ['geocode'],
        componentRestrictions: { country: 'ar' } // Filtro por país (Argentina)
    });
}

// Función principal de búsqueda
function buscarDireccion() {
    const search_google = $('#search_google').val().trim();

    // Validación básica
    if (!search_google) {
        mostrarError('Por favor ingrese una dirección');
        return;
    }

    mostrarCargando(true);
    limpiarResultados();

    // Geocodificación usando Google Maps API
    const geocoder = new google.maps.Geocoder();

    geocoder.geocode({ address: search_google }, (resultados, estado) => {
        mostrarCargando(false);

        if (estado === 'OK' && resultados.length > 0) {
            const mejorResultado = resultados[0];
            mostrarResultados(mejorResultado);
            actualizarMapa(mejorResultado.geometry.location);
        } else {
            mostrarError('No se encontraron resultados para esta dirección');
        }
    });
}

// Mostrar resultados en pantalla
function mostrarResultados(datos) {
    const html = `
                <h3>📌 Dirección encontrada:</h3>
                <p><strong>Dirección completa:</strong> ${datos.formatted_address}</p>
                <p><strong>Tipo de ubicación:</strong> ${traducirTipo(datos.geometry.location_type)}</p>
                <p><strong>Coordenadas:</strong>
                    Lat: ${datos.geometry.location.lat().toFixed(6)},
                    Lng: ${datos.geometry.location.lng().toFixed(6)}
                </p>
            `;

    $('#searchGoogleResult').html(html);
}

// Actualizar el map con nueva ubicación
async function actualizarMapa(ubicacion) {

    if (marcador) {
        marcador.setMap(null);
    }

    const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker",);

    var host = location.protocol.concat("//").concat(window.location.host);
    console.log(host+"/images/z1.png");
    const url = new URL(host+"/images/favicon-512-512.png");
    const pin = new google.maps.marker.PinElement({
        scale: 1.25,
        background: "#edb606",
        borderColor: "#870606",
        glyph: url,

    });

    const marker = new AdvancedMarkerElement({
        map: map,
        position: ubicacion,
        title:  "Arrastre a una nueva posición",
        content: pin.element,
        gmpDraggable: true,
        gmpClickable: true,
    });


    // Centrar y ajustar zoom
    map.setCenter(ubicacion);
    map.setZoom(17);
}

// Función para traducir tipos de ubicación
function traducirTipo(tipo) {
    const tipos = {
        'ROOFTOP': 'Dirección exacta',
        'RANGE_INTERPOLATED': 'Aproximación entre números',
        'GEOMETRIC_CENTER': 'Centro geográfico',
        'APPROXIMATE': 'Aproximación general'
    };
    return tipos[tipo] || tipo;
}

// Manejo de errores
function mostrarError(mensaje) {
    $('#searchGoogleResult').html(`<div class="error">⚠️ ${mensaje}</div>`);
}

// Control de estado de carga
function mostrarCargando(mostrar) {
    $('#cargando').toggle(mostrar);
}

// Limpiar resultados anteriores
function limpiarResultados() {
    $('#searchGoogleResult').empty();
}

// Evento al presionar Enter
$('#search_google').keypress(function(e) {
    if (e.which === 13) {
        buscarDireccion();
    }
});

$("#searchGoogleBtn").click(event => {
    event.preventDefault();
    buscarDireccion();
});

$("#map").show();
