<div class="form-row mb-1">
    <label for = "image" class="col-md-2 col-form-label">Imagen </label>
    <div class="col-md-10">
        <input type="text" name="image" id="image" class="form-control" value="{{ old('image',$item->image) }}" disabled>
    </div>
</div>
<div class="form-row mb-1">
    <label for = "image_thumb" class="col-md-2 col-form-label">Thumbnail </label>
    <div class="col-md-10">
        <input type="text" name="image_thumb" id="image_thumb" class="form-control" value="{{ old('image_thumb',$item->image_thumb) }}" disabled>
    </div>
</div>
<div class="form-row mb-1">
    <label for = "titulo" class="col-md-2 col-form-label">Título </label>
    <div class="col-md-10">
        <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo',$item->titulo) }}">
        <span class="has-error has-titulo">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-row mb-1">
    <label for = "descripcion" class="col-md-2 col-form-label">Descripción </label>
    <div class="col-md-10">
        <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion',$item->descripcion) }}">
        <span class="has-error has-descripcion">
            <strong class="text-danger"></strong>
        </span>
    </div>
</div>
<div class="form-row mb-1">
    <label for = "momento" class="col-md-2 col-form-label">Evento </label>
    <div class="col-md-10">
        <select name="momento" id="momento" size="1" class="form-control">
            <option value="ANTES" selected>Antes</option>
            <option value="DESPUÉS">Después</option>
        </select>
    </div>
</div>

<div class="form-row mb-1">
    <label for = "aplicaa" class="col-md-2 col-form-label">Aplicar a </label>
    <div class="col-md-10">
        <select name="aplicaa" id="aplicaa" size="1" class="form-control">
            <option value="0" selected>Solo a esta imágen</option>
            <option value="1">Todas las imágenes de esta Solicitud ({{$item->denuncia__id}})</option>
            <option value="2">Imágenes seleccionadas</option>
        </select>
    </div>
</div>

<input type="hidden" id="denuncia__id" name="denuncia__id" value="{{ $item->denuncia__id }}"/>
<input type="hidden" id="user__id" name="user__id" value="{{ $user->id }}"/>
<input type="hidden" id="id" name="id" value="{{ $item->id }}"/>
<input type="hidden" id="var2" name="var2" value=""/>

