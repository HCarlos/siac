<hr>
<div class="col-lg-12">
    <div class="card  p-0 m-0">
        <div class="card-header  bg-dark-lighten border-0 m-0">
            <h5 class="text-white mb-0">
                Usuarios agregados a esta misma Solicitud
            </h5>
        </div>

        <div >
            <table class="table bg-white border-2x bg-dark" id="responsive-table">
                <thead>
                <tr class="bg-success-d2 text-primary">
                    <th>ID</th>
                    <th>CIUDADANO</th>
                    <th>CURP</th>
                    <th>DOMICILIO</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="bg-success-d2">
                @foreach($items->ciudadanos as $item)
{{--                    @php $user = $item @endphp--}}
                    <tr class="bg-success-d2 text-dark">
                        <td data-th="Name"><span class="bt-content">{{$item->id}}</span></td>
                        <td data-th="Age"><span class="bt-content">{{$item->fullname}}</span></td>
                        <td data-th="Height"><span class="bt-content">{{$item->curp}}</span></td>
                        <td data-th="Sport"><span class="bt-content">{{$item->Ubicacion->Ubicacion}}</span></td>
                        <td data-th="Actions">
                            @if($items->ciudadanos->count()>1)
                                @include('shared.ui_kit.__remove_item_two')
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
