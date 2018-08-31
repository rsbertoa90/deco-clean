<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


        Route::get('/seminars','SeminarController@getAll');
        // Route::get('/seminar/create-form','SeminarController@createForm');

        Route::get('/events','EventController@getAll');
        Route::get('/event/create-form','EventController@createForm');
        
        // por id de evento traer nombre de seminario
        Route::get('/get-seminar-title/{id}','EventController@getSeminarName');

        Route::get('/activeCitys','CityController@getActiveCitys');
        Route::get('/active-cities','CityController@getActiveCitys');

        Route::get('/events/city/{city}','EventController@getByCity');

        Route::get('/events/online','EventController@getOnlineEvents');
        
        Route::get('/events/{seminar}','EventController@getBySeminar');

        Route::get('/event/future/{seminar}','EventController@futureBySeminar');

        Route::get('/payment_types','PaymentController@types');

        Route::get('/inscriptions/unregistered/presencial/{user}','InscriptionController@getPresencials');
        
        Route::get('/inscriptions/unregistered/online/{user}','InscriptionController@getOnline');

        Route::get('/payments/unregistered/{user}','PaymentController@getByUnRUser');

        Route::get('/countrys','CityController@countrys');

        Route::get('/states','CityController@states');
        Route::get('/cities','CityController@cities');

        Route::get('/cities/{state}','CityController@citiesFrom');

        Route::get('/unregistered/user/{user}','UserController@getUnregistered');
       
        Route::get('/events/by-city/{city}','EventController@getByCity');

        Route::get('/event/{id}','EventController@getById');

        Route::get('/mplistener','MPController@getResponse');
        
