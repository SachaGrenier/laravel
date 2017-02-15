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
	if(session('id'))
    	return view('index');
	else
    	return view('login');

})->name('index');

Route::get('createticket', function () {
  return view('createticket');
})->name('createticket');

Route::get('ticket/{id}', function ($id) {
    return view('ticket')->with('id', $id);
})->name('ticket');

Route::get('storeticket', function() {
  return view('createticket');
});

Route::post('storeticket', 'TicketController@store');

Route::post('storeuser', 'AdminController@store');

Route::post('login', 'LoginController@index');

Route::post('storeimage', 'HomeController@updateProfilPicture');

Route::post('modifypassword', 'HomeController@modifyPassord');


Route::get('login', function() {
  return view('login');
})->name('login');


Route::get('applicant', function () {
    return view('applicant');
})->name('applicant');

Route::get('admin', function () {
    return view('admin');
})->name('admin');

Route::get('settings', function () {
    return view('parametres');
})->name('settings');

Route::get('ticket', function () {
    return view('index');
});

Route::get('ajax',function(){
   return view('message');
});


Route::get('/gettickets/{type}', ['uses' =>'AjaxController@index']);


Route::get('logout', function () {
    session()->flush();
    return redirect()->route('login');
})->name('logout');

