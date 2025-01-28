<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Classes\NotificationsMobile\SendNotificationFCM;
use App\Mail\SendMailToEnlace;
use App\Models\Denuncias\Denuncia;
use App\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {return view('welcome');});
Route::get('/privacidad', function () {return view('privacidad');});
Route::get('/about_app', function () {return view("partials.others.about_app");});
Route::get('/aviso_app', function () {return view("partials.others.aviso_app");});

Route::get('newUbicacionV2', 'Catalogos\Domicilio\UbicacionController@newItemV2')->name('newUbicacionV2');
Route::post('createUbicacionV2', 'Catalogos\Domicilio\UbicacionController@createItemV2')->name('createUbicacionV2');

Auth::routes();
Auth::routes(['verify' => false]);

// Authentication Routes...
// $this

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::post('registered/{email}/{username}', 'Auth\RegisterController@registered')->name('registered');

Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');

//TRabajar con el Registry
Route::get('verificationAPIUrl/{id}/{hash}', 'App\Notifications\SendEmailAPIVerificationNotification@verificationapiUrl')->name('verificationAPIUrl');
Route::get('sendVerificationAPIUrl/{id}/{hash}/{notifiable}', 'Catalogos\User\UserDataController@sendVerificationAPIUrl')->name('sendVerificationAPIUrl');

//Route::get('getCURP/', 'Catalogos\User\UserDataController@getCURP')->name('getCURP');

Route::group(['middleware' => 'auth'], function () {

    Route::match(['get','put','post'],'dashboard', 'Dashboard\DashboardController@index')->name('dashboard');
    Route::match(['get','put','post'],'dashboard_enlace', 'Dashboard\DashboardEnlaceController@index')->name('dashboard_enlace');
    Route::match(['get','put','post'],'dashboard-statistics', 'Dashboard\DashboardStaticController@index')->name('dashboard-statistics');
    Route::match(['get','put','post'],'dashboard-statistics-two', 'Dashboard\DashboardStaticTwoController@index')->name('dashboard-statistics-two');
    Route::match(['get','put','post'],'dashboard-statistics-three', 'Dashboard\DashboardStaticThreeController@index')->name('dashboard-statistics-three');
    Route::match(['get','put','post'],'dashboard-statistics-three/month-now', 'Dashboard\DashboardStaticThreeController@monthnow')->name('dashboard-statistics-three/month-now');
    Route::match(['get','put','post'],'dashboard-statistics-three/year-now', 'Dashboard\DashboardStaticThreeController@yearnow')->name('dashboard-statistics-three/year-now');

    // USUARIOS
    Route::get('edit', 'Catalogos\User\UserDataController@showEditUserData')->name('edit');
    Route::put('Edit', 'Catalogos\User\UserDataController@update')->name('Edit');
    Route::get('showEditProfilePhoto/', 'Catalogos\User\UserDataController@showEditProfilePhoto')->name('showEditProfilePhoto/');
    Route::get('editUser/{Id}', 'Catalogos\User\UserDataController@editItem')->name('editUser');
    Route::put('EditUser', 'Catalogos\User\UserDataController@updateUser')->name('EditUser');
    Route::put('updateUserV2', 'Catalogos\User\UserDataController@updateUserV2')->name('updateUserV2');
    Route::get('verificarEmailAhora', 'Catalogos\User\UserDataController@verificarEmailAhora')->name('verificarEmailAhora');
    Route::get('verificarEmailAhoraForAdmin/{id}', 'Catalogos\User\UserDataController@verificarEmailAhoraForAdmin')->name('verificarEmailAhoraForAdmin');
});

Route::group(['middleware' => 'role:auth|Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE|USER_ARCHIVO_CAP|USER_ARCHIVO_ADMIN'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('newUser', 'Catalogos\User\UserDataController@newUser')->name('newUser');
    Route::post('createUser', 'Catalogos\User\UserDataController@createUser')->name('createUser');
    Route::get('removeUser/{id}', 'Catalogos\User\UserDataController@removeUser')->name('removeUser');
    Route::get('list-users/', 'Catalogos\User\UserDataController@showListUser')->name('listUsers');

    // Catálogo de Categorías
    Route::get('listCategorias/', 'Catalogos\User\CategoriaController@index')->name('listCategorias');
    Route::get('editCategoria/{Id}', 'Catalogos\User\CategoriaController@editCategoria')->name('editCategoria');
    Route::put('updateCategoria', 'Catalogos\User\CategoriaController@updateCategoria')->name('updateCategoria');
    Route::get('newCategoria', 'Catalogos\User\CategoriaController@newCategoria')->name('newCategoria');
    Route::post('createCategoria', 'Catalogos\User\CategoriaController@createCategoria')->name('createCategoria');
    Route::get('removeCategoria/{id}', 'Catalogos\User\CategoriaController@removeCategoria')->name('removeCategoria');

    // Catálogo de Dependencias
    Route::get('listDependencias/', 'Catalogos\Dependencia\DependenciaController@index')->name('listDependencias');
    Route::get('newDependencia', 'Catalogos\Dependencia\DependenciaController@newItem')->name('newDependencia');
    Route::post('createDependencia', 'Catalogos\Dependencia\DependenciaController@createItem')->name('createDependencia');
    Route::get('editDependencia/{Id}', 'Catalogos\Dependencia\DependenciaController@editItem')->name('editDependencia');
    Route::put('updateDependencia', 'Catalogos\Dependencia\DependenciaController@updateItem')->name('updateDependencia');
    Route::get('removeDependencia/{id}', 'Catalogos\Dependencia\DependenciaController@removeItem')->name('removeDependencia');

    Route::get('newDependenciaV2', 'Catalogos\Dependencia\DependenciaController@newItemV2')->name('newDependenciaV2');
    Route::post('createDependenciaV2', 'Catalogos\Dependencia\DependenciaController@createItemV2')->name('createDependenciaV2');
    Route::get('editDependenciaV2/{Id}', 'Catalogos\Dependencia\DependenciaController@editItemV2')->name('editDependenciaV2');
    Route::put('updateDependenciaV2', 'Catalogos\Dependencia\DependenciaController@updateItemV2')->name('updateDependenciaV2');

    // Catálogo de Areas
    Route::get('listAreas/', 'Catalogos\Dependencia\AreaController@index')->name('listAreas');
    Route::get('newArea', 'Catalogos\Dependencia\AreaController@newItem')->name('newArea');
    Route::post('createArea', 'Catalogos\Dependencia\AreaController@createItem')->name('createArea');
    Route::get('editArea/{Id}', 'Catalogos\Dependencia\AreaController@editItem')->name('editArea');
    Route::put('updateArea', 'Catalogos\Dependencia\AreaController@updateItem')->name('updateArea');
    Route::get('removeArea/{id}', 'Catalogos\Dependencia\AreaController@removeItem')->name('removeArea');

    Route::get('newAreaV2', 'Catalogos\Dependencia\AreaController@newItemV2')->name('newAreaV2');
    Route::post('createAreaV2', 'Catalogos\Dependencia\AreaController@createItemV2')->name('createAreaV2');
    Route::get('editAreaV2/{Id}', 'Catalogos\Dependencia\AreaController@editItemV2')->name('editAreaV2');
    Route::put('updateAreaV2', 'Catalogos\Dependencia\AreaController@updateItemV2')->name('updateAreaV2');

    // Catálogo de Subareas
    Route::get('listSubareas/', 'Catalogos\Dependencia\SubareaController@index')->name('listSubareas');
    Route::get('newSubarea', 'Catalogos\Dependencia\SubareaController@newItem')->name('newSubarea');
    Route::post('createSubarea', 'Catalogos\Dependencia\SubareaController@createItem')->name('createSubarea');
    Route::get('editSubarea/{Id}', 'Catalogos\Dependencia\SubareaController@editItem')->name('editSubarea');
    Route::put('updateSubarea', 'Catalogos\Dependencia\SubareaController@updateItem')->name('updateSubarea');
    Route::get('removeSubarea/{id}', 'Catalogos\Dependencia\SubareaController@removeItem')->name('removeSubarea');

    Route::get('newSubareaV2', 'Catalogos\Dependencia\SubareaController@newItemV2')->name('newSubareaV2');
    Route::post('createSubareaV2', 'Catalogos\Dependencia\SubareaController@createItemV2')->name('createSubareaV2');
    Route::get('editSubareaV2/{Id}', 'Catalogos\Dependencia\SubareaController@editItemV2')->name('editSubareaV2');
    Route::put('updateSubareaV2', 'Catalogos\Dependencia\SubareaController@updateItemV2')->name('updateSubareaV2');

    // Catálogo de Estatus
    Route::get('listEstatus/', 'Denuncia\EstatuController@index')->name('listEstatus');
    Route::get('newEstatu', 'Denuncia\EstatuController@newItem')->name('newEstatu');
    Route::post('createEstatu', 'Denuncia\EstatuController@createItem')->name('createEstatu');
    Route::get('editEstatu/{Id}', 'Denuncia\EstatuController@editItem')->name('editEstatu');
    Route::put('updateEstatu', 'Denuncia\EstatuController@updateItem')->name('updateEstatu');
    Route::get('removeEstatu/{id}', 'Denuncia\EstatuController@removeItem')->name('removeEstatu');
    Route::get('addDepEstatu/{Id}/{IdDep}', 'Denuncia\EstatuController@addDepEstatu')->name('addDepEstatu');
    Route::get('removeDepEstatu/{Id}/{IdDep}', 'Denuncia\EstatuController@removeDepEstatu')->name('removeDepEstatu');

    Route::get('newEstatuV2', 'Denuncia\EstatuController@newItemV2')->name('newEstatuV2');
    Route::post('createEstatuV2', 'Denuncia\EstatuController@createItemV2')->name('createEstatuV2');
    Route::get('editEstatuV2/{Id}', 'Denuncia\EstatuController@editItemV2')->name('editEstatuV2');
    Route::put('updateEstatuV2', 'Denuncia\EstatuController@updateItemV2')->name('updateEstatuV2');

    // Catálogo de Medidas
    Route::get('listMedidas/', 'Denuncia\MedidaController@index')->name('listMedidas');
    Route::get('newMedida', 'Denuncia\MedidaController@newItem')->name('newMedida');
    Route::post('createMedida', 'Denuncia\MedidaController@createItem')->name('createMedida');
    Route::get('editMedida/{Id}', 'Denuncia\MedidaController@editItem')->name('editMedida');
    Route::put('updateMedida', 'Denuncia\MedidaController@updateItem')->name('updateMedida');
    Route::get('removeMedida/{id}', 'Denuncia\MedidaController@removeItem')->name('removeMedida');

    Route::get('newMedidaV2', 'Denuncia\MedidaController@newItemV2')->name('newMedidaV2');
    Route::post('createMedidaV2', 'Denuncia\MedidaController@createItemV2')->name('createMedidaV2');
    Route::get('editMedidaV2/{Id}', 'Denuncia\MedidaController@editItemV2')->name('editMedidaV2');
    Route::put('updateMedidaV2', 'Denuncia\MedidaController@updateItemV2')->name('updateMedidaV2');

    // Catálogo de Origenes
    Route::get('listOrigenes/', 'Denuncia\OrigenController@index')->name('listOrigenes');
    Route::get('newOrigen', 'Denuncia\OrigenController@newItem')->name('newOrigen');
    Route::post('createOrigen', 'Denuncia\OrigenController@createItem')->name('createOrigen');
    Route::get('editOrigen/{Id}', 'Denuncia\OrigenController@editItem')->name('editOrigen');
    Route::put('updateOrigen', 'Denuncia\OrigenController@updateItem')->name('updateOrigen');
    Route::get('removeOrigen/{id}', 'Denuncia\OrigenController@removeItem')->name('removeOrigen');

    Route::get('newOrigenV2', 'Denuncia\OrigenController@newItemV2')->name('newOrigenV2');
    Route::post('createOrigenV2', 'Denuncia\OrigenController@createItemV2')->name('createOrigenV2');
    Route::get('editOrigenV2/{Id}', 'Denuncia\OrigenController@editItemV2')->name('editOrigenV2');
    Route::put('updateOrigenV2', 'Denuncia\OrigenController@updateItemV2')->name('updateOrigenV2');

    // Catálogo de Prioridades
    Route::get('listPrioridades/', 'Denuncia\PrioridadController@index')->name('listPrioridades');
    Route::get('newPrioridad', 'Denuncia\PrioridadController@newItem')->name('newPrioridad');
    Route::post('createPrioridad', 'Denuncia\PrioridadController@createItem')->name('createPrioridad');
    Route::get('editPrioridad/{Id}', 'Denuncia\PrioridadController@editItem')->name('editPrioridad');
    Route::put('updatePrioridad', 'Denuncia\PrioridadController@updateItem')->name('updatePrioridad');
    Route::get('removePrioridad/{id}', 'Denuncia\PrioridadController@removeItem')->name('removePrioridad');

    Route::get('newPrioridadV2', 'Denuncia\PrioridadController@newItemV2')->name('newPrioridadV2');
    Route::post('createPrioridadV2', 'Denuncia\PrioridadController@createItemV2')->name('createPrioridadV2');
    Route::get('editPrioridadV2/{Id}', 'Denuncia\PrioridadController@editItemV2')->name('editPrioridadV2');
    Route::put('updatePrioridadV2', 'Denuncia\PrioridadController@updateItemV2')->name('updatePrioridadV2');

    // Catálogo de Servicios
    Route::get('listServicios/', 'Denuncia\ServicioController@index')->name('listServicios');
    Route::get('newServicio', 'Denuncia\ServicioController@newItem')->name('newServicio');
    Route::post('createServicio', 'Denuncia\ServicioController@createItem')->name('createServicio');
    Route::get('editServicio/{Id}', 'Denuncia\ServicioController@editItem')->name('editServicio');
    Route::put('updateServicio', 'Denuncia\ServicioController@updateItem')->name('updateServicio');
    Route::get('removeServicio/{id}', 'Denuncia\ServicioController@removeItem')->name('removeServicio');
    Route::get('showModalSearchServicio/', 'Denuncia\ServicioController@showModalSearchServicio')->name('showModalSearchServicio');
    Route::match(['get','put','post'],'findDataInServicio/', 'Denuncia\ServicioController@findDataInServicio')->name('findDataInServicio');

    Route::get('newServicioV2', 'Denuncia\ServicioController@newItemV2')->name('newServicioV2');
    Route::post('createServicioV2', 'Denuncia\ServicioController@createItemV2')->name('createServicioV2');
    Route::get('editServicioV2/{Id}', 'Denuncia\ServicioController@editItemV2')->name('editServicioV2');
    Route::put('updateServicioV2', 'Denuncia\ServicioController@updateItemV2')->name('updateServicioV2');

    Route::get('quitarArchivoMobileServicio/{Id}', 'Storage\Mobile\StorageMobileServicioController@quitarArchivoMobileServicio')->name('quitarArchivoMobileServicio');



    // Catálogo de Afiliaciones
    Route::get('listAfiliaciones/', 'Denuncia\AfiliacionController@index')->name('listAfiliaciones');
    Route::get('editAfiliacion/{Id}', 'Denuncia\AfiliacionController@editItem')->name('editAfiliacion');
    Route::put('updateAfiliacion', 'Denuncia\AfiliacionController@updateItem')->name('updateAfiliacion');
    Route::get('newAfiliacion', 'Denuncia\AfiliacionController@newItem')->name('newAfiliacion');
    Route::post('createAfiliacion', 'Denuncia\AfiliacionController@createItem')->name('createAfiliacion');
    Route::get('removeAfiliacion/{id}', 'Denuncia\AfiliacionController@removeItem')->name('removeAfiliacion');

    // Catálogo de Asentamientos
    Route::get('listAsentamientos/', 'Catalogos\Domicilio\AsentamientoController@index')->name('listAsentamientos');
    Route::get('newAsentamiento', 'Catalogos\Domicilio\AsentamientoController@newItem')->name('newAsentamiento');
    Route::post('createAsentamiento', 'Catalogos\Domicilio\AsentamientoController@createItem')->name('createAsentamiento');
    Route::get('editAsentamiento/{Id}', 'Catalogos\Domicilio\AsentamientoController@editItem')->name('editAsentamiento');
    Route::put('updateAsentamiento', 'Catalogos\Domicilio\AsentamientoController@updateItem')->name('updateAsentamiento');
    Route::get('removeAsentamiento/{id}', 'Catalogos\Domicilio\AsentamientoController@removeItem')->name('removeAsentamiento');

    Route::get('newAsentamientoV2', 'Catalogos\Domicilio\AsentamientoController@newItemV2')->name('newAsentamientoV2');
    Route::post('createAsentamientoV2', 'Catalogos\Domicilio\AsentamientoController@createItemV2')->name('createAsentamientoV2');
    Route::get('editAsentamientoV2/{Id}', 'Catalogos\Domicilio\AsentamientoController@editItemV2')->name('editAsentamientoV2');
    Route::put('updateAsentamientoV2', 'Catalogos\Domicilio\AsentamientoController@updateItemV2')->name('updateAsentamientoV2');

    // Catálogo de ServiciosCategorias
    Route::get('listServiciosCategorias/', 'Denuncia\ServicioCategoriaController@index')->name('listServiciosCategorias');
    Route::get('newServicioCategoria', 'Denuncia\ServicioCategoriaController@newItemV2')->name('newServicioCategoria');
    Route::post('createServicioCategoria', 'Denuncia\ServicioCategoriaController@createItemV2')->name('createServicioCategoria');
    Route::get('editServicioCategoria/{Id}', 'Denuncia\ServicioCategoriaController@editItemV2')->name('editServicioCategoria');
    Route::put('updateServicioCategoria', 'Denuncia\ServicioCategoriaController@updateItemV2')->name('updateServicioCategoria');
    Route::get('removeServicioCategoria/{id}', 'Denuncia\ServicioCategoriaController@removeItem')->name('removeServicioCategoria');



    // Catálogo de Calles
    Route::get('listCalles/', 'Catalogos\Domicilio\CalleController@index')->name('listCalles');
    Route::get('editCalle/{Id}', 'Catalogos\Domicilio\CalleController@editItem')->name('editCalle');
    Route::put('updateCalle', 'Catalogos\Domicilio\CalleController@updateItem')->name('updateCalle');
    Route::get('newCalle', 'Catalogos\Domicilio\CalleController@newItem')->name('newCalle');
    Route::post('createCalle', 'Catalogos\Domicilio\CalleController@createItem')->name('createCalle');
    Route::get('removeCalle/{id}', 'Catalogos\Domicilio\CalleController@removeItem')->name('removeCalle');

    Route::get('newCalleV2', 'Catalogos\Domicilio\CalleController@newItemV2')->name('newCalleV2');
    Route::post('createCalleV2', 'Catalogos\Domicilio\CalleController@createItemV2')->name('createCalleV2');
    Route::get('editCalleV2/{Id}', 'Catalogos\Domicilio\CalleController@editItemV2')->name('editCalleV2');
    Route::put('updateCalleV2', 'Catalogos\Domicilio\CalleController@updateItemV2')->name('updateCalleV2');
    Route::get('buscarCalle/', 'Catalogos\Domicilio\CalleController@buscarCalle')->name('buscarCalle');
    Route::get('getCalle/{IdCalle}', 'Catalogos\Domicilio\CalleController@getCalle')->name('getCalle');

    // Catálogo de Ciudades
    Route::get('listCiudades/', 'Catalogos\Domicilio\CiudadController@index')->name('listCiudades');
    Route::get('editCiudad/{Id}', 'Catalogos\Domicilio\CiudadController@editItem')->name('editCiudad');
    Route::put('updateCiudad', 'Catalogos\Domicilio\CiudadController@updateItem')->name('updateCiudad');
    Route::get('newCiudad', 'Catalogos\Domicilio\CiudadController@newItem')->name('newCiudad');
    Route::post('createCiudad', 'Catalogos\Domicilio\CiudadController@createItem')->name('createCiudad');
    Route::get('removeCiudad/{id}', 'Catalogos\Domicilio\CiudadController@removeItem')->name('removeCiudad');

    Route::get('newCiudadV2', 'Catalogos\Domicilio\CiudadController@newItemV2')->name('newCiudadV2');
    Route::post('createCiudadV2', 'Catalogos\Domicilio\CiudadController@createItemV2')->name('createCiudadV2');
    Route::get('editCiudadV2/{Id}', 'Catalogos\Domicilio\CiudadController@editItemV2')->name('editCiudadV2');
    Route::put('updateCiudadV2', 'Catalogos\Domicilio\CiudadController@updateItemV2')->name('updateCiudadV2');

    // Catálogo de Localidades
    Route::get('listLocalidades/', 'Catalogos\Domicilio\LocalidadController@index')->name('listLocalidades');
    Route::get('newLocalidad', 'Catalogos\Domicilio\LocalidadController@newItem')->name('newLocalidad');
    Route::post('createLocalidad', 'Catalogos\Domicilio\LocalidadController@createItem')->name('createLocalidad');
    Route::get('editLocalidad/{Id}', 'Catalogos\Domicilio\LocalidadController@editItem')->name('editLocalidad');
    Route::put('updateLocalidad', 'Catalogos\Domicilio\LocalidadController@updateItem')->name('updateLocalidad');
    Route::get('removeLocalidad/{id}', 'Catalogos\Domicilio\LocalidadController@removeItem')->name('removeLocalidad');

    Route::get('newLocalidadV2', 'Catalogos\Domicilio\LocalidadController@newItemV2')->name('newLocalidadV2');
    Route::post('createLocalidadV2', 'Catalogos\Domicilio\LocalidadController@createItemV2')->name('createLocalidadV2');
    Route::get('editLocalidadV2/{Id}', 'Catalogos\Domicilio\LocalidadController@editItemV2')->name('editLocalidadV2');
    Route::put('updateLocalidadV2', 'Catalogos\Domicilio\LocalidadController@updateItemV2')->name('updateLocalidadV2');

    // Catálogo de Municipios
    Route::get('listMunicipios/', 'Catalogos\Domicilio\MunicipioController@index')->name('listMunicipios');
    Route::get('editMunicipio/{Id}', 'Catalogos\Domicilio\MunicipioController@editItem')->name('editMunicipio');
    Route::put('updateMunicipio', 'Catalogos\Domicilio\MunicipioController@updateItem')->name('updateMunicipio');
    Route::get('newMunicipio', 'Catalogos\Domicilio\MunicipioController@newItem')->name('newMunicipio');
    Route::post('createMunicipio', 'Catalogos\Domicilio\MunicipioController@createItem')->name('createMunicipio');
    Route::get('removeMunicipio/{id}', 'Catalogos\Domicilio\MunicipioController@removeItem')->name('removeMunicipio');

    // Catálogo de Estados
    Route::get('listEstados/', 'Catalogos\Domicilio\EstadoController@index')->name('listEstados');
    Route::get('editEstado/{Id}', 'Catalogos\Domicilio\EstadoController@editItem')->name('editEstado');
    Route::put('updateEstado', 'Catalogos\Domicilio\EstadoController@updateItem')->name('updateEstado');
    Route::get('newEstado', 'Catalogos\Domicilio\EstadoController@newItem')->name('newEstado');
    Route::post('createEstado', 'Catalogos\Domicilio\EstadoController@createItem')->name('createEstado');
    Route::get('removeEstado/{id}', 'Catalogos\Domicilio\EstadoController@removeItem')->name('removeEstado');

    // Catálogo de Codigopostales
    Route::get('listCodigopostales/', 'Catalogos\Domicilio\CodigopostalController@index')->name('listCodigopostales');
    Route::get('newCodigopostal', 'Catalogos\Domicilio\CodigopostalController@newItem')->name('newCodigopostal');
    Route::post('createCodigopostal', 'Catalogos\Domicilio\CodigopostalController@createItem')->name('createCodigopostal');
    Route::get('editCodigopostal/{Id}', 'Catalogos\Domicilio\CodigopostalController@editItem')->name('editCodigopostal');
    Route::put('updateCodigopostal', 'Catalogos\Domicilio\CodigopostalController@updateItem')->name('updateCodigopostal');
    Route::get('buscarCodigopostal/', 'Catalogos\Domicilio\CodigopostalController@buscarCodigopostal')->name('buscarCodigopostal');
    Route::get('getCodigopostal/{IdCodigopostal}', 'Catalogos\Domicilio\CodigopostalController@getCodigopostal')->name('getCodigopostal');
    Route::get('removeCodigopostal/{id}', 'Catalogos\Domicilio\CodigopostalController@removeItem')->name('removeCodigopostal');

    Route::get('newCodigopostalV2', 'Catalogos\Domicilio\CodigopostalController@newItemV2')->name('newCodigopostalV2');
    Route::post('createCodigopostalV2', 'Catalogos\Domicilio\CodigopostalController@createItemV2')->name('createCodigopostalV2');
    Route::get('editCodigopostalV2/{Id}', 'Catalogos\Domicilio\CodigopostalController@editItemV2')->name('editCodigopostalV2');
    Route::put('updateCodigopostalV2', 'Catalogos\Domicilio\CodigopostalController@updateItemV2')->name('updateCodigopostalV2');

    // Catálogo de Tipoasentamientos
    Route::get('listTipoasentamientos/', 'Catalogos\Domicilio\TipoasentamientoController@index')->name('listTipoasentamientos');
    Route::get('newTipoasentamiento', 'Catalogos\Domicilio\TipoasentamientoController@newItem')->name('newTipoasentamiento');
    Route::post('createTipoasentamiento', 'Catalogos\Domicilio\TipoasentamientoController@createItem')->name('createTipoasentamiento');
    Route::get('editTipoasentamiento/{Id}', 'Catalogos\Domicilio\TipoasentamientoController@editItem')->name('editTipoasentamiento');
    Route::put('updateTipoasentamiento', 'Catalogos\Domicilio\TipoasentamientoController@updateItem')->name('updateTipoasentamiento');
    Route::get('removeTipoasentamiento/{id}', 'Catalogos\Domicilio\TipoasentamientoController@removeItem')->name('removeTipoasentamiento');

    Route::get('newTipoasentamientoV2', 'Catalogos\Domicilio\TipoasentamientoController@newItemV2')->name('newTipoasentamientoV2');
    Route::post('createTipoasentamientoV2', 'Catalogos\Domicilio\TipoasentamientoController@createItemV2')->name('createTipoasentamientoV2');
    Route::get('editTipoasentamientoV2/{Id}', 'Catalogos\Domicilio\TipoasentamientoController@editItemV2')->name('editTipoasentamientoV2');
    Route::put('updateTipoasentamientoV2', 'Catalogos\Domicilio\TipoasentamientoController@updateItemV2')->name('updateTipoasentamientoV2');

    // Catálogo de Tipocomunidades
    Route::get('listTipocomunidades/', 'Catalogos\Domicilio\TipocomunidadController@index')->name('listTipocomunidades');
    Route::get('newTipocomunidad', 'Catalogos\Domicilio\TipocomunidadController@newItem')->name('newTipocomunidad');
    Route::post('createTipocomunidad', 'Catalogos\Domicilio\TipocomunidadController@createItem')->name('createTipocomunidad');
    Route::get('editTipocomunidad/{Id}', 'Catalogos\Domicilio\TipocomunidadController@editItem')->name('editTipocomunidad');
    Route::put('updateTipocomunidad', 'Catalogos\Domicilio\TipocomunidadController@updateItem')->name('updateTipocomunidad');
    Route::get('removeTipocomunidad/{id}', 'Catalogos\Domicilio\TipocomunidadController@removeItem')->name('removeTipocomunidad');

    Route::get('newTipocomunidadV2', 'Catalogos\Domicilio\TipocomunidadController@newItemV2')->name('newTipocomunidadV2');
    Route::post('createTipocomunidadV2', 'Catalogos\Domicilio\TipocomunidadController@createItemV2')->name('createTipocomunidadV2');
    Route::get('editTipocomunidadV2/{Id}', 'Catalogos\Domicilio\TipocomunidadController@editItemV2')->name('editTipocomunidadV2');
    Route::put('updateTipocomunidadV2', 'Catalogos\Domicilio\TipocomunidadController@updateItemV2')->name('updateTipocomunidadV2');

    // Catálogo de Comunidades
    Route::get('listComunidades/', 'Catalogos\Domicilio\ComunidadController@index')->name('listComunidades');
    Route::get('newComunidad', 'Catalogos\Domicilio\ComunidadController@newItem')->name('newComunidad');
    Route::post('createComunidad', 'Catalogos\Domicilio\ComunidadController@createItem')->name('createComunidad');
    Route::get('editComunidad/{Id}', 'Catalogos\Domicilio\ComunidadController@editItem')->name('editComunidad');
    Route::put('updateComunidad', 'Catalogos\Domicilio\ComunidadController@updateItem')->name('updateComunidad');
    Route::get('buscarComunidad/', 'Catalogos\Domicilio\ComunidadController@buscarComunidad')->name('buscarComunidad');
    Route::get('getComunidad/{IdComunidad}', 'Catalogos\Domicilio\ComunidadController@getComunidad')->name('getComunidad');
    Route::get('removeComunidad/{id}', 'Catalogos\Domicilio\ComunidadController@removeItem')->name('removeComunidad');

    Route::get('newComunidadV2', 'Catalogos\Domicilio\ComunidadController@newItemV2')->name('newComunidadV2');
    Route::post('createComunidadV2', 'Catalogos\Domicilio\ComunidadController@createItemV2')->name('createComunidadV2');
    Route::get('editComunidadV2/{Id}', 'Catalogos\Domicilio\ComunidadController@editItemV2')->name('editComunidadV2');
    Route::put('updateComunidadV2', 'Catalogos\Domicilio\ComunidadController@updateItemV2')->name('updateComunidadV2');

    Route::get('unicomunidad/', 'Catalogos\Domicilio\ComunidadUnificarController@indexV2')->name('unicomunidad');
    Route::post('unificacomunidad/', 'Catalogos\Domicilio\ComunidadUnificarController@unificacomunidad')->name('unificacomunidad');

    // Catálogo de Colonias
    Route::get('listColonias/', 'Catalogos\Domicilio\ColoniaController@index')->name('listColonias');
    Route::get('editColonia/{Id}', 'Catalogos\Domicilio\ColoniaController@editItem')->name('editColonia');
    Route::put('updateColonia', 'Catalogos\Domicilio\ColoniaController@updateItem')->name('updateColonia');
    Route::get('newColonia', 'Catalogos\Domicilio\ColoniaController@newItem')->name('newColonia');
    Route::post('createColonia', 'Catalogos\Domicilio\ColoniaController@createItem')->name('createColonia');
    Route::get('buscarColonia/', 'Catalogos\Domicilio\ColoniaController@buscarColonia')->name('buscarColonia');
    Route::get('getColonia/{IdColonia}', 'Catalogos\Domicilio\ColoniaController@getColonia')->name('getColonia');
    Route::get('removeColonia/{id}', 'Catalogos\Domicilio\ColoniaController@removeItem')->name('removeColonia');

    Route::get('unicolonia/', 'Catalogos\Domicilio\ColoniaUnificarController@indexV2')->name('unicolonia');
    Route::post('unificacolonia/', 'Catalogos\Domicilio\ColoniaUnificarController@unificacolonia')->name('unificacolonia');

    Route::get('unicolcom/', 'Catalogos\Domicilio\ColoniaComunidadUnificarController@unicolcom')->name('unicolcom');
    Route::post('unificacoloniaacomunidad/', 'Catalogos\Domicilio\ColoniaComunidadUnificarController@unificacoloniaacomunidad')->name('unificacoloniaacomunidad');


    // Catálogo de Ubicaciones
    Route::get('listUbicaciones/', 'Catalogos\Domicilio\UbicacionController@index')->name('listUbicaciones');
    Route::get('editUbicacion/{Id}', 'Catalogos\Domicilio\UbicacionController@editItem')->name('editUbicacion');
    Route::put('updateUbicacion', 'Catalogos\Domicilio\UbicacionController@updateItem')->name('updateUbicacion');
    Route::get('newUbicacion', 'Catalogos\Domicilio\UbicacionController@newItem')->name('newUbicacion');
    Route::post('createUbicacion', 'Catalogos\Domicilio\UbicacionController@createItem')->name('createUbicacion');
    Route::get('removeUbicacion/{id}', 'Catalogos\Domicilio\UbicacionController@removeItem')->name('removeUbicacion');

    Route::get('newUbicacionV2', 'Catalogos\Domicilio\UbicacionController@newItemV2')->name('newUbicacionV2');
    Route::post('createUbicacionV2', 'Catalogos\Domicilio\UbicacionController@createItemV2')->name('createUbicacionV2');
    Route::get('editUbicacionV2/{Id}', 'Catalogos\Domicilio\UbicacionController@editItemV2')->name('editUbicacionV2');
    Route::put('updateUbicacionV2', 'Catalogos\Domicilio\UbicacionController@updateItemV2')->name('updateUbicacionV2');

    // ROLES
    Route::get('asignaRoleList/{Id}','Catalogos\User\RoleController@indexV2')->name('asignaRoleList');
    Route::post('assignRoleToUser','Catalogos\User\RoleController@asignar')->name('assignRoleToUser');
    Route::post('unAssignRoleToUser','Catalogos\User\RoleController@desasignar')->name('unAssignRoleToUser');
    Route::get('getRoleUser/{Id}','Catalogos\User\RoleController@getItems')->name('getRoleUser');

    // PERMISSIONS
    Route::get('asignaPermissionList/{Id}','Catalogos\User\PermissionController@indexV2')->name('asignaPermissionList');
    Route::post('assignPermissionToUser','Catalogos\User\PermissionController@asignar')->name('assignPermissionToUser');
    Route::post('unAssignPermissionToUser','Catalogos\User\PermissionController@desasignar')->name('unAssignPermissionToUser');
    Route::get('getPermisionsUser/{Id}','Catalogos\User\PermissionController@getItems')->name('getPermisionsUser');

    // USUARIOS DEPENDENCIAS
    Route::get('asignaDependenciaList/{Id}','Catalogos\User\DependenciaUserController@index')->name('asignaDependenciaList');
    Route::post('assignDepToUser','Catalogos\User\DependenciaUserController@asignarDep')->name('assignDepToUser');
    Route::post('unAssignDepToUser','Catalogos\User\DependenciaUserController@desasignarDep')->name('unAssignDepToUser');
    Route::get('getDependenciasUser/{Id}','Catalogos\User\DependenciaUserController@getItems')->name('getDependenciasUser');

    // USUARIOS ESTATUS
    Route::get('asignaEstatusList/{Id}','Catalogos\User\EstatusController@index')->name('asignaEstatusList');
    Route::post('assignEstToUser','Catalogos\User\EstatusController@asignarEst')->name('assignEstToUser');
    Route::post('unAssignEstToUser','Catalogos\User\EstatusController@desasignarEst')->name('unAssignEstToUser');
    Route::get('getEstatusUser/{Id}','Catalogos\User\EstatusController@getItems')->name('getEstatusUser');

    // USUARIOS CATEGORIAS SERVICIOS
    Route::get('asignaServCatList/{Id}','Catalogos\User\ServicioCategoriaController@index')->name('asignaServCatList');
    Route::post('assignServCatToUser','Catalogos\User\ServicioCategoriaController@asignarServCat')->name('assignServCatToUser');
    Route::post('unAssignServCatToUser','Catalogos\User\ServicioCategoriaController@desasignarServCat')->name('unAssignServCatToUser');
    Route::get('getServCatUser/{Id}','Catalogos\User\ServicioCategoriaController@getItems')->name('getServCatUser');

    // USUARIOS ORIGENES
    Route::get('asignaOrigenesList/{Id}','Catalogos\User\OrigenesUserController@index')->name('asignaOrigenesList');
    Route::post('assignOrigenToUser','Catalogos\User\OrigenesUserController@asignarOrigen')->name('assignOrigenToUser');
    Route::post('unAssignOrigenToUser','Catalogos\User\OrigenesUserController@desasignarOrigen')->name('unAssignOrigenToUser');
    Route::get('getOrigenesUser/{Id}','Catalogos\User\OrigenesUserController@getItems')->name('getOrigenesUser');

    // USUARIOS PRIORIDADES
    Route::get('asignaPrioridadesList/{Id}','Catalogos\User\PrioridadesUserController@index')->name('asignaPrioridadesList');
    Route::post('assignPrioridadToUser','Catalogos\User\PrioridadesUserController@asignarPrioridad')->name('assignPrioridadToUser');
    Route::post('unAssignPrioridadToUser','Catalogos\User\PrioridadesUserController@desasignarPrioridad')->name('unAssignPrioridadToUser');
    Route::get('getPrioridadesUser/{Id}','Catalogos\User\PrioridadesUserController@getItems')->name('getPrioridadesUser');


    // EXTERNAL FILES
    Route::get('archivosConfig','Storage\StorageExternalFilesController@archivos_config')->name('archivosConfig');
    Route::post('subirArchivoBase/', 'Storage\StorageExternalFilesController@subirArchivoBase')->name('subirArchivoBase/');

//    Route::get('quitarArchivoBase/{driver}/{archivo}', 'Storage\StorageExternalFilesController@quitarArchivoBase')->name('quitarArchivoBase/');
    Route::post('quitarArchivoBase', 'Storage\StorageExternalFilesController@quitarArchivoBase')->name('quitarArchivoBase');

    Route::post('showFileListUserExcel1A','External\User\ListUserXLSXController@getListUserXLSX')->name('showFileListUserExcel1A');

    //    Route::post('showFileListNivelExcel','External\Nivel\ListNivelXLSXController@getListNivelXLSX')->name('showFileListNivelExcel');
    //    Route::post('showFileListParentescoExcel','External\Parentesco\ListParentescoXLSXController@getListParentescoXLSX')->name('showFileListParentescoExcel');
    //    Route::post('showFileListFamiliaExcel','External\Familia\ListFamiliaXLSXController@getListFamiliaXLSX')->name('showFileListFamiliaExcel');
    //    Route::post('showFileListRegFisExcel','External\Registros_Fiscales\ListaRegFisXLSXController@getListRegFisXLSX')->name('showFileListRegFisExcel');
    Route::post('getUserByRoleToXLSX','External\User\ListUserXLSXController@getUserByRoleToXLSX')->name('getUserByRoleToXLSX');

    Route::post('getModelListXlS/{model}','External\ListModelXLSXController@getListModelXLSX')->name('getModelListXlS');

    // Catálogo de Denuncias
    Route::get('listDenuncias/', 'Denuncia\DenunciaController@index')->name('listDenuncias');
    Route::get('editDenuncia/{Id}', 'Denuncia\DenunciaController@editItem')->name('editDenuncia');
    Route::put('updateDenuncia', 'Denuncia\DenunciaController@updateItem')->name('updateDenuncia');
    Route::get('addUserDenuncia/{Id}', 'Denuncia\DenunciaController@addUserItem')->name('addUserDenuncia');
    Route::put('updateAddUserDenuncia', 'Denuncia\DenunciaController@updateAddUserDenuncia')->name('updateAddUserDenuncia');
    Route::get('updateAddUserDenunciaGet/{id}/{usuario_id}', 'Denuncia\DenunciaController@updateAddUserDenunciaGet')->name('updateAddUserDenunciaGet');
    Route::get('removeAddUserDenuncia/{id0}/{id1}', 'Denuncia\DenunciaController@removeAddUserDenuncia')->name('removeAddUserDenuncia');
    Route::get('newDenuncia', 'Denuncia\DenunciaController@newItem')->name('newDenuncia');
    Route::post('createDenuncia', 'Denuncia\DenunciaController@createItem')->name('createDenuncia');
    Route::get('removeDenuncia/{id}', 'Denuncia\DenunciaController@removeItem')->name('removeDenuncia');
    Route::get('searchAdress/', 'Denuncia\DenunciaController@searchAdress')->name('searchAdress');
    Route::get('getUbi/{IdUbi}', 'Denuncia\DenunciaController@getUbi')->name('getUbi');
    Route::get('showModalSearchDenuncia/', 'Denuncia\DenunciaController@showModalSearchDenuncia')->name('showModalSearchDenuncia');
    Route::match(['get','put','post'],'findDataInDenuncia/', 'Denuncia\DenunciaController@findDataInDenuncia')->name('findDataInDenuncia');
    Route::post('showDataListDenunciaExcel1A/', 'External\Denuncia\ListDenunciaXLSXController@getListDenunciaXLSX')->name('showDataListDenunciaExcel1A');
    Route::post('showDataListDenunciaRespuestaExcel1A/', 'External\Denuncia\ListDenunciaXLSXController@showDataListDenunciaRespuestaExcel1A')->name('showDataListDenunciaRespuestaExcel1A');

    Route::get('cerrarDenuncia/{id}', 'Denuncia\DenunciaController@closeItem')->name('cerrarDenuncia');
    Route::get('firmarDenuncia/{id}', 'Denuncia\DenunciaController@signItem')->name('firmarDenuncia');

    Route::get('vistaDenuncia/{id}', 'Denuncia\DenunciaController@vistaDenuncia')->name('vistaDenuncia');

    /// DENUNCIAS CON AMBITO
    Route::get('listDenunciasAmbito1', 'Denuncia\DenunciaAmbitoController@index1')->name('listDenunciasAmbito1');
    Route::get('listDenunciasAmbito2', 'Denuncia\DenunciaAmbitoController@index2')->name('listDenunciasAmbito2');
    Route::get('listDenunciasAmbito16', 'Denuncia\DenunciaAmbitoController@index16')->name('listDenunciasAmbito16');
    Route::get('listDenunciasAmbito17', 'Denuncia\DenunciaAmbitoController@index17')->name('listDenunciasAmbito17');
    Route::get('listDenunciasAmbito18', 'Denuncia\DenunciaAmbitoController@index18')->name('listDenunciasAmbito18');
    Route::get('listDenunciasAmbito19', 'Denuncia\DenunciaAmbitoController@index19')->name('listDenunciasAmbito19');
    Route::get('listDenunciasAmbito20', 'Denuncia\DenunciaAmbitoController@index20')->name('listDenunciasAmbito20');
    Route::get('listDenunciasAmbito21', 'Denuncia\DenunciaAmbitoController@index21')->name('listDenunciasAmbito21');
    Route::get('editDenunciaAmbito/{ambito_dependencia}/{Id}', 'Denuncia\DenunciaAmbitoController@editItem')->name('editDenunciaAmbito');
    Route::put('updateDenunciaAmbito1', 'Denuncia\DenunciaAmbitoController@updateItem1')->name('updateDenunciaAmbito1');
    Route::put('updateDenunciaAmbito2', 'Denuncia\DenunciaAmbitoController@updateItem2')->name('updateDenunciaAmbito2');
    Route::get('addUserDenunciaAmbito/{Id}', 'Denuncia\DenunciaAmbitoController@addUserItem')->name('addUserDenunciaAmbito');
    Route::put('updateAddUserDenunciaAmbito', 'Denuncia\DenunciaAmbitoController@updateAddUserDenuncia')->name('updateAddUserDenunciaAmbito');
    Route::get('updateAddUserDenunciaAmbitoGet/{id}/{usuario_id}', 'Denuncia\DenunciaAmbitoController@updateAddUserDenunciaGet')->name('updateAddUserDenunciaAmbitoGet');
    Route::get('removeAddUserDenunciaAmbito/{id0}/{id1}', 'Denuncia\DenunciaAmbitoController@removeAddUserDenuncia')->name('removeAddUserDenunciaAmbito');
    Route::get('newDenunciaAmbito/{ambito_dependencia}/{ambito_estatus}', 'Denuncia\DenunciaAmbitoController@newItem')->name('newDenunciaAmbito');
    Route::post('createDenunciaAmbito1', 'Denuncia\DenunciaAmbitoController@createItem1')->name('createDenunciaAmbito1');
    Route::post('createDenunciaAmbito2', 'Denuncia\DenunciaAmbitoController@createItem2')->name('createDenunciaAmbito2');
    Route::get('removeDenunciaAmbito/{id}', 'Denuncia\DenunciaAmbitoController@removeItem')->name('removeDenunciaAmbito');
    Route::get('searchAdressAmbito/', 'Denuncia\DenunciaAmbitoController@searchAdress')->name('searchAdressAmbito');
    Route::get('getUbiAmbito/{IdUbi}', 'Denuncia\DenunciaAmbitoController@getUbi')->name('getUbiAmbito');
    Route::get('showModalSearchDenunciaAmbito/{ambito_dependencia}', 'Denuncia\DenunciaAmbitoController@showModalSearchDenuncia')->name('showModalSearchDenunciaAmbito');
    Route::match(['get','put','post'],'findDataInDenunciaAmbito/', 'Denuncia\DenunciaAmbitoController@findDataInDenuncia')->name('findDataInDenunciaAmbito');

    Route::post('showDataListDenunciaAmbitoExcel1A/', 'External\Denuncia\ListDenunciaAmbitoXLSXController@getListDenunciaAmbitoXLSX')->name('showDataListDenunciaAmbitoExcel1A');
    Route::post('showDataListDenunciaAmbitoRespuestaExcel1A/', 'External\Denuncia\ListDenunciaAmbitoXLSXController@showDataListDenunciaAmbitoRespuestaExcel1A')->name('showDataListDenunciaAmbitoRespuestaExcel1A');

    Route::get('cerrarDenunciaAmbito/{id}', 'Denuncia\DenunciaAmbitoController@closeItem')->name('cerrarDenunciaAmbito');
    Route::get('firmarDenunciaAmbito/{id}', 'Denuncia\DenunciaAmbitoController@signItem')->name('firmarDenunciaAmbito');


    Route::get('showModalDenunciaUserUpdate/{Id}', 'Denuncia\DenunciaUserAmbitoController@showModalDenunciaUserUpdate')->name('showModalDenunciaUserUpdate');
    Route::post('putModalDenunciaUserUpdate', 'Denuncia\DenunciaUserAmbitoController@putModalDenunciaUserUpdate')->name('putModalDenunciaUserUpdate');




});

Route::group(['middleware' => 'role:auth|Administrator|SysOp|DELEGADO|CIUDADANO|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE|USER_ARCHIVO_CAP|USER_ARCHIVO_ADMIN'], function () {

    Route::get('/home-ciudadano', 'HomeController@index_ciudadano')->name('home-ciudadano');

    Route::get('showEditProfilePassword/', 'Catalogos\User\UserDataController@showEditProfilePassword')->name('showEditProfilePassword/');
    Route::put('changePasswordUser/', 'Catalogos\User\UserDataController@changePasswordUser')->name('changePasswordUser/');
    Route::post('subirFotoProfile/', 'Storage\StorageProfileController@subirArchivoProfile')->name('subirArchivoProfile/');
    Route::get('quitarFotoProfile/', 'Storage\StorageProfileController@quitarArchivoProfile')->name('quitarArchivoProfile/');
    Route::get('searchUser/', 'Catalogos\User\UserDataController@searchUser')->name('searchUser');
    Route::get('getUser/{Id}', 'Catalogos\User\UserDataController@getUser')->name('getUser');

    // PIVOTE DENUNCIA DEPENDENCIA SERVICIO
    Route::get('listDenunciaDependenciaServicio/{Id}', 'Denuncia\DenunciaDependenciaServicioController@index')->name('listDenunciaDependenciaServicio');
    Route::get('addDenunciaDependenciaServicio/{Id}', 'Denuncia\DenunciaDependenciaServicioController@addItem')->name('addDenunciaDependenciaServicio');
    Route::post('postAddDenunciaDependenciaServicio', 'Denuncia\DenunciaDependenciaServicioController@postNew')->name('postAddDenunciaDependenciaServicio');
    Route::get('editDenunciaDependenciaServicio/{Id}', 'Denuncia\DenunciaDependenciaServicioController@editItem')->name('editDenunciaDependenciaServicio');
    Route::post('putAddDenunciaDependenciaServicio', 'Denuncia\DenunciaDependenciaServicioController@putEdit')->name('putAddDenunciaDependenciaServicio');
    Route::get('removeDenunciaDependenciaServicio/{id}', 'Denuncia\DenunciaDependenciaServicioController@removeItem')->name('removeDenunciaDependenciaServicio');

    Route::get('listDenunciaDependenciaServicioAmbito/{Id}', 'Denuncia\DenunciaDependenciaServicioAmbitoController@index')->name('listDenunciaDependenciaServicioAmbito');
    Route::get('addDenunciaDependenciaServicioAmbito/{Id}', 'Denuncia\DenunciaDependenciaServicioAmbitoController@addItem')->name('addDenunciaDependenciaServicioAmbito');
    Route::post('postAddDenunciaDependenciaServicioAmbito', 'Denuncia\DenunciaDependenciaServicioAmbitoController@postNew')->name('postAddDenunciaDependenciaServicioAmbito');
    Route::get('editDenunciaDependenciaServicioAmbito/{Id}', 'Denuncia\DenunciaDependenciaServicioAmbitoController@editItem')->name('editDenunciaDependenciaServicioAmbito');
    Route::post('putAddDenunciaDependenciaServicioAmbito', 'Denuncia\DenunciaDependenciaServicioAmbitoController@putEdit')->name('putAddDenunciaDependenciaServicioAmbito');

    // Catálogo de DENUNCIAS CIUDADANAS
    Route::get('listDenunciasCiudadanas/', 'Denuncia\DenunciaCiudadanaController@index')->name('listDenunciasCiudadanas');
    Route::get('editDenunciaCiudadana/{Id}', 'Denuncia\DenunciaCiudadanaController@editItem')->name('editDenunciaCiudadana');
    Route::put('updateDenunciaCiudadana', 'Denuncia\DenunciaCiudadanaController@updateItem')->name('updateDenunciaCiudadana');
    Route::get('newDenunciaCiudadana', 'Denuncia\DenunciaCiudadanaController@newItem')->name('newDenunciaCiudadana');
    Route::post('createDenunciaCiudadana', 'Denuncia\DenunciaCiudadanaController@createItem')->name('createDenunciaCiudadana');
    Route::get('removeDenunciaCiudadana/{id}', 'Denuncia\DenunciaCiudadanaController@removeItem')->name('removeDenunciaCiudadana');
    Route::get('searchAdressCiudadana/', 'Denuncia\DenunciaCiudadanaController@searchAdress')->name('searchAdressCiudadana');
    Route::get('getUbiCiudadana/{IdUbi}', 'Denuncia\DenunciaCiudadanaController@getUbi')->name('getUbiCiudadana');
    Route::get('/imprimir_denuncia/{Id}', 'External\Denuncia\HojaDenunciaController@imprimirDenuncia')->name('imprimirDenuncia/');

    // Catálogo de Respuestas
    Route::get('listRespuestas/{Id}', 'Denuncia\Respuesta\RespuestaController@index')->name('listRespuestas');
    Route::get('removeRespuesta/{id}', 'Denuncia\Respuesta\RespuestaController@removeItem')->name('removeRespuesta');
    Route::get('/showModalRespuestaNew/{denuncia_id}', 'Denuncia\Respuesta\RespuestaController@showModalRespuestaNew')->name('/showModalRespuestaNew');
    Route::get('showModalRespuestaEdit/{Id}', 'Denuncia\Respuesta\RespuestaController@showModalRespuestaEdit')->name('/showModalRespuestaEdit');
    // Route::post('saveRespuestaDen/', 'Denuncia\Respuesta\RespuestaController@saveRespuestaDen')->name('saveRespuestaDen');
    Route::match(['put','post'],'saveRespuestaDen/', 'Denuncia\Respuesta\RespuestaController@saveRespuestaDen')->name('saveRespuestaDen');

    Route::get('/RespuestaARespuestaNew/{denuncia_id}/{respuesta_id}', 'Denuncia\Respuesta\RespuestaController@RespuestaARespuestaNew')->name('/RespuestaARespuestaNew');
    Route::post('saveRespuestaARespuestaDen/', 'Denuncia\Respuesta\RespuestaController@saveRespuestaARespuestaDen')->name('saveRespuestaARespuestaDen');

    Route::get('listRespuestasCiudadanas/{Id}', 'Denuncia\Respuesta\RespuestaCiudadanaController@index')->name('listRespuestasCiudadanas');
    Route::get('removeRespuestaCiudadana/{id}', 'Denuncia\Respuesta\RespuestaCiudadanaController@removeItem')->name('removeRespuestaCiudadana');
    Route::get('/showModalRespuestaCiudadanaNew/{denuncia_id}', 'Denuncia\Respuesta\RespuestaCiudadanaController@showModalRespuestaCiudadanaNew')->name('/showModalRespuestaCiudadanaNew');
    Route::get('showModalRespuestaCiudadanaEdit/{Id}', 'Denuncia\Respuesta\RespuestaCiudadanaController@showModalRespuestaCiudadanaEdit')->name('/showModalRespuestaCiudadanaEdit');

    Route::get('listRespuestasCiudadanasAmbito/{Id}', 'Denuncia\Respuesta\RespuestaCiudadanaAmbitoController@indexAmbito')->name('listRespuestasCiudadanasAmbito');


    // Catálogo de Respuestas Mobile
    Route::get('listRespuestasMobile/{Id}', 'Denuncia\Respuesta\RespuestaMobileController@index')->name('listRespuestasMobile');
    Route::post('saveRespuestaMobileDen/', 'Denuncia\Respuesta\RespuestaMobileController@saveRespuestaMobileDen')->name('saveRespuestaMobileDen');


    // Catálogo de Imagenes
    Route::get('listImagenes/{Id}', 'Denuncia\Imagene\ImageneController@index')->name('listImagenes');
    Route::get('removeImagene/{id}', 'Denuncia\Imagene\ImageneController@removeItem')->name('removeImagene');
    Route::get('/showModalImageneNew/{denuncia_id}', 'Denuncia\Imagene\ImageneController@showModalImageneNew')->name('/showModalImageneNew');
    Route::get('showModalImageneEdit/{Id}', 'Denuncia\Imagene\ImageneController@showModalImageneEdit')->name('/showModalImageneEdit');
    // Route::post('saveImageneDen/', 'Denuncia\Imagene\ImageneController@saveImageneDen')->name('saveImageneDen');
    Route::match(['put','post'],'saveImageneDen/', 'Denuncia\Imagene\ImageneController@saveImageneDen')->name('saveImageneDen');

    Route::get('/ImagenAImagenNew/{denuncia_id}/{imagen_id}', 'Denuncia\Imagene\ImageneController@ImagenAImagenNew')->name('/ImagenAImagenNew');
    Route::post('saveImagenAImagenDen/', 'Denuncia\Imagene\ImageneController@saveImagenAImagenDen')->name('saveImagenAImagenDen');
    Route::get('removeImagenParent/{id}', 'Denuncia\Imagene\ImageneController@removeImagenParent')->name('removeImagenParent');

    Route::get('getServiciosFromDependencias/{id}', 'Denuncia\DenunciaController@getServiciosFromDependencias')->name('getServiciosFromDependencias');
    Route::get('getServiciosFromDependenciasAmbito/{id}', 'Denuncia\DenunciaAmbitoController@getServiciosFromDependenciasAmbito')->name('getServiciosFromDependenciasAmbito');

    Route::post('searchIdentical', 'Denuncia\DenunciaController@searchIdentical')->name('searchIdentical');

    Route::get('listDenunciasMobile', 'Denuncia\DenunciaMobileController@index')->name('listDenunciasMobile');
    Route::get('removeDenunciaMobile/{id}', 'Denuncia\DenunciaMobileController@removeDenunciaMobile')->name('removeDenunciaMobile');

    Route::post('searchIdenticalAmbito', 'Denuncia\DenunciaAmbitoController@searchIdenticalAmbito')->name('searchIdenticalAmbito');

});

Route::get('getNotificationDependencias/{dependencia_id_str}', 'External\Denuncia\AjaxController@getNotificationDependencias')->name('getNotificationDependencias');

Route::get('getServiciosFromDependencias/{id}', 'Denuncia\DenunciaController@getServiciosFromDependencias')->name('getServiciosFromDependencias');


//Route::get('enviar', ['as' => 'enviar', function () {
//    $data = ['link' => 'https://servimun.mx'];
//    Mail::send('emails.notificacion', $data, function ($message) {
//        $message->from('logydes@gmail.com', 'villahermosa.gob.mx');
//        $message->to('sentauro@gmail.com')->subject('Notificación');
//    });
//    return "Se envío el email";
//}]);
//
Route::get('/imprimir_denuncia/{uuid}', 'External\Denuncia\HojaDenunciaController@imprimirDenuncia')->name('imprimir_denuncia/');
Route::get('/imprimir_denuncia_respuesta/{uuid}', 'External\Denuncia\HojaDenunciaController@imprimirDenunciaConRespuestas')->name('imprimir_denuncia_respuesta/');
Route::get('/imprimir_denuncia_archivo/{uuid}', 'External\Denuncia\HojaDenunciaArchivoController@imprimirDenuncia')->name('imprimir_denuncia_archivo/');

Route::get('/imprimir_denuncia_ambito_archivo/{uuid}', 'External\Denuncia\HojaDenunciaAmbitoArchivoController@imprimirDenuncia')->name('imprimir_denuncia_ambito_archivo/');
Route::get('/imprimir_denuncia_ambito_respuesta/{uuid}', 'External\Denuncia\HojaDenunciaAmbitoController@imprimirDenunciaConRespuestas')->name('imprimir_denuncia_ambito_respuesta/');

//Route::group(['middleware' => 'cors'], function(){


    Route::get('fire', function () {
        // this fires the event
        event(new App\Events\APIDenunciaEvent(1,1));
        return "event fired";
    });

    Route::get('test', function () {
        // this checks for the event
        return "event test";
    });


    Route::get('test_send_ios/',function (){
        $fcm = new SendNotificationFCM();
        $response = $fcm->sendNotification(1,1,'IPHONE','fgfGIjX4wkYvkY4m7HFHrb:APA91bE9RMFZLUSmGUTt4Glg50UDG5z3ywYqMzTC8KElviKObvIekasQihVm4ZpZvzfSSfeBRGwKE2sXvyu2le9xHJ4UQbJM0jjP1-1PAJNLXcYAsc6snyhaOxpsc_LvMDeuN5aPDnrZ','hola','carlos');
    });

    Route::get('test_send_android/',function (){
        $fcm = new SendNotificationFCM();
            $response = $fcm->sendNotification(1,1,'ANDROID','ezffbR76Sc6wlFKNm02ajT:APA91bH-vk23O3lmEFQCEqASli93-D4IVWkRccwRIUsmJvtxBrv_QGVNbHZ40aW-DzYOEu5zy6LpwKXx9NtPL02AVRsVJMXIAw0wdIHu3orkXaifx-H8YOZh313ObhbYjtnaS12TPEmZ','hola android','carlos android');
    });

    Route::get('getServiciosFromDependenciasAxios/{id}', 'Denuncia\ServicioController@getServiciosFromDependenciasAxios')->name('getServiciosFromDependenciasAxios');



//Route::get('/login2', function () {
//    return view('auth.login_v2');
//})->name('login2');

//Route::get('/register', function () {
//    // Añadir lógica de registro
//})->name('register');
//
//Route::get('/password/request', function () {
//    // Añadir lógica para recuperar contraseña
//})->name('password.request');
//

//    Route::get('/enviar-correo', function () {
//        Mail::send('vendor.mail.html.mailtoenlace', [], function ($message) {
//            $message->to('carhid@yahoo.com')
//                ->subject('Bienvenido a SIAC');
//        });
//    return "Correo enviado exitosamente.";
//    });


//});

