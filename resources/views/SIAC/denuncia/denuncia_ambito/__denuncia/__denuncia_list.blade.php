@php use App\Models\Catalogos\CentroLocalidad; @endphp
<div class="row w-100-percent" >
    <div class="col-lg-12">

        <table  id="tblCat" class="table table-bordered table-striped dt-responsive dataTable tblCatDenuncias" role="grid" aria-describedby="datatable-buttons_info"  width="100%">
            <thead>
                <tr role="row">
                    <th class="sorting_asc" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
                    <th class="sorting">CIUDADANO</th>
                    <th class="sorting">FECHA</th>
                    <th class="sorting">UNIDAD</th>
                    <th class="sorting">SERVICIO</th>
                    <th class="sorting ">UBICACIÓN</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    @php
                        $Del = CentroLocalidad::find($item->centro_localidad_id);
                        if (!$Del) {
                            $Localidad = "Error en la localidad";
                        }else{
                            $Localidad = $Del->ItemColoniaDelegacion();
                        }
                        $fm = \Carbon\Carbon::parse($item->fecha_movimiento)->format('d-m-Y H:i');
                    @endphp
                    <tr class="@if($item->cerrado) bg-coral-denuncia-cerrada @endif" id="tr_{{$item->id}}">
                        <td class="table-user @if($item->origen_id == config('atemun.pagina_web_id')) text-danger @endif">
                            {{$item->id}}
                            @if($item->prioridad_id === 1 || $item->prioridad_id === 8)
                                <i class="fas fa-exclamation-triangle text-danger blinking-icon"></i><i class="fas fa-exclamation-circle text-danger"></i>
                            @endif
                        </td>
                        <td class="w-25">
{{--                            {{$item->ciudadano->full_name}} <br>--}}
{{--                            <small>{{$item->ciudadano->username}}</small>--}}
                            {{$item->ciudadano}} <br>
                            <small>{{$item->curp_ciudadano}}</small>
                        </td>
                        <td  class="w-15">{{ $fm }}</td>
                        <td>
{{--                            <small title="{{($item->dependencia_ultimo_estatus->dependencia)}}">--}}
{{--                                {{($item->dependencia_ultimo_estatus->dependencia)}}--}}
{{--                            </small>--}}
                                <small title="{{($item->dependencia)}}">
                                    {{($item->dependencia)}}
                                </small>
                            <small class="fas fa-circle chikirimbita {{ $item->semaforo_ultimo_estatus()['class_color'] }}"> {{ $item->semaforo_ultimo_estatus()['dias'] }}</small>
                        </td>
                        <td class="w-25">
{{--                            {{($item->servicio_ultimo_estatus->servicio)}}<br>--}}
                            {{($item->servicio)}}<br>
{{--                            <small class="text-gray-lighter">{{( $item->ultimo_estatus )}}</small>--}}
                            <small class="text-gray-lighter">{{( $item->estatus )}}</small>
                            @if( $item->TotalRespuestas > 0 )
                                > <small class="text-danger"><strong> {{( $item->TotalRespuestas )}}</strong></small>
                                <small class="chikirimbita"> {{ $item->semaforo_ultimo_estatus()['fecha_fin'] }}</small>
                            @endif
                            <br>
                            @if($item->ciudadanos->count() > 1)<span class="text-danger">( <i class="fas fa-users"></i> <strong>  {{$item->ciudadanos->count()}} </strong> )</span> @endif
                        </td>
{{--                        <td class="w-25">@if($item->dependencia->ambito_dependencia === 2) {{ strtoupper($item->search_google).' '.$Localidad }} @else {{ $item->ubicacion->ubicacion}} @endif--}}
                        <td class="w-25">@if($item->ambito_dependencia === 2) {{ strtoupper($item->search_google).' '.$Localidad }} @else {{ $item->ubicacion->ubicacion}} @endif
                        </td>
                        <td class="table-action w-15">
                            <div class="button-list">
                                @if($item->cerrado == false && $item->firmado == false)
{{--                                    @if($item->dependencia->ambito_dependencia === 2)--}}
                                    @if($item->ambito_dependencia === 2)
                                        @include('shared.ui_kit.__remove_item_servicios_municipales')
                                        @include('shared.ui_kit.__edit_den_dep_ser_ambito_sm')
                                    @else
                                        @include('shared.ui_kit.__remove_item_apoyos_sociales')
                                        @include('shared.ui_kit.__edit_den_dep_ser_ambito_as')
                                    @endif
                                @endif
                                @if( ($item->cerrado == false && $item->firmado == false) && auth()->user()->can('elimina_denuncia_general') )
{{--                                    @if($item->dependencia->ambito_dependencia === 2)--}}
                                    @if($item->ambito_dependencia === 2)
                                        @include('shared.ui_kit.__remove_item_servicios_municipales')
                                    @else
                                        @include('shared.ui_kit.__remove_item_apoyos_sociales')
                                    @endif
                                @endif
                                @include('shared.ui_kit.__imagenes_list_item_ambito')
                                @include('shared.ui_kit.__add_user_ambito_item')
                                @include('shared.ui_kit.__edit_ambito_item')
{{--                                @if($item->dependencia->ambito_dependencia === 2)--}}
                                @if($item->ambito_dependencia === 2)
                                    @include('shared.ui_kit.__print_denuncia_ambito_item')
                                @else
                                    @include('shared.ui_kit.__print_denuncia_item')
                                @endif
                                @include('shared.ui_kit.__respuestas_ciudadana_list_item')
                                @if( $item->latitud != 0 && $item->longitud != 0 )
                                    @include('shared.ui_kit.__geolocalization_item')
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
