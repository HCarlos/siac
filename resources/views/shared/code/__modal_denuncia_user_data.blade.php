<!-- Modal de Opciones -->
<div class="modal fade m-0 p-0 " id="denunciaUserModalChange" tabindex="-1" role="dialog" aria-labelledby="denunciaUserModalChangeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 740px !important; padding: 0px !important;">
        <div class="modal-content shadow border-none radius-2 ">
            <div class="modal-header modal-colored-header bg-info m">
            <h4 class="modal-title" id="modalHeaderFull"><i class="mdi mdi-account"></i> Actualiazar datos del usuario </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body col-sm-12">

                <div class="form-row m-2">
                    <div class="col-xs-4">
                        <label for = "ciu_ap_paterno" class="col-xs-4 col-form-label">Apellido Paterno</label>
                        <input type="text" name="ciu_ap_paterno" id="ciu_ap_paterno" value="{{ old('ciu_ap_paterno',$items->ciudadano->ap_paterno ?? '')}}" class="col-xs-4 form-control" />
                    </div>
                    <div class="col-xs-4">
                        <label for = "ciu_ap_materno" class="col-xs-4 col-form-label">Apellido Materno</label>
                        <input type="text" name="ciu_ap_materno" id="ciu_ap_materno" value="{{ old('ciu_ap_naterno',$items->ciudadano->ap_materno ?? '')}}" class="col-xs-4 form-control" />
                    </div>
                    <div class="col-xs-4">
                        <label for = "ciu_nombre" class="col-xs-4 col-form-label">Nombre</label>
                        <input type="text" name="ciu_nombre" id="ciu_nombre" value="{{ old('ciu_nombre',$items->ciudadano->nombre ?? '')}}" class="col-xs-4 form-control" />
                    </div>
                </div>

                <div class="form-row m-2 mb-2">
                    <div class="col-xs-4">
                        <label for = "ciu_telefonos" class="col-xs-4 col-form-label">Teléfono Casa</label>
                        <input type="text" name="ciu_telefonos" id="ciu_telefonos" value="{{ old('ciu_telefonos',$items->ciudadano->telefonos ?? '')}}" class="col-xs-4 form-control" />
                    </div>
                    <div class="col-xs-4">
                        <label for = "ciu_celulares" class="col-xs-4 col-form-label">Teléfono Celular</label>
                        <input type="text" name="ciu_celulares" id="ciu_celulares" value="{{ old('ciu_celulares',$items->ciudadano->celulares ?? '')}}" class="col-xs-4 form-control" />
                    </div>
                    <div class="col-xs-4">
                        <label for = "ciu_emails" class="col-xs-4 col-form-label">Correo Electrónico</label>
                        <input type="text" name="ciu_emails" id="ciu_emails" value="{{ old('ciu_emails',$items->ciudadano->emails ?? '')}}" class="col-xs-4 form-control" />
                    </div>
                </div>

                <input type="hidden" name="ciudadano_id" id="ciudadano_id" value="{{ old('ciudadano_id',$items->ciudadano->id ?? 0)}}" class="col-xs-4 form-control" />
<hr>
                <div class="col-xs-12 mt-2">
                    <div class="form-group col-4 float-left">
                        <a href="{{route("editUser",['Id'=>$items->ciudadano->id ?? 0])}}" target="_blank" id="btnViewUserData" class="btn btn-sm btn-secondary btn-block text-600 radius-1 text-center text-white ">
                            <i class="fa fa-id-card mr-1"></i> Ver datos del usuario
                        </a>
                    </div>
                    <div class="form-group col-4 float-right">
                        <button type="button" id="btnRefreshUserData" class="btn btn-sm btn-primary btn-block text-600 radius-1 text-center pr-2">
                            <i class="fa fa-save mr-1"></i> Guardar cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
