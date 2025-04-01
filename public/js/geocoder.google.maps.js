/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

// The location of Uluru
let lat = 17.998887170641467;
let lon = -92.94474352674484;
let siExiste = false;
let fullScreenControl = false;
// let AdvancedMarkerElement;
// let PinElement;
// let Map;
// let InfoWindow;
let zuum = 5;

if (
    parseFloat($("#latitud").val()) !== 0 &&
    parseFloat($("#longitud").val()) !== 0 &&
    !isNaN(parseFloat($("#latitud").val())) &&
    !isNaN(parseFloat($("#longitud").val()))
) {
    lat = parseFloat($("#latitud").val());
    lon = parseFloat($("#longitud").val());
    siExiste = true;
}

async function initMap(lat, lon, siExiste) {
    $("#searchGoogleError").html('');
    $("#searchGoogleResult").html('');

    let search_google = $('#search_google').val().trim();
    let centro_localidad_id = parseInt($('#centro_localidad_id').val());
    let centro_localidad = $('#centro_localidad').val().trim();

    // Validación básica
    if (!search_google) {
        $("#searchGoogleError").html('Por favor ingrese una dirección').show(100);
        return false;
    }

    if (centro_localidad_id <= 0) {
        $("#searchGoogleError").html('Por favor seleccione una localidad').show(100);
        return false;
    }


    // Request needed libraries.
    //@ts-ignore
    const plaza = [{lat:lat, lng:lon}];
    const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker",);

    // The map, centered at Data
    const configuracionInicial = {
        center: plaza[0],
        zoom: zuum,
        mapTypeId: 'roadmap',
        mapId: localStorage.apikeymps,
        fullscreenControl: fullScreenControl
    };


    const map = new Map(document.getElementById("map"), configuracionInicial);
    const infoWindow = new InfoWindow();

    // alert(siExiste);
    if (!siExiste) {

        let search_custom = search_google.concat(' ', centro_localidad);
        let positionString = search_custom.search('centro')
        if (positionString === -1) {
            search_custom += ' centro';
        }
        positionString = search_custom.search('tabasco')
        if (positionString === -1) {
            search_custom += ' tabasco';
        }

        // alert(search_custom);
        const request = {
            query: search_custom,
            fields: ["name", "formatted_address", "geometry"],
        };

        // service = new google.maps.places.PlacesService(map);
        // service.findPlaceFromQuery(request, (results, status) => {
        //     if (status === google.maps.places.PlacesServiceStatus.OK && results) {
        //         createMarker(results[0], infoWindow, PinElement, AdvancedMarkerElement, map);
        //         map.setCenter(results[0].geometry.location);
        //         geocodePosition(results[0].geometry.location)
        //     }
        // });

        const geocoder = new google.maps.Geocoder();

        geocoder.geocode({ address: search_custom }, (resultados, estado) => {
            // mostrarCargando(false);

            if (estado === 'OK' && resultados.length > 0) {
                const mejorResultado = resultados[0];
                // mostrarResultados(mejorResultado);
                // actualizarMapa(mejorResultado.geometry.location);
                createMarker(mejorResultado, infoWindow, PinElement, AdvancedMarkerElement, map);
                map.setZoom(zuum);
                map.setCenter(mejorResultado.geometry.location);
                geocodePosition(mejorResultado.geometry.location)

            } else {
                // mostrarError('No se encontraron resultados para esta dirección');
                $("#searchGoogleError").html('No se encontraron resultados para esta dirección').show(100);
                return false;
            }
        });



    }else{
        createMarker(plaza[0], infoWindow, PinElement, AdvancedMarkerElement, map);
        geocodePosition(plaza[0])
    }

    function createMarker(place, infoWindow, pinElement, advancedMarkerElement, map) {
        let _Lat = 0.0000;
        let _Lng = 0.0000;
        if (!siExiste){
            if (!place.geometry || !place.geometry.location) return;
            _Lat = place.geometry.location.lat();
            _Lng = place.geometry.location.lng();
        }else{
            _Lat = place.lat;
            _Lng = place.lng;
        }
        var host = location.protocol.concat("//").concat(window.location.host);
        console.log(host+"/images/z1.png");
        const url = new URL(host+"/images/favicon-512-512.png");
        const pin = new google.maps.marker.PinElement({
            scale: 1.25,
            background: "#edb606",
            borderColor: "#870606",
            glyph: url,

        });

        setLatLng(_Lat, _Lng);

        const marker = new advancedMarkerElement({
            map: map,
            position: siExiste ? place : place.geometry.location,
            title:  "Arrastre a una nueva posición",
            content: pin.element,
            gmpDraggable: true,
            gmpClickable: true,
        });

        marker.addListener("click", ({ domEvent, latLng }) => {
            const { target } = domEvent;
            infoWindow.close();
            infoWindow.setContent((marker.title));
            infoWindow.open(marker.map, marker);
            google.maps.event.removeListener();
        });

        marker.addListener("dragend", (event) => {
            setLatLng(marker.position.lat, marker.position.lng)
            geocodePosition(marker.position);
        });

        const centerControlDiv = document.createElement('div');
        const centerControl = createCenterControl(map,marker);
        centerControlDiv.appendChild(centerControl);
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(centerControlDiv);

    }

    function geocodePosition(pos) {
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({latLng: pos},function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                $("#gd_ubicacion").val(results[0].formatted_address);
                $("#searchGoogleResult").html(results[0].formatted_address).show(100);
                $("#search_google").val(results[0].formatted_address)

                const administrativeAreaLevel2 = results[0].address_components.find(component => component.types.includes('administrative_area_level_2'));

                // Si existe, mostrar el nombre
                if (administrativeAreaLevel2) {
                    console.log(administrativeAreaLevel2.long_name);  // Esto debe devolver "Centro"
                } else {
                    console.log('No se encontró un nivel administrativo 2');
                }


            } else {
                $("#searchGoogleError").html('Cannot determine address at this location.' + status).show(100);
            }
        });
    }

    function setLatLng(lat, lng) {
        console.log(lat + ', ' + lng);
        $("#latitud").val(lat);
        $("#longitud").val(lng);
    }


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

document.getElementById("map-container").style.height = "400px"; // Cambiar el tamaño dinámicamente




$("#searchGoogleBtn").click(event => {
    event.preventDefault();
    if ( $("#centro_localidad").val() !== "" ) {
        siExiste = false;
        $("#map").show();
        zuum = 17;
        initMap(lat, lon, siExiste);
    }else {
        $("#map").hide();
    }

    // siExiste = false;
    // $("#map").show();
    //     initMap(lat, lon, siExiste);

});

$("#search_google").change(event => {
    event.preventDefault();
    if ( $("#search_google").val() === "" ) {
        $("#map").hide();
    }
});

// Inicializar autocompletado
document.addEventListener('DOMContentLoaded', () => {


});

async function inicioMap() {
    // Map = await google.maps.importLibrary("maps");
    // InfoWindow = await google.maps.importLibrary("maps");
    //
    // AdvancedMarkerElement = await google.maps.importLibrary("marker",);
    // PinElement = await google.maps.importLibrary("marker",);

}

jQuery(function($) {
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
            }
        });

        const input = document.getElementById('search_google');
        if (input) {
            const center = { lat: lat, lng: lon };
            const defaultBounds = {
                north: center.lat + 0.2,
                south: center.lat - 0.2,
                east: center.lng + 0.2,
                west: center.lng - 0.2,
            };
            const autocompletar = new google.maps.places.Autocomplete(input, {
                types: ['geocode'],
                componentRestrictions: { country: 'mx'},
                bounds: defaultBounds,
                strictBounds: true,
            });
        } else {
            console.error('No se encontró el elemento con id "search_google"');
        }

        if  ( document.getElementById("map") ){
            $("#map").hide();
            if (siExiste){
                $("#map").show();
                zuum = 17;
                initMap(lat, lon, siExiste);
            }
        }

    });
});
