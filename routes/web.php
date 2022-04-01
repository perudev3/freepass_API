<?php

//use App\Events\ReservasStatusChangedEvent;
use Illuminate\Support\Facades\Route;


Route::get('testt', fn () => phpinfo());
/**Verifity Authentication**/
Route::group(['middleware' => 'auth'], function () {

    //////////////////////////////////----------------CPANEL----------------//////////////////////////////////////

    /**Panel de control de Administrador**/
    Route::get('/cpanel', 'PanelController@index')->name('cpanel');

    /**Panel de control del Organizador**/
    Route::get('/cpanel', 'PanelController@index')->name('cpanel');


    //////////////////////////////////----------------RESTAURANTE----------------//////////////////////////////////////   

    Route::group(['prefix'=>'restaurante'], function(){

        /**Cpanel**/
        Route::get('/cpanel_data', 'PanelController@cpanel');

        /**Informacion**/
        Route::get('/registro', function () {
            return view('restaurantes.informacion');
        });

        /**Zona**/
        Route::get('/zonas', function () {
            return view('restaurantes.zonas');
        });

        Route::get('/zonas/create', function () {
            return view('restaurantes.zonas');
        });

        /**Mis Listas**/
        Route::get('/my-listas', function () {
            return view('restaurantes.mislistas');
        });        

        Route::get('/my-listas/create', function () {
            return view('restaurantes.mislistas');
        });                

        Route::get('/my-listas/view', function () {
            return view('restaurantes.mislistas');
        });      

        /**Plan**/
        Route::get('/plan', function () {
            return view('restaurantes.plan');
        });

        /**Eventos**/
        Route::get('/eventos', function () {
            return view('restaurantes.eventos');
        });

        Route::get('/eventos/create', function () {
            return view('restaurantes.eventos');
        });

        /**Reservas**/
        Route::get('/reservas', function () {
            return view('restaurantes.reservas');
        });     

    });
    
    //////////////////////////////////----------------USUARIO----------------//////////////////////////////////////

    /**Billetera virtual del Usuario**/
    Route::get('/wallet', function () {
        return view('wallet_pass');
    });

    /**Reservas del Usuario**/
    Route::get('/mis_reservas', function () {
        return view('mis_reservas');
    });


});

Route::get('{no_slug}', 'WelcomeController@ViewProfile')->name('view_profile');

//Route::post('/dateweekend', 'WelcomeController@DateWeek');


/* Route::get('/fire', function () {
   event(new ReservasStatusChangedEvent);
   return 'Fired';
}); */







