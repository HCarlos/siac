<!-- Personal-Information -->
@component('components.card-sin-fondo')
@slot('title_card', $user->username)
@slot('body_card')
    <div class="text-center">
    @if( $user->IsEmptyPhoto() )
        @if( $user->IsFemale() )
            <img src="{{ asset('images/web/empty_user_female.png')  }}" class="img-circle border border-white"/>
        @else
            <img src="{{ asset('images/web/empty_user_male.png')  }}" class="img-circle border border-white"/>
        @endif
    @else
        <a href="{{ route('quitarArchivoProfile/')  }}" class=" red " >
            <img src="{{Auth::user()->PathImageThumbProfile}}?timestamp={{now()}}" class="img-circle border border-white"  alt="{{$user->username}}"/>
            <i class="mdi mdi-delete-empty mdi-18px"></i>
        </a>
    @endif
    </div>
    <hr>
    <div class="card text-white bg-grey" style="background-color: darkgray">
        <div class="card-body">
            <div class="toll-free-box  text-center" >
                <h4> <i class="mdi mdi-deskphone"></i>{{ $items->FullName ?? '' }}</h4>

                <div class="text-left pt-2">
                    <p class="text-white"><strong>Username :</strong><span class="ml-2">{{ $items->username ?? '' }}</span></p>
                    <p class="text-white"><strong>Email :</strong><span class="ml-2">{{ $items->email ?? '' }}</span></p>
                    <p class="text-white"><strong>CURP :</strong><span class="ml-2">{{ $items->curp ?? '' }}</span></p>

                    <p class="text-white"><strong>Roles :</strong>
                        @if( isset($items) )
                            @foreach($items->roles as $role)
                                <span class="ml-2">{{ $role->name }}</span>
                            @endforeach
                        @endif
                    </p>

                    <p class="text-white"><strong>Permisos :</strong>
                        @if( isset($items) )
                            @foreach($items->permissions as $permission)
                                <span class="ml-2">{{ $permission->name }}</span>
                            @endforeach
                        @endif
                    </p>
                    <br>
                </div>

            </div>
        </div>
    </div>
@endslot
@endcomponent
