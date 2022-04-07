<?php

use Illuminate\Support\Facades\Route;


/**Authentication Social**/
Route::group(['prefix' => 'auth'], function () {
    //rutas master
    Route::middleware(['auth:api', 'roles:Master'])->group(function () {
        
    });

    Route::get('ultimos_eventos', 'APIBeta\EventoController@lastEvents');
    Route::get('buscarEventos', 'APIBeta\EventoController@searchEvents');
    Route::post('eventos_filtro', 'APIBeta\EventoController@searchEventsTipos');
    
    Route::get('eventos', 'APIBeta\EventoController@index');
    //listar eventos del usuario autenticado
    Route::get('eventos-usuario','APIBeta\EventoController@myEvents');
    Route::get('eventos/{id}', 'APIBeta\EventoController@show');
    Route::post('eventos', 'APIBeta\EventoController@store');
    Route::put('eventos/{id}', 'APIBeta\EventoController@update');
    Route::delete('eventos/{id}', 'APIBeta\EventoController@destroy');
    Route::get('zonasevento/{evento}', 'APIBeta\EventoController@zonasEvento');
    Route::get('listArtistas', 'APIBeta\EventoController@listArtistas');
    Route::post('registrar_imagenes_evento/{evento}', 'APIBeta\ImageController@store');

    Route::delete('eliminar_imagen/{imagen}', 'APIBeta\ImageController@destroy');

    Route::get('zonas', 'APIBeta\ZonaController@index');
    Route::get('zonas-usuario','APIBeta\ZonaController@myZonas');
    Route::get('zonas/{id}', 'APIBeta\ZonaController@show');
    Route::post('zonas', 'APIBeta\ZonaController@store');
    Route::put('zonas/{id}', 'APIBeta\ZonaController@update');
    Route::delete('zonas/{id}', 'APIBeta\ZonaController@destroy');

    Route::get('artistas', 'APIBeta\ArtistaController@index');
    Route::get('artistas/{id}', 'APIBeta\ArtistaController@show');
    Route::post('artistas', 'APIBeta\ArtistaController@store');
    Route::put('artistas/{id}', 'APIBeta\ArtistaController@update');
    Route::delete('artistas/{id}', 'APIBeta\ArtistaController@destroy');
    
    
    Route::get('tipos', 'APIBeta\TipoController@index');
    Route::get('tipos/{id}', 'APIBeta\TipoController@show');
    Route::post('tipos', 'APIBeta\TipoController@store');
    Route::put('tipos/{id}', 'APIBeta\TipoController@update');
    Route::delete('tipos/{id}', 'APIBeta\TipoController@destroy');

    Route::get('listas', 'APIBeta\ListaController@index');
    Route::put('listas/{id}', 'APIBeta\ListaController@update');
    Route::delete('listas/{id}', 'APIBeta\ListaController@destroy');
    Route::post('registrar_listas/{evento}', 'APIBeta\ListaController@store');

    Route::post('registrar_invitado', 'APIBeta\InvitadoController@store');

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



