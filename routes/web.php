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

Route::post('storetitle', 'AdminController@storetitle');

Route::post('storesector', 'AdminController@storesector');

Route::post('login', 'LoginController@index');

Route::post('storeimage', 'HomeController@updateProfilPicture');

Route::post('modifypassword', 'HomeController@updatePassword');

Route::post('modifyemail', 'HomeController@updateEmail');

Route::post('deleteuser', 'AdminController@deleteuser');

Route::post('archiveticket', 'TicketController@archiveticket');

Route::post('updateticket', 'TicketController@updateticket');




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

