<?php

use App\Http\Controllers\API\DenunciaAPIController;
use App\Http\Controllers\API\UserAPIController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix' => 'v1'], function () {

    Route::post('/login_test', [UserAPIController::class, 'userLogin2']);
    Route::post('/login', [UserAPIController::class, 'userLogin']);
    Route::post('/mobile/token', [UserAPIController::class, 'userMobileToken']);
    Route::post('/register', [UserAPIController::class, 'register']);
    Route::post('/user/recovery/password', [UserAPIController::class, 'recoveryPassword']);

    Route::middleware('auth:sanctum')->get('/user', function(Request $request){
        return $request->user();
    });
    Route::group(['middleware' => 'auth:sanctum'], function () {

        // Useers should
        Route::get('/users', [UserAPIController::class, 'users'])->name('users');
        Route::get('/user/{user}', [UserAPIController::class, 'userId']);
        Route::get('/user/curp/{curp}', [UserAPIController::class, 'userCURP']);
        Route::post('/user/image', [UserAPIController::class, 'userImage']);
        Route::post('/user/change/password', [UserAPIController::class, 'userChangePassword']);
        Route::post('/user/change/email', [UserAPIController::class, 'userChangeEmail']);
        Route::post('/user/delete', [UserAPIController::class, 'userDelete']);

        // Denunciases should
        Route::post('/denuncia/insert', [DenunciaAPIController::class, 'insertDenunciaMobile']);
        Route::post('/denuncia/getlist', [DenunciaAPIController::class, 'getDenuncias']);

        // Ads Images Denucnas should
        Route::post('/denuncia/add/image', [DenunciaAPIController::class, 'addImageDenunciaMobile']);
        Route::post('/denuncia/getimagesdenuncialist', [DenunciaAPIController::class, 'getImagesDenunciaList']);
        Route::post('/denuncia/add/respuesta', [DenunciaAPIController::class, 'addRespuestaDenunciaMobile']);
        Route::post('/denuncia/list/imagenes', [DenunciaAPIController::class, 'getImagenesFromDenunciaMobile']);
        Route::post('/denuncia/list/respuestas', [DenunciaAPIController::class, 'getRespuestasFromDenunciaMobile']);


        Route::get('fire', function () {
            // this fires the event
            event(new App\Events\APIDenunciaEvent(1,1));
            return "event fired";
        });

        Route::middleware('avaluateUbicación')->get('/ubi', function(Request $request){
            //return $request->user();
        });


    });


});
