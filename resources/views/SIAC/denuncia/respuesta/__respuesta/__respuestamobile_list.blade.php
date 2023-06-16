<div class="row ml-3 mr-3 mt-2 mb-1">
    <div class="col-lg-12 ">
        <div data-simplebar="" style="max-height:320px;overflow-x:hidden">
            <div class="row py-1 align-items-center">
                <ul style="list-style:none; padding:0; margin:0;">
                @foreach($item->respuestas as $rs)
                    @if( ! $rs->User->isRole('Administrator|USER_OPERATOR_ADMIN|USER_ARCHIVO_ADMIN') )
                        <li class="bg-secondary rounded-right w-75 float-left m-2 p-3 text-white">
                    @else
                        <li class="alert-warning rounded-left w-75 float-right m-2 p-2 text-dark">
                    @endif
                            <div class="chat-avatar">
                                <img src="{{ $rs->User->PathImageProfile ?? "" }}" class="w-4 h-4 rounded-circle" height="32" width="32" alt="male">
                                <i>{{ $rs->fecha }}</i>
                            </div>
                            <div class="conversation-text">
                                <div class="ctext-wrap">
                                    <i>{{ $rs->User->username }}</i>
                                    <p>
                                        {{ $rs->respuesta }}
                                    </p>
                                </div>
                            </div>
                        </li>
            @endforeach
                </ul>
            </div>
        </div>
    </div>

    <input type="text" name="respuesta" class="form-control mt-3 " placeholder="Escribe un comentario...">
    <input type="hidden" name="user_id" id="user_id" value="{{ $item->user_id }}">
    <input type="hidden" name="denunciamobile_id" id="denunciamobile_id" value="{{ $item->id }}">


</div>

@section('scripts')
<script src="{{asset('js/component.chat.js')}}"></script>
@endsection
