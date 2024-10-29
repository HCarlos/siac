<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=yes">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<meta name="Access-Control-Allow-Origin" content="*" />--}}
    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('images/favicon/favicon.png') }}" rel="shortcut icon">
    <link href="{{ asset('images/favicon/favicon-32-32.png') }}" rel="shortcut icon" sizes="32x32">
    <link href="{{ asset('images/favicon/favicon-114-114.png') }}" rel="apple-touch-icon" sizes="114x114">
    <link href="{{ asset('images/favicon/favicon-157-157.png') }}" rel="apple-touch-icon" sizes="157x157">
    <link href="{{ asset('images/favicon/favicon-180-180.png') }}" rel="apple-touch-icon" sizes="180x180">
    <link href="{{ asset('images/favicon/favicon-192-192.png') }}" rel="apple-touch-icon" sizes="192x192">
    <link href="{{ asset('images/favicon/favicon-270-270.png') }}" rel="apple-touch-icon" sizes="270x270">

    <link href="https://fonts.googleapis.com/css?family=Raleway|PT+Sans+Narrow|Roboto:400,400i,500,500i|Roboto+Mono|Roboto+Condensed|Kaushan+Script&effect=3d-float" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous"><!-- third party css -->
    <link href="{{ asset('css/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.css' )}}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.dataTables.css') }}" rel="stylesheet">


    <link href="{{ asset('css/ace-themes.css') }}?timestamp()" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/basic.css') }}" rel="stylesheet">

    <link href="{{ asset('css/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select.bootstrap4.css') }}" rel="stylesheet">

    <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.toast.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

    <link href="{{ asset('css/ace-fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ace.css') }}?timestamp()" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/atemun.css') }}?timestamp()" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/servimun.css') }}?timestamp()" rel="stylesheet" type="text/css"/>


{{--    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUl6Jk2_5yVYdnwidOuU9c8_ZBk7gGnfo&callback=console.debug&libraries=maps,marker&v=beta"></script>--}}

    <script>
        window.Promise ||
        document.write(
            '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>'
        )
        window.Promise ||
        document.write(
            '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>'
        )
        window.Promise ||
        document.write(
            '<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
        )

        var _seed = 42;
        Math.random = function() {
            _seed = _seed * 16807 % 2147483647;
            return (_seed - 1) / 2147483646;
        };

        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "AIzaSyBUl6Jk2_5yVYdnwidOuU9c8_ZBk7gGnfo", v: "beta"});

    </script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/ace.js') }}"></script>
    <link href="{{ asset('js/bootstrap.js') }}" rel="stylesheet">

    <script src="{{asset('js/app.min.js')}}"></script>
    <script src="{{asset('js/fontawesome.min.js')}}"></script>
    <script src="{{asset('js/bootbox.min.js')}}"></script>

    <script src="{{asset('js/bootbox.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-dialog.js')}}"></script>
    <script src="{{asset('js/chart.bundle.min.js')}}"></script>

    <script src="{{asset('js/component.dragula.js')}}"></script>

    <script src="{{asset('js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/jquery-jvectormap.min.js')}}"></script>
    <script src="{{asset('js/jquery-jvectormap-world-mill-en.js')}}"></script>

    <script src="{{asset('js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/jquery.toast.min.js')}}"></script>

    <script src="{{ asset('js/statistics.js') }}?timestamp()" rel="stylesheet" type="text/css"></script>

</head>
<body>

    @yield('content')

</body>
</html>
