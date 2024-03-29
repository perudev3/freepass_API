<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**Welcome**/
Route::get('/data_customers_ifo', 'WelcomeController@DataCustomerIfo');
Route::post('/data_customers', 'WelcomeController@DataCustomer');
Route::get('/categorias/{id}', 'WelcomeController@GetCategoryRestaurants');
Route::get('/restaurante/search', 'WelcomeController@SearchRestaurant');

Route::get('/paises', 'PanelController@Paises');
Route::post('/ciudades', 'PanelController@Ciudades');
Route::get('/categorias', 'PanelController@Categorias');


/**Authentication Social**/
Route::group(['prefix' => 'auth'], function () {
    Route::get('/{provider}', 'Auth\LoginController@redirectToProvider');
    Route::get('/{provider}/callback', 'Auth\LoginController@handleProviderCallback');    
});

/**Reset Password**/
Route::post('/reset_password', 'WelcomeController@ResetPassword');

Route::group(['prefix' => 'auth'], function () {

    Route::post('api_login', 'AuthController@api_login');
    Route::post('api_enviar_email', 'AuthController@GenerarCodigo');
    Route::post('api_register', 'AuthController@api_register');    
    Route::post('api_register_comercio', 'AuthController@api_register_comercio');
    
    /**Autenticacion Invitacion Lista**/
    Route::post('/post_register_invitados', 'RestauranteController@RegisterListaInvitados');

    

    Route::group(['middleware' => 'auth:api'], function() {

        /**Confirmación Invitacion Lista**/
        Route::post('/confirmar_aceptar_invitacion', 'RestauranteController@AceptarInvitacion');

        Route::post('logout', 'AuthController@logout');
        
        /*Traer restaurantes favoritos de usuario autenticado */
        Route::get('/user/favorites', 'WelcomeController@GetFavoritesRestaurantsUser');

        //////////////////////////////////----------------MASTER----------------//////////////////////////////////////   

        Route::group(['prefix' => 'master'], function() {
            Route::get('comerciosusuarioslista', 'Mastercontroller@ComerciosUsuariosLista');
            Route::get('superusuarioslista', 'Mastercontroller@SuperUsuariosLista');
            Route::get('roles_categorias', 'Mastercontroller@RolesCategoriasMaster');
            
            Route::post('crear_usuario_comercio', 'Mastercontroller@CrearComercioUsuario');
            Route::post('searchusuario', 'Mastercontroller@SearchUsuario');

            Route::post('crear_superusuario', 'Mastercontroller@CrearSuperUsuario');
        });

        //////////////////////////////////----------------RESTAURANTE----------------//////////////////////////////////////   

        Route::group(['prefix'=>'restaurante'], function(){

            /**Cpanel**/
            Route::get('/cpanel_data', 'PanelController@cpanel');

            /**Informacion**/
            Route::get('/information', 'RestauranteController@Information');
            Route::post('/register_data_ifo', 'RestauranteController@RegisterDataIfo');
            Route::post('/imgs_restaurante', 'RestauranteController@RegisterImgs');
            Route::post('/delete_imgs_restaurante', 'RestauranteController@DeleteImgsRestaurante');

            /**Zona**/
            Route::get('/list_zonas', 'RestauranteController@ListZonas');
            Route::post('/register_zonas', 'RestauranteController@RegisterZonas');
            Route::post('/search_zonas', 'RestauranteController@SearchZonas');

            /**Listas**/
            Route::get('/data_lista', 'RestauranteController@DataListas');     
            Route::post('/generate_link', 'RestauranteController@GenerateLink');
            Route::get('/data_invitados/{lista_codes_id}', 'RestauranteController@DataInvitados');


            /**Eventos**/
            Route::get('/list_eventos', 'RestauranteController@ListEventos'); 
            Route::get('/lista_zonas_restaurante', 'RestauranteController@ListZonasRestaurante');     
            //preguntar         
            Route::post('/register_eventos', 'RestauranteController@RegisterEventos');

            /**Reservas**/
            Route::get('/reservas_data', 'RestauranteController@Reservas');//preguntar
            Route::post('/reserva_status', 'RestauranteController@ReservasStatus');       

        });
        
        /////////////////////-----------USUARIO------------///////////////////////

        /**Agregar a favoritos**/
        Route::post('/add_favoritos', 'WelcomeController@AddFavoritos');

        /**Billetera virtual del Usuario**/
        //Route::get('/wallet_user', 'WelcomeController@WalletUser');//preguntar no hay tabla
        //Route::post('/recarga_coin', 'WelcomeController@RecargaCoin');//preguntar no hay tabla

        /**Generar QR Pass**/
        //Route::get('/generate_qr_regular/{customer_ifo_id}/{date}', 'WelcomeController@GenerateQRRegular');//tablas no preparadas

        /**Reservas del Usuario**/
        //Route::get('/get_mis_reservas', 'WelcomeController@GetMyReservas');//error tabla


        /**Home no se tiene en cuenta**/
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('user', 'AuthController@user');
    });

  

});
