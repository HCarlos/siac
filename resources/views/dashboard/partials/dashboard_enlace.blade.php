@extends('dashboard.dashboard')

@section('container')

    @component('components.dashboard')
        @slot('contenido')
            @include('dashboard.partials.__dashboard.__dashboard_enlace')
        @endslot
    @endcomponent

@endsection

