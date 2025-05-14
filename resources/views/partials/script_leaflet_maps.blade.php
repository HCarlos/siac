@section("styles_maps")

    <!-- Leaflet CSS -->
{{--    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"--}}
{{--          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="--}}
{{--          crossorigin=""/>--}}

    <!-- Leaflet-geosearch CSS -->
{{--    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.6.0/dist/geosearch.css"/>--}}


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="eY0ng0Q13GxiRIxUEkErJxEHwy5qAzQgjIBXiYZ9gRU="
          crossorigin=""/>


    <style>


        #autocomplete-results {
            position: relative; /* Cambiado de relative a absolute */
            top: 100%; /* Para que aparezca justo debajo del input */
            left: 0;
            right: 0;
            background-color: white;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 0 0 5px 5px;
            list-style: none;
            padding: 0;
            margin: 0;
            z-index: 10000; /* Asegúrate de que sea un valor alto */
            display: none; /* Oculto por defecto */
        }

        #autocomplete-results li {
            padding: 5px;
            cursor: pointer;
            font-size: 12px;
            color: #0c67d6;
        }

        #autocomplete-results li:hover {
            background-color: #f0f0f0;
        }

    </style>
@endsection

@section("google_maps")
<script src="/js/scannerjs/scanner.js" type="text/javascript"></script>
<script src="/js/scanner.solicitud.js" type="text/javascript"></script>

<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Leaflet JS -->
{{--<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"--}}
{{--        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="--}}
{{--        crossorigin=""></script>--}}


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="20vVSrrTNUcyGjfyKzc4CvNH9RmQl2x+iJ6yiJZYZ6g="
        crossorigin=""></script>

<!-- Leaflet-geosearch JS -->
{{--<script src="https://unpkg.com/leaflet-geosearch@3.6.0/dist/geosearch.umd.js"></script>--}}

<script src="/js/geocoder.leaflet.maps.js"></script>

@endSection
