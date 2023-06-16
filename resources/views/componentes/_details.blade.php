<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                {{--<ol class="breadcrumb m-0">--}}
                    {{--<li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>--}}
                    {{--<li class="breadcrumb-item"><a href="javascript: void(0);">UI Kit</a></li>--}}
                    {{--<li class="breadcrumb-item active">Grid System</li>--}}
                {{--</ol>--}}
            </div>
            <h4 class="page-title"><span class="orange">{{strtoupper($titleCategory)}}</span>: <span>{{utf8_decode($titleDescribe)}}</span></h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            {{$buttons}}
        </div>
    </div>
</div>

<div class="row">
    {{$body_catalogo}}
</div>

@section('scripts')
    <script src="{{asset('js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('js/buttons.print.min.js')}}"></script>
    <script src="{{asset('js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('js/dataTables.select.min.js')}}"></script>
@endsection