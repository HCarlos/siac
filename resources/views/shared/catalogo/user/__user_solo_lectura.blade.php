<div class="form-group row mb-3">
    <label for = "username" class="col-md-3 col-form-label">Username</label>
    <div class="col-md-9">
        <input type="text" name="username" id="username" value="{{ old('username',$items->username) }}" class="form-control" readonly />
    </div>
    <label for = "email" class="col-md-3 col-form-label">Email</label>
    <div class="col-md-6">
        <input type="email" name="email" id="email" value="{{ old('email',$items->email) }}" class="form-control" readonly />
    </div>
    <div class="col-md-3">
        @if ($items->isVerifyMail())
            <small class="float-right "><i class="fas fa-check text-success"></i> Verificado<br>{{$items->email_verified_at}}</small>
        @else
            <a  class="float-right pt-2 pl-3" href="{{ route('verificarEmailAhora') }}">Verificar ahora</a>
            <strong class="float-right pt-2"><i class="mdi mdi-cancel text-danger"></i>  No Verificado</strong>
            <small>Si decide Verifricar su correo ahora, checque su bandeja de entrada y correo no deseado. Siga las instrucciones.</small>
        @endif
    </div>
    <label for = "curp" class="col-md-3 col-form-label">CURP</label>
    <div class="col-md-9">
        <input type="curp" name="curp" id="curp" value="{{ old('curp',$items->curp) }}" class="form-control" readonly />
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "ap_paterno" class="col-md-3 col-form-label">Paterno</label>
    <div class="col-md-9">
        <input type="text" name="ap_paterno" id="ap_paterno" value="{{ old('ap_paterno',$items->ap_paterno) }}" class="form-control" readonly/>
    </div>
    <label for = "ap_materno" class="col-md-3 col-form-label">Materno</label>
    <div class="col-md-9">
        <input type="text" name="ap_materno" id="ap_materno" value="{{ old('ap_materno',$items->ap_materno) }}" class="form-control" readonly/>
    </div>
    <label for = "nombre" class="col-md-3 col-form-label">Nombre</label>
    <div class="col-md-9">
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre',$items->nombre) }}" class="form-control" readonly/>
    </div>
</div>

<div class="form-group row mb-3">
    <label for = "emails" class="col-md-3 col-form-label">Emails</label>
    <div class="col-md-9">
        <input type="text" name="emails" id="emails" value="{{ old('emails',$items->emails) }}" class="form-control" readonly/>
    </div>
    <label for = "celulares" class="col-md-3 col-form-label">Celulares</label>
    <div class="col-md-9">
        <input type="text" name="celulares" id="celulares" value="{{ old('celulares',$items->celulares) }}" class="form-control" readonly/>
    </div>
    <label for = "telefonos" class="col-md-3 col-form-label">Teléfonos</label>
    <div class="col-md-9">
        <input type="text" name="telefonos" id="telefonos" value="{{ old('telefonos',$items->telefonos) }}" class="form-control" readonly/>
    </div>
</div>

<hr>
