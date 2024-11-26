<div class="col-md-12 ">
    <div class="row">
    <div class="col-md-6 ">
        <div class="grid-container">
            @isset($item)
                @include('shared.ui_kit.__button_form_close_denuncia')
            @endisset
            @if($msgLeft)
                {{$msgLeft}}
            @else
                <p class="text-info ">No olvide revisar sus datos antes de guardar!</p>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="grid-container">
{{--            @include('shared.ui_kit.__button_form_denuncia_ambito')--}}
        </div>
    </div>
</div>
</div>
