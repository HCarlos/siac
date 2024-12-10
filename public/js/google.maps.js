/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

// The location of Uluru
let lat = 17.998887170641467;
let lon = -92.94474352674484;
let siExiste = false;

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

    // Request needed libraries.
    //@ts-ignore
    const plaza = [{lat:lat, lng:lon}];
    const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker",);
    // The map, centered at Data
    const map = new Map(document.getElementById("map"), {
        zoom: 18.5,
        center: plaza[0],
        mapId: localStorage.apikeymps,
    });

    const infoWindow = new InfoWindow();

    if (!siExiste) {

        let search_google = document.getElementById("search_google").value;
        let positionString = search_google.search('centro')
        if (positionString === -1) {
            search_google += ' centro';
        }
        positionString = search_google.search('tabasco')
        if (positionString === -1) {
            search_google += ' tabasco';
        }


        const request = {
            query: search_google,
            fields: ["name", "formatted_address", "geometry"],
        };

    // , "formatted_address"

        // alert(request.query);

        service = new google.maps.places.PlacesService(map);
        service.findPlaceFromQuery(request, (results, status) => {
            if (status === google.maps.places.PlacesServiceStatus.OK && results) {
//      for (let i = 0; i < results.length; i++) {
                createMarker(results[0], infoWindow, PinElement, AdvancedMarkerElement, map);
//      }
                map.setCenter(results[0].geometry.location);
                geocodePosition(results[0].geometry.location)
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

        const url = new URL("https://refugios.villahermosa.gob.mx:445/images/z1.png");
        const pin = new google.maps.marker.PinElement({
            scale: 1.25,
            background: "#F7D32F",
            glyph: url,

        });

        setLatLng(_Lat, _Lng);

        const marker = new advancedMarkerElement({
            map: map,
            position: siExiste ? place : place.geometry.location,
            title:  "Arrastre a una nueva posición",
            content: pin.element,
            gmpClickable: true,
            gmpDraggable: true,
        });

        marker.addListener("click", ({ domEvent, latLng }) => {
            const { target } = domEvent;
            infoWindow.close();
            infoWindow.setContent((marker.title));
            infoWindow.open(marker.map, marker);

            google.maps.event.removeListener();
        });

        google.maps.event.addListener(marker, "dragend", () => {
            setLatLng(marker.position.lat, marker.position.lng)
            geocodePosition(marker.position);
            google.maps.event.removeListener();
        });

    }

    function geocodePosition(pos) {
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({latLng: pos},function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                $("#gd_ubicacion").val(results[0].formatted_address);
                $("#searchGoogleResult").html(results[0].formatted_address).show(100);

                // $("#g_calle").val(results[1].formatted_address ?? "");
                // $("#g_num_ext").val(results[0].formatted_address ?? "");
                // $("#g_num_int").val("");
                // $("#g_colonia").val(results[2].formatted_address ?? "");
                // $("#g_comunidad").val(results[3].formatted_address ?? "");
                // $("#g_municipio").val(results[4].formatted_address ?? "");
                // $("#g_estado").val(results[6].formatted_address ?? "");
                // $("#g_cp").val(results[6].formatted_address ?? "");

                // console.log(results[0].address_components[6]["long_name"]);

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


if  ( document.getElementById("map") ){
    $("#map").hide();
    if (siExiste){
        $("#map").show();
        initMap(lat, lon, siExiste)
    }
}

$("#searchGoogleBtn").click(event => {
    event.preventDefault();
    if ( $("#search_google").val() !== "" ) {
        $("#map").show();
        initMap(lat, lon, siExiste);
    }else {
        $("#map").hide();
    }
});

$("#search_google").change(event => {
    event.preventDefault();
    if ( $("#search_google").val() === "" ) {
        $("#map").hide();
    }
});
