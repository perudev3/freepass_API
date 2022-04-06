<?php

use Illuminate\Support\Facades\Route;


/**Authentication Social**/
Route::group(['prefix' => 'auth'], function () {
    //rutas master
    Route::middleware(['auth:api', 'roles:Master'])->group(function () {
        
    });

    Route::get('ultimos_eventos', 'ApiBeta\EventoController@lastEvents');
    Route::get('buscarEventos', 'ApiBeta\EventoController@searchEvents');
    Route::post('eventos_filtro', 'ApiBeta\EventoController@searchEventsTipos');
    
    Route::get('eventos', 'ApiBeta\EventoController@index');
    //listar eventos del usuario autenticado
    Route::get('eventos-usuario','ApiBeta\EventoController@myEvents');
    Route::get('eventos/{id}', 'ApiBeta\EventoController@show');
    Route::post('eventos', 'ApiBeta\EventoController@store');
    Route::put('eventos/{id}', 'ApiBeta\EventoController@update');
    Route::delete('eventos/{id}', 'ApiBeta\EventoController@destroy');
    Route::get('zonasevento/{evento}', 'ApiBeta\EventoController@zonasEvento');
    Route::get('listArtistas', 'ApiBeta\EventoController@listArtistas');
    Route::post('registrar_imagenes_evento/{evento}', 'ApiBeta\ImageController@store');

    Route::delete('eliminar_imagen/{imagen}', 'ApiBeta\ImageController@destroy');

    Route::get('zonas', 'ApiBeta\ZonaController@index');
    Route::get('zonas-usuario','ApiBeta\ZonaController@myZonas');
    Route::get('zonas/{id}', 'ApiBeta\ZonaController@show');
    Route::post('zonas', 'ApiBeta\ZonaController@store');
    Route::put('zonas/{id}', 'ApiBeta\ZonaController@update');
    Route::delete('zonas/{id}', 'ApiBeta\ZonaController@destroy');

    Route::get('artistas', 'ApiBeta\ArtistaController@index');
    Route::get('artistas/{id}', 'ApiBeta\ArtistaController@show');
    Route::post('artistas', 'ApiBeta\ArtistaController@store');
    Route::put('artistas/{id}', 'ApiBeta\ArtistaController@update');
    Route::delete('artistas/{id}', 'ApiBeta\ArtistaController@destroy');
    
    
    Route::get('tipos', 'ApiBeta\TipoController@index');
    Route::get('tipos/{id}', 'ApiBeta\TipoController@show');
    Route::post('tipos', 'ApiBeta\TipoController@store');
    Route::put('tipos/{id}', 'ApiBeta\TipoController@update');
    Route::delete('tipos/{id}', 'ApiBeta\TipoController@destroy');

    Route::get('listas', 'ApiBeta\ListaController@index');
    Route::put('listas/{id}', 'ApiBeta\ListaController@update');
    Route::delete('listas/{id}', 'ApiBeta\ListaController@destroy');
    Route::post('registrar_listas/{evento}', 'ApiBeta\ListaController@store');

    Route::post('registrar_invitado', 'ApiBeta\InvitadoController@store');

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



