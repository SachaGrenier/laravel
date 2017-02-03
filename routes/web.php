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

Route::get('/', function () {
    return view('index');
});
Route::get('createticket', function () {
  return view('createticket');
});


Route::get('ticket/{id}', ['as' => 'ticket', 'uses' => 'TicketController@index']);

Route::get('storeticket', function() {
  return view('createticket');
});



Route::post('storeticket', 'TicketController@store');

Route::get('applicant', function () {
    return view('applicant');
});

Route::get('admin', function () {
    return view('login');
});

Route::get('parametres', function () {
    return view('parametres');
});