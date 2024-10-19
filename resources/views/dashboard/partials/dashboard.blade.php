@extends('dashboard')

@section('container')

    @component('components.dashboard')
        @slot('contenido')
            @include('dashboard.partials.__dashboard.__dashboard')
        @endslot
    @endcomponent

@endsection

