{{--<a href="http://www.openstreetmap.org/?mlat={{$item->latitud}}&mlon={{$item->longitud}}&map=23"--}}
<a href="https://www.google.com/maps/place/{{$item->latitud}},{{$item->longitud}}/{{$item->latitud}},{{$item->longitud}},15z"
   class="action-icon text-center" @isset($newWindow) target="_blank" @endisset
   data-toggle="tooltip" title="Geolocalización"
    >
    <i class="fas fa-globe-americas text-primary"></i>
</a>
