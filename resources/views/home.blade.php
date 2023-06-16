@extends('layouts.app')

@section('content')

{{--@section('styles')--}}
{{--    <link href="{{ asset('css/servimun.css') }}" rel="stylesheet"  type="text/css">--}}
{{--@endsection--}}

<body>
    <div class="wrapper">
        @include('partials/left-sidebar')
        <div class="content-page">
            <div class="content">
                @include('partials/topbar')
                <div class="container-fluid home">
                    @yield('container')
                </div>
                <!-- container -->
            </div>
        </div>
            <!-- content -->
        @include('partials/footer')
    </div>

@include('partials.full_modal')
@include('partials/script_footer')

</body>

@endsection
