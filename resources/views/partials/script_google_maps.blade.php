@section("google_maps")
<script src="/js/scannerjs/scanner.js" type="text/javascript"></script>
<script src="/js/scanner.solicitud.js" type="text/javascript"></script>


{{--<script>--}}
{{--    (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({--}}
{{--        key: "{{ env('GOOGLE_MAPS_KEY') }}",--}}
{{--        v: "beta",--}}
{{--        // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).--}}
{{--        // Add other bootstrap parameters as needed, using camel case.--}}
{{--    });--}}
{{--    localStorage.apikeymps = "{{ env('GOOGLE_MAPS_KEY') }}";--}}
{{--</script>--}}
{{--<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&libraries=places"> </script>--}}
{{--<script src="/js/google.maps.js"></script>--}}


<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Incluir API de Google Maps -->

{{--<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap" async defer></script>--}}

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&libraries=places&callback=inicioMap"
        async defer></script>
<script >
    localStorage.apikeymps = "{{ env('GOOGLE_MAPS_KEY') }}";
</script>

<script src="/js/geocoder.google.maps.js"></script>




@endSection
