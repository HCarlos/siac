    @if ($errors->any())
        <div class="alert alert-danger fade show bgc-white brc-secondary-l2 rounded" role="alert">
            <div class="position-tl h-102 border-l-4 brc-danger m-n1px rounded-left"></div><!-- the big red line on left -->
            <h5 class="alert-heading text-danger-m1 font-bolder">
                <i class="fas fa-exclamation-triangle mr-1 mb-1"></i>
                Error
            </h5>
            @foreach ($errors->all() as $error)
                <p class="mt-1 mb-0">
                <span class="text-dark py-1 px-2" >
                    <i class="far fa-hand-point-right"></i>  {{ $error }}
                </span>
                </p>
            @endforeach
        </div>
    @endif
    @if( (session('msg') != ""))
        <div class="alert alert-success animated flipInX delay-0.5s" role="alert">
            <span class="text-dark-tp4 text-140 text-600 opacity-1">
                {{ session('msg') }}
            </span>
            <a href="#" role="button" class="btn btn-xs radius-round position-tr btn-outline-info border-0 px-1 pt-0 pb-1 float-right " data-dismiss="alert" aria-label="Close">
                <i class="fa fa-times text-sm w-2 mx-1px" aria-hidden="true"></i>
            </a>
            @php
                session()->forget('msg');
            @endphp
        </div>
    @endif
