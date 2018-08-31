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

Auth::routes();

Route::get('/logout','Auth\LoginController@logout');

Route::get('/resources/loggedUser','UserController@getLoggedUser');

Route::middleware('CheckAdmin')->prefix('super')->group(function () {

    Route::get('/users','SuperController@usersPanel');

   Route::get('/getUsers','SuperController@getUsers'); 

   Route::put('/changeRole/{user}/{role}', 'SuperController@changeRole');
});

Route::middleware('CheckAdmin')->prefix('admin')->group(function () {

    Route::get('/', 'AdminController@dashboard');

    Route::get('/crud' , 'AdminController@crudInterface');

    
    Route::get('/inscripciones', 'AdminController@inscriptionInterface');
    Route::post('/unregistered/inscription','InscriptionController@unregistered');
    Route::delete('/unregistered/inscription/delete/{inscription}','InscriptionController@delete');

    Route::get('/inscriptions/user-search/{name}','InscriptionController@userSearch');

    Route::post('/unregistered/payment','PaymentController@unregisteredPayment');
    Route::put('/payments/change-status','PaymentController@changeStatus');

    Route::put('/seminar/', 'SeminarController@edit');
    Route::delete('/seminar/{id}', 'SeminarController@delete');
    Route::post('/seminar/create', 'SeminarController@create');

    Route::post('/event','EventController@create');
    Route::put('/event','EventController@update');
    Route::put('/event/update-city','EventController@updateCity');
    Route::delete('/event/{id}','EventController@delete');
});


Route::get('/',  'HomeController@index');

Route::get('/getUser','UserController@getLoggedUser');

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/fblogin','LoginController@fblogin');

Route::get('/fbloginsuccess','LoginController@fbfindOrRegister');
Route::get('/fblogincanceled','LoginController@fbcancel');
Route::get('/fbdeldata','LoginController@fbdeldata');

// OAuth Routes
Route::get('/auth/facebook', 'Auth\LoginController@redirectToProvider');

Route::get('/auth/facebook/callback', 'Auth\LoginController@handleProviderCallback');

Route::post('/checkout','PaymentController@checkout');

     Route::post('/mplistener','MPController@getResponse');
        Route::get('/mplistener','MPController@getResponse');
        Route::put('/mplistener','MPController@getResponse');
        