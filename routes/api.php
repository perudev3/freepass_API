<?php

use Illuminate\Support\Facades\Route;


/**Authentication Social**/
Route::group(['prefix' => 'auth'], function () {
    Route::get('/{provider}', 'Auth\LoginController@redirectToProvider');
    Route::get('/{provider}/callback', 'Auth\LoginController@handleProviderCallback');    
});
Route::group(['prefix' => 'auth'], function () {
    Route::post('api_login', 'AuthController@api_login');
    Route::post('api_enviar_email', 'AuthController@GenerarCodigo');
    Route::post('api_register', 'AuthController@api_register');    
    Route::post('api_register_comercio', 'AuthController@api_register_comercio');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('logout', 'AuthController@logout');
        Route::group(['prefix' => 'master'], function() {
            Route::post('crear_superusuario', 'Mastercontroller@CrearSuperUsuario');
        });
    });
});
Route::apiResource('eventos', 'ApiBeta\EventoController');
Route::get('ultimos_eventos', 'ApiBeta\EventoController@lastEvents');
Route::post('eventos_filtro', 'ApiBeta\EventoController@searchEventsTipos');

Route::apiResource('tipos', 'ApiBeta\TipoController');
