

    let lat = 17.998887170641467;
    let lon = -92.94474352674484;
    let siExiste = false;
    let fullScreenControl = false;
    let zuum = 17;

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

    document.getElementById("map-container").style.height = "400px"; // Cambiar el tamaño dinámicamente


// Inicialización del mapa

    document.addEventListener('DOMContentLoaded', () => {



        $("#searchGoogleError").html('');
        $("#searchGoogleResult").html('');

        let search_google = $('#search_google').val().trim();
        let centro_localidad_id = parseInt($('#centro_localidad_id').val());
        let centro_localidad = $('#centro_localidad').val().trim();

        // if (centro_localidad_id <= 0) {
        //     $("#searchGoogleError").html('Por favor seleccione una localidad').show(100);
        //     return false;
        // }

        if (siExiste) {

            lat = parseFloat($("#latitud").val());
            lon = parseFloat($("#longitud").val());

        }

        const map = L.map('map',{
            preferCanvas: true,
            tap: false,
            zoomControl: true
        }).setView([lat, lon], zuum); // Coordenadas iniciales: Villahermosa, zoom 10

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            subdomains: 'abc',
            updateWhenIdle: true,
            maxZoom: 20,
            minZoom: 10
        }).addTo(map);

        let marker = L.marker([lat, lon], { draggable: true }).addTo(map); // Misma ubicación inicial

        reverseGeocode(marker.getLatLng());

        marker.on('dragend', (event) => {
            const newLatLng = event.target.getLatLng();
            reverseGeocode(newLatLng);
        });


        const searchInput = document.getElementById('search_google');
        const autocompleteResults = document.getElementById('autocomplete-results');
        const locationInfoDiv = document.getElementById('searchGoogleResult');
        const searchGoogleError = document.getElementById('searchGoogleError');


        async function geocode(query) {
            // Coordenadas precisas para Tabasco: [min_lon, min_lat, max_lon, max_lat]
            const tabascoBounds = [-94.2, 16.9, -90.5, 19.0];
            const apiUrl = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=jsonv2&accept-language=es&viewbox=${tabascoBounds.join(',')}&bounded=1`;
            try {
                const response = await fetch(apiUrl);
                const data = await response.json();
                return data;
            } catch (error) {
                // console.error("Error en el geocoding:", error);
                searchGoogleError.textContent = `Error en el geocoding: ${error}`;
                return [];
            }
        }

// Función para mostrar los resultados del autocompletado
        function displayAutocompleteResults(results) {
            autocompleteResults.innerHTML = '';
            if (results.length > 0) {
                autocompleteResults.style.display = 'block';
                results.forEach(result => {
                    const li = document.createElement('li');
                    li.textContent = result.display_name;
                    li.addEventListener('click', () => {
                        // searchInput.value = result.display_name;
                        map.setView([parseFloat(result.lat), parseFloat(result.lon)], zuum);
                        placeMarker([parseFloat(result.lat), parseFloat(result.lon)], result.display_name);
                        autocompleteResults.innerHTML = '';
                        autocompleteResults.style.display = 'none';
                    });
                    autocompleteResults.appendChild(li);
                });
            } else {
                autocompleteResults.style.display = 'none';
            }
        }

        let autocompleteTimeout;
        searchInput.addEventListener('input', () => {
            buscarUbicacion();
        });

        function buscarUbicacion() {
            const query = getQuery(); // Obtener el valor actual del campo de entrada $("#search_google").val();

            if (query.length >= 3) {
                clearTimeout(autocompleteTimeout);
                autocompleteTimeout = setTimeout(async () => {
                    const results = await geocode(query);
                    displayAutocompleteResults(results.slice(0, 5)); // Mostrar los 5 primeros resultados
                }, 300); // Esperar 300ms después de que el usuario deje de escribir
            } else {
                autocompleteResults.style.display = 'none';
                autocompleteResults.innerHTML = '';
            }

        }

        function placeMarker(latlng, address) {
            if (marker) {
                marker.setLatLng(latlng);
                setLatLng(latlng.lat, latlng.lng);
            } else {
                marker = L.marker(latlng, { draggable: true }).addTo(map);
                setLatLng(latlng.lat, latlng.lng);
                marker.on('dragend', (event) => {
                    const newLatLng = event.target.getLatLng();
                    reverseGeocode(newLatLng);
                });
            }
            // locationInfoDiv.textContent = address ? `Ubicación seleccionada: ${address} (${latlng.lat.toFixed(6)}, ${latlng.lng.toFixed(6)})` : `Nueva ubicación (${latlng.lat.toFixed(6)}, ${latlng.lng.toFixed(6)})`;
        }

        async function reverseGeocode(latlng) {
            const apiUrl = `https://nominatim.openstreetmap.org/reverse?lat=${latlng.lat}&lon=${latlng.lng}&format=jsonv2&accept-language=es`;
            try {
                const response = await fetch(apiUrl);
                const data = await response.json();
                if (data && data.display_name) {
                    // locationInfoDiv.textContent = `Ubicación seleccionada: ${data.display_name} (${latlng.lat.toFixed(6)}, ${latlng.lng.toFixed(6)})`;
                    $("#gd_ubicacion").val( data.display_name );
                    $("#searchGoogleResult").html(data.display_name).show(100);
                    setLatLng(latlng.lat, latlng.lng);
                } else {
                    // locationInfoDiv.textContent = `Ubicación (${latlng.lat.toFixed(6)}, ${latlng.lng.toFixed(6)}) - No se encontró dirección detallada`;
                }
            } catch (error) {
                // console.error("Error en el reverse geocoding:", error);
                searchGoogleError.textContent = `Error en el reverse geocoding: ${error}`;
                // locationInfoDiv.textContent = `Ubicación (${latlng.lat.toFixed(6)}, ${latlng.lng.toFixed(6)}) - Error al obtener la dirección`;
            }
        }

         function getQuery() {
            let search_google = $('#search_google').val().trim();
            let centro_localidad_id = parseInt($('#centro_localidad_id').val());
            let centro_localidad = $('#centro_localidad').val().trim().toLowerCase();

            let search_custom = search_google.concat(' ', centro_localidad);
            let positionString = search_custom.search('centro')
            if (positionString === -1) {
                search_custom += ' centro';
            }
            positionString = search_custom.search('tabasco')
            if (positionString === -1) {
                search_custom += ' tabasco';
            }

            return search_custom;

        }

        function setLatLng(lat, lng) {
            console.log(lat + ', ' + lng);
            $("#latitud").val(lat);
            $("#longitud").val(lng);
        }

        async function initMap(lat, lon, siExiste) {

            // if (!siExiste) {
                buscarUbicacion();
            // }

        // alert("FIN de geocoder.leaflet.maps.js");


        }

    $("#searchGoogleBtn").click(event => {
        event.preventDefault();
        if ( $("#centro_localidad").val() !== "" ) {
            siExiste = false;
            $("#map").show();
            zuum = 17;
            initMap(lat, lon, siExiste).then(r => {
                console.log("VALOR DE R " + r);
            });
        }else {
            // $("#map").hide();
        }

    });

    $("#search_google").change(event => {
        event.preventDefault();
        if ( $("#search_google").val() === "" ) {
            // $("#map").hide();
        }
    });

        initMap(lat, lon, siExiste).then(r => {
            console.log("VALOR DE R " + r);
        });


    });
