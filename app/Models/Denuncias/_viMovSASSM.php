<?php


namespace App\Models\Denuncias;

use App\Filters\Denuncia\Count\DenunciaAmbitoFilterCount;
use App\Filters\Denuncia\Count\GetDenunciasAmbitoFilterCount;
use App\Filters\Denuncia\Count\GetDenunciasEstatusAmbitoFilterCount;
use App\Filters\Denuncia\DenunciaAmbitoFilter;
use App\Filters\Denuncia\DenunciaFilter;
use App\Filters\Denuncia\GetDenunciasAmbitoItemCustomFilter;
use App\Filters\Denuncia\GetDenunciasItemCustomFilter;
use App\Models\Catalogos\CentroLocalidad;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Origen;
use App\Models\Catalogos\Prioridad;
use App\Models\Catalogos\Servicio;
use App\Traits\Denuncia\DenunciaTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class _viMovSASSM extends Model{

    protected $guard_name = 'web';
    protected $table = '_vimov_sas_sm';


}
