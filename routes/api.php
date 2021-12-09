<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**Modulo de Usuarios la ingresar a FreePass**/
Route::get('/data_customers_ifo', 'WelcomeController@DataCustomerIfo');
Route::post('/data_customers', 'WelcomeController@DataCustomer');
Route::get('/paises', 'PanelController@Paises');
Route::post('/ciudades', 'PanelController@Ciudades');
Route::get('/categorias', 'PanelController@Categorias');


/**Registro de Invitacion**/
Route::group(['prefix' => '/{name_restaurante}/{codigo_invitacion}'], function () {
    
    Route::post('/post_register_invitados', 'RestauranteController@RegisterListaInvitados')->name('post_register_invitados');

});
Route::post('/confirmar_aceptar_invitacion', 'RestauranteController@AceptarInvitacion')->name('confirmar_aceptar_invitacion');


/**Authentication Social**/
Route::group(['prefix' => 'auth'], function () {
    Route::get('/{provider}', 'Auth\LoginController@redirectToProvider');
    Route::get('/{provider}/callback', 'Auth\LoginController@handleProviderCallback');    
});



Route::group(['prefix' => 'auth'], function () {

    Route::post('api_login', 'AuthController@api_login');
    Route::post('api_register', 'AuthController@api_register');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');


        //////////////////////////////////----------------RESTAURANTE----------------//////////////////////////////////////   

        Route::group(['prefix'=>'restaurante'], function(){

            /**Cpanel**/
            Route::get('/cpanel_data', 'PanelController@cpanel');

            /**Informacion**/
            Route::get('/information', 'RestauranteController@Information');
            Route::post('/register_data_ifo', 'RestauranteController@RegisterDataIfo');

            /**Zona**/
            Route::get('/list_zonas', 'RestauranteController@ListZonas');
            Route::post('/register_zonas', 'RestauranteController@RegisterZonas');

            /**Mis Listas**/
            Route::get('/data_lista', 'RestauranteController@DataListas');     
            Route::post('/generate_link', 'RestauranteController@GenerateLink');
            Route::get('/data_invitados/{lista_codes_id}', 'RestauranteController@DataInvitados');


            /**Eventos**/
            Route::get('/list_eventos', 'RestauranteController@ListEventos'); 
            Route::get('/lista_zonas_restaurante', 'RestauranteController@ListZonasRestaurante');              
            Route::post('/register_eventos', 'RestauranteController@RegisterEventos');

            /**Reservas**/
            Route::get('/reservas_data', 'RestauranteController@Reservas');
            Route::post('/reserva_status', 'RestauranteController@ReservasStatus');       

        });
        
        //////////////////////////////////----------------USUARIO----------------//////////////////////////////////////

        /**Billetera virtual del Usuario**/
        Route::get('/wallet_user', 'WelcomeController@WalletUser');
        Route::post('/recarga_coin', 'WelcomeController@RecargaCoin');

        /**Generar QR Pass**/
        Route::get('/generate_qr_regular/{customer_ifo_id}/{date}', 'WelcomeController@GenerateQRRegular');

        /**Reservas del Usuario**/
        Route::get('/get_mis_reservas', 'WelcomeController@GetMyReservas');


        /**Home no se tiene en cuenta**/
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('user', 'AuthController@user');
    });

    

});