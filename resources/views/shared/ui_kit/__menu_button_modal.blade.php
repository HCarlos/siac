<div class="row bg-dark-lighten">
    <div class="col-sm-12 button-list " style="padding: 1em;">
        <a href="#" id="{{$showItem.'/'.$Id}}" class="btn btn-icon btn-light btnFullModal" data-toggle="modal" data-target="#modalFull"><i class="fas fa-user-plus"></i></a>
        @isset($showProcess1)
            <a href="{{route($showProcess1)}}" @isset($newWindow) target="_blank" @endisset class="btn btn-icon btn-success btnFilters"> <i class="fas fa-file-excel text-white"></i> </a>
        @endisset

        <a href="/home" class="btn btn-icon btn-danger float-right"
           onclick="window.close(); ">
            <i class="fas fa-window-close"></i>
        </a>
        <a href="#" class="btn btn-icon btn-success float-right"
           onclick="location.reload(); ">
            <i class="fas fa-sync-alt"></i>
        </a>
    </div>
</div>
