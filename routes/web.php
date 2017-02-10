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
})->name('index');

Route::get('createticket', function () {
  return view('createticket');
});

Route::get('ticket/{id}', function ($id) {
    return view('ticket')->with('id', $id);
})->name('ticket');

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

Route::get('/ticket', function () {
    return view('ticket');
});

Route::get('ajax',function(){
   return view('message');
});


Route::get('/gettickets/{type}', ['uses' =>'AjaxController@index']);
