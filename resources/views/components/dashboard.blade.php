<div class="row mt-4">
    {{$contenido}}
</div>

@include('shared.code.__submit_form')

@section("script_autocomplete")
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('/js/servimun.autocomplete.js')}}?time()"></script>

    <script src="{{asset('/js/vendor/jquery-jvectormap-1.2.2.min.js')}}?time()"></script>
    <script src="{{asset('/js/vendor/jquery-jvectormap-world-mill-en.js')}}?time()"></script>
    <script src="{{asset('/js/pages/demo.dashboard.js')}}?time()"></script>

@endsection

