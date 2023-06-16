@extends('layouts.app')

@section('content')

@section('styles')
    <link href="{{ asset('css/servimun.css') }}" rel="stylesheet"  type="text/css">
@endsection

<div class="full-height content-full bg-ciudad">

    <div class="container bg-ciudad ">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="m-2 text-center ">
                    <a href="/login" >
                        <span><img src="{{ asset('/images/web/logo-1.png') }} " alt=""></span>
                    </a>
                </div>
                <div class="card">
                    <div class="card-header">Verifica tu email</div>
                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                Se ha enviado un correo de restauración de cuenta.
                            </div>
                        @endif
                        Antes de continuar, por favor, valida tu dirección de correo electrónico en el siguiente link:<br><br>
                        Si no has recibido el correo, <a href="{{ route('verification.resend') }}">haz click aquí para enviarlo de nuevo.</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
