@extends('layouts.app')

@section('content')

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
