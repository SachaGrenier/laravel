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

Route::get('edituser/{id}', function ($id) {
    return view('edituser')->with('id', $id);
})->name('edituser');

Route::get('editcontact/{id}', function ($id) {
    return view('editcontact')->with('id', $id);
})->name('editcontact');

Route::get('editapplicant/{id}', function ($id) {
    return view('editapplicant')->with('id', $id);
})->name('editapplicant');

Route::get('editcompany/{id}', function ($id) {
    return view('editcompany')->with('id', $id);
})->name('editcompany');


Route::get('storeticket', function() {
  return view('createticket');
});

Route::post('storeticket', 'TicketController@store');

Route::post('storeuser', 'AdminController@store');

Route::post('storetitle', 'AdminController@storetitle');

Route::post('storesector', 'AdminController@storesector');

Route::post('login', 'LoginController@index');

Route::post('storeimage', 'HomeController@updateProfilPicture');

Route::post('updatelogo', 'ContactController@updatelogo');

Route::post('modifypassword', 'HomeController@updatePassword');

Route::post('modifyemail', 'HomeController@updateEmail');

Route::post('deleteuser', 'AdminController@deleteuser');

Route::post('archiveticket', 'TicketController@archiveticket');

Route::post('updateticket', 'TicketController@updateticket');

Route::post('updateuser', 'AdminController@updateuser');

Route::post('updateapplicant', 'ContactController@updateapplicant');

Route::post('updatecontact', 'ContactController@updatecontact');

Route::post('updatecompany', 'ContactController@updatecompany');

Route::post('resetpassword', 'AdminController@resetpassword');

Route::post('deletesector', 'AdminController@deletesector');

Route::post('deletetitle', 'AdminController@deletetitle');

Route::post('storecontact', 'ContactController@storecontact');

Route::post('pdfview', 'ItemController@pdfview');

Route::post('storecompany', 'ContactController@storecompany');

Route::post('storeapplicant', 'ContactController@storeapplicant');

Route::post('deletecompany', 'ContactController@deletecompany');

Route::post('deletecontact', 'ContactController@deletecontact');

Route::get('login', function() {
  return view('login');
})->name('login');


Route::get('contact', function () {
    return view('contacts');
})->name('contact');

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

Route::get('/getusers/{sector}', ['uses' =>'AjaxController@getUsers']);


Route::get('logout', function () {
    session()->flush();
    return redirect()->route('login');
})->name('logout');


Route::get('pdfview',array('as'=>'pdfview','uses'=>'ItemController@pdfview'));
