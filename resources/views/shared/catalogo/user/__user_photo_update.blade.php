
<div class="dz-message needsclick">
    <div class="form-group row mb-3">
        <label for="photo" class="control-label {{ $errors->has('photo') ? 'text-danger' : '' }}">Seleccione un archivo</label>
        <input type="file" name="photo" class="form-control-file col-md-12 {{ $errors->has('photo') ? 'has-error form-error' : '' }}" placeholder="Seleccione una imagen"  style="color: transparent" >
        @if ($errors->has('photo'))
            <span class="text-danger">
                <strong>{{ $errors->first('photo') }}</strong>
            </span>
        @endif
    </div>

</div>

<hr>
