<div class="fallback">
    <input type="file" name="file" multiple />
</div>
<div class="dz-message needsclick">
    <i class="h1 text-muted dripicons-cloud-upload"></i>
    <h3>Haga click aqui para seleccionar sus archivos</h3>
    <span class="text-muted font-16">Tipos de archivos: <strong>jpg,gif,png</strong>.</span><br>
    <span class="text-muted font-13">(Puedes subir hasta <strong>5</strong> archivos.)</span><br>
    <span class="has-error has-file">
        <strong class="text-danger"></strong>
    </span>
</div>
<input type="hidden" id="denuncia__id" name="denuncia__id" value="{{ $denuncia_id }}"/>
<input type="hidden" id="user__id" name="user__id" value="{{ $user->id }}"/>
<input type="hidden" id="imagen__id" name="imagen__id" value="{{ $imagen_id }}"/>
<input type="hidden" id="id" name="id" value="0"/>

