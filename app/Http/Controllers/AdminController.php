<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;


class AdminController extends Controller
{
    public function store(request $request)
    {
    	echo '<pre>';
        print_r($request->input());
        echo '</pre>';

         $this->validate($request, [
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'email' => 'required|max:255',
            ]);
		
        $user = new User;

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->login = $request->input('first_name').'_'.$request->input('last_name');
        $user->password = Hash::make('secret');       

        $user->picture_path = 'img/profilepictures/default.jpg';
		
		if ($request->input('admin')) 
			$user->type = $request->input('admin');
		else
			$user->type = 0;
			
		
				
		$user->title_id = $request->input('title_id');
		
		$user->sector_id = $request->input('sector_id');

        $user->save();
    }
}
