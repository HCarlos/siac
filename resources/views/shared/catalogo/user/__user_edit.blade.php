
<h4 class="header-title mb-3">{{ $items->FullName }}</h4>

<ul class="nav nav-pills bg-light nav-justified mb-3">
    <li class="nav-item">
        <a href="#Profile1" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active show">
            <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
            <span class="d-none d-lg-block">Perfil</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#Domicilio1" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
            <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
            <span class="d-none d-lg-block">Domicilio</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#Ocupaciion1" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
            <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
            <span class="d-none d-lg-block">Ocupación</span>
        </a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane active show" id="Profile1">

        <div class="form-group row mb-3">
            <label for = "email" class="col-md-3 col-form-label">Email</label>
            <div class="col-md-6">
                <input type="email" name="email" id="email" value="{{ old('email',$items->email) }}" class="form-control" @if ($items->isVerifyMail()) disabled @endif  />
            </div>
            <div class="col-md-3">
                @if ($items->isVerifyMail())
                    <small class="float-right "><i class="fas fa-check text-success"></i> Verificado<br>{{$items->email_verified_at}}</small>
                @else
                    <a  class="float-right pt-2 pl-3" href="{{ route('verificarEmailAhoraForAdmin',['id'=>$items->id]) }}">Verificar ahora</a>
                    <strong class="float-right pt-2"><i class="mdi mdi-cancel text-danger"></i>  No Verificado</strong>
                    <small>Si decide Verifricar su correo ahora, checque su bandeja de entrada y correo no deseado. Siga las instrucciones.</small>
                @endif
            </div>

            <label for = "curp" class="col-md-3 col-form-label">CURP</label>
            <div class="col-md-9">
                <input type="text" name="curp" id="curp" value="{{ old('curp',$items->curp) }}" class="form-control"  />
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for = "ap_paterno" class="col-md-3 col-form-label">Paterno</label>
            <div class="col-md-9">
                <input type="text" name="ap_paterno" id="ap_paterno" value="{{ old('ap_paterno',$items->ap_paterno) }}" class="form-control" />
            </div>
            <label for = "ap_materno" class="col-md-3 col-form-label">Materno</label>
            <div class="col-md-9">
                <input type="text" name="ap_materno" id="ap_materno" value="{{ old('ap_materno',$items->ap_materno) }}" class="form-control" />
            </div>
            <label for = "nombre" class="col-md-3 col-form-label">Nombre</label>
            <div class="col-md-9">
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre',$items->nombre) }}" class="form-control" />
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for = "emails" class="col-md-3 col-form-label">Emails</label>
            <div class="col-md-9">
                <input type="text" name="emails" id="emails" value="{{ old('emails',$items->emails) }}" class="form-control" />
            </div>
            <label for = "celulares" class="col-md-3 col-form-label">Celulares</label>
            <div class="col-md-9">
                <input type="text" name="celulares" id="celulares" value="{{ old('celulares',$items->celulares) }}" class="form-control" />
            </div>
            <label for = "telefonos" class="col-md-3 col-form-label">Teléfonos</label>
            <div class="col-md-9">
                <input type="text" name="telefonos" id="telefonos" value="{{ old('telefonos',$items->telefonos) }}" class="form-control" />
            </div>
        </div>



    </div>
    <div class="tab-pane" id="Domicilio1">
        <div class="form-group row mb-3">
            <label for = "calle" class="col-md-3 col-form-label">UBICACIONES: </label>
            <div class="col-lg-9">
                <div class="input-group">
{{--                    {!! Form::text('search_autocomplete',null, array('placeholder' => 'Buscar ubicación...','class' => 'form-control search_autocomplete','id'=>'search_autocomplete')) !!}--}}
                    <input type="text" name="search_autocomplete" id="search_autocomplete" value="{{ old('search_autocomplete') }}" placeholder="'Buscar ubicación..." class="form-control search_autocomplete">
                    <span class="input-group-append">
                        <a href="{{route("newUbicacion")}}" target="_blank" class="btn btn-icon btn-info"> <i class="mdi mdi-plus"></i></a>
                    </span>
                </div>
                <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion') }}" class="form-control" disabled/>
                </div>
        </div>
        <hr>
        <div class="form-group row mb-3">
            <label for = "user_address_list" class="col-md-3 col-form-label">Selec. una Ubicación: </label>
            <div class="col-md-9">
                <select id="user_address_list" name="user_address_list" class="form-control user_address_list" size="1">
                @foreach($user_address_list as $t)
                    <option value="{{$t->id}}" {{ $t->id == $items->ubicacion_id ? 'selected': '' }} >{{ $t->Ubicacion }} </option>
                @endforeach
                </select>
            </div>
        </div>
        <hr>

        <div class="form-group row mb-3">
        <label for = "calle" class="col-md-3 col-form-label">Calle</label>
        <div class="col-md-9">
            <input type="text" name="calle" id="calle" value="{{ old('calle',$items->user_adress->calle) }}" class="form-control" />
        </div>
        <label for = "num_ext" class="col-md-3 col-form-label">Num Ext</label>
        <div class="col-md-9">
            <input type="text" name="num_ext" id="num_ext" value="{{ old('num_ext',$items->user_adress->num_ext) }}" class="form-control" />
        </div>
        <label for = "num_int" class="col-md-3 col-form-label">Num Int</label>
        <div class="col-md-9">
            <input type="text" name="num_int" id="num_int" value="{{ old('num_int',$items->user_adress->num_int) }}" class="form-control" />
        </div>
        <label for = "colonia" class="col-md-3 col-form-label">Colonia</label>
        <div class="col-md-9">
            <input type="text" name="colonia" id="colonia" value="{{ old('colonia',$items->user_adress->colonia) }}" class="form-control" />
        </div>
        <label for = "localidad" class="col-md-3 col-form-label">Localidad</label>
        <div class="col-md-9">
            <input type="text" name="localidad" id="localidad" value="{{ old('localidad',$items->user_adress->localidad) }}" class="form-control" />
        </div>
        <label for = "municipio" class="col-md-3 col-form-label">Municipio</label>
        <div class="col-md-9">
            <input type="text" name="municipio" id="municipio" value="{{ old('municipio',$items->user_adress->municipio) }}" class="form-control" />
        </div>
        <label for = "estado" class="col-md-3 col-form-label">Estado</label>
        <div class="col-md-9">
            <input type="text" name="estado" id="estado" value="{{ old('estado',$items->user_adress->estado) }}" class="form-control" />
        </div>
        <label for = "pais" class="col-md-3 col-form-label">País</label>
        <div class="col-md-9">
            <input type="text" name="pais" id="pais" value="{{ old('pais',$items->user_adress->pais) }}" class="form-control" />
        </div>
        <label for = "cp" class="col-md-3 col-form-label">CP</label>
        <div class="col-md-9">
            <input type="text" name="cp" id="cp" value="{{ old('cp',$items->user_adress->cp) }}" class="form-control" />
        </div>
    </div>

    </div>
    <div class="tab-pane" id="Ocupaciion1">


        <div class="form-group row mb-3">
            <label for = "lugar_nacimiento" class="col-md-3 col-form-label">Lugar Nacimiento</label>
            <div class="col-md-9">
                <input type="text" name="lugar_nacimiento" id="lugar_nacimiento" value="{{ old('lugar_nacimiento',$items->user_data_extend->lugar_nacimiento ?? "") }}" class="form-control" />
            </div>
            <label for = "fecha_nacimiento" class="col-md-3 col-form-label">Fecha Nacimiento</label>
            <div class="col-md-9">
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento',$items->fecha_nacimiento) }}" class="form-control" />
            </div>
            <label for = "genero" class="col-md-3 col-form-label">Género</label>
            <div class="col-md-9">
{{--                {{ Form::select('genero', array('1'=>'Hombre', '0'=>'Mujer'), trim($items->genero), ['id' => 'genero','class' => 'form-control']) }}--}}
                <select class=" form-control " name="genero" id="genero" size="1">
                    <option value="1" @if($items->genero==1) selected @endif >Hombre</option>
                    <option value="0" @if($items->genero==0) selected @endif >Mujer</option>
                </select>
            </div>
            <label for = "ocupacion" class="col-md-3 col-form-label">Ocupación</label>
            <div class="col-md-9">
                <input type="text" name="ocupacion" id="ocupacion" value="{{ old('ocupacion',$items->user_data_extend->ocupacion ?? "") }}" class="form-control" />
            </div>
            <label for = "profesion" class="col-md-3 col-form-label">Profesión</label>
            <div class="col-md-9">
                <input type="text" name="profesion" id="profesion" value="{{ old('profesion',$items->user_data_extend->profesion ?? "") }}" class="form-control" />
            </div>
        </div>

    </div>
</div>




<input type="hidden" name="username" id="username" value="{{ $items->username }}"  />
{{--<input type="hidden" name="email" id="email" value="{{ $items->email }}"  />--}}
{{--<input type="hidden" name="curp" id="curp" value="{{ $items->curp }}"  />--}}
<input type="hidden" name="ubicacion_actual_id" id="ubicacion_actual_id" value="{{ $items->ubicacion_id }}" >
<input type="hidden" name="ubicacion_nueva_id" id="ubicacion_nueva_id" value="{{ $items->ubicacion_id }}" >
<input type="hidden" name="id" value="{{$items->id}}" >

<hr>
