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

Route::middleware('CheckAdmin')->prefix('admin')->group(function () {

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
});



Route::get('/',  'HomeController@index');


Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

