<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                {{ now()->year }} © {{config("atemun.nombre_empresa")}} <small class="text-warning-d1" id="power"></small>
            </div>
            <div class="col-md-6">
                <div class="text-md-right footer-links d-none d-md-block">
                    {{config("atemun.nombre_software")}}
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->
