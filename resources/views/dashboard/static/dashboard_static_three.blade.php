@extends('layouts.app_statistics_three')
@section('content')
    @slot('file_output',$file_output ?? null)
    @slot('start_date',$start_date ?? '')
    @slot('end_date',$end_date ?? '')
    @slot('rango_de_consulta',$rango_de_consulta ?? '')
    @include('dashboard.static.__static.__dashboard_static_three')
@endsection

