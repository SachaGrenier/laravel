<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    public function index(Request $request)
    {
         $this->validate($request, [
        'login' => 'required|max:50',
        'password' => 'required',
            ]);

        $user = User::where('login', $request->input('login'))->get();

        if (isset($user[0]))
        { 
          if (Hash::check($request->input('password'), $user[0]->password))         	
          	{ 
          		$request->session()->put('id', $user[0]->id);
              Session::flash('status', 'Bienvenue '.$user[0]->first_name.' '.$user[0]->last_name.''); 
              Session::flash('class', 'alert-success');   
          		return redirect()->route('index');
          	}
          	else          	
          		return redirect('login')->with('status', 'Login ou mot de passe <strong>erronés</strong>');          	
        }
        else          
            	return redirect('login')->with('status', 'Login ou mot de passe <strong>erronés</strong>');
    }
}
