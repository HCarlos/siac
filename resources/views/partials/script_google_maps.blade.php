@section("google_maps")
<script src="/js/scannerjs/scanner.js" type="text/javascript"></script>
<script src="/js/scanner.solicitud.js" type="text/javascript"></script>

<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Incluir API de Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUl6Jk2_5yVYdnwidOuU9c8_ZBk7gGnfo&libraries=places&callback=inicioMap"
        async defer></script>
<script >
    localStorage.apikeymps = "AIzaSyBUl6Jk2_5yVYdnwidOuU9c8_ZBk7gGnfo";
</script>

<script src="/js/geocoder.google.maps.js"></script>

@endSection
