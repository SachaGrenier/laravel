<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\Sector;
use App\Ticket;
use App\Title;
use App\User;
use App\Contact;
use App\Company;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    protected $layout = "layouts.default";
    
    public static function index()
    {

       $user = User::find(session('id'));

       $sector = Sector::find($user->sector->id);
             

        return $sector;
    }
 
    public static function getSectors()
    {
         return Sector::all();
    }

    public static function getTitles()
    {
         return Title::all();
    }

    public static function getUser()
    {
        return User::find(session('id'));
    }

    

    public static function updateProfilPicture(Request $request)
    {
        
        if ($request->hasFile('image'))
        {
            $file = $request->image;    
            if($file->isValid())
            {
                $destinationPath = 'img/profilepictures/';
                $name = str_random(mt_rand(15,25)).'.'.$file->getClientOriginalExtension();
                $currentuser = HomeController::getUser(); 
                $file->move($destinationPath,$name); 
                $currentuser->picture_path = $destinationPath.$name;

                $currentuser->save();
                Session::flash('status', 'La photo de profil à bien été mise à jour'); 
                Session::flash('class', 'alert-success'); 
            }
            else
            {
                Session::flash('status', 'Fichier invalide'); 
                Session::flash('class', 'alert-danger'); 
            }
                
                
            
        }
        else
        {
             Session::flash('status', 'Fichier invalide'); 
            Session::flash('class', 'alert-danger'); 
        }
        return redirect('settings');  


    }

    //get user and update his email
    public static function updateEmail(Request $request)
    {
        $user = User::find(session('id'));
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) 
        {
            $user->email = $request->email;
            $user->save();
            Session::flash('status', 'Adresse email modifiée avec succès'); 
            Session::flash('class', 'alert-success'); 
               
        }
        else
        {
            Session::flash('status', 'Adresse email incorrecte'); 
            Session::flash('class', 'alert-danger'); 
        }
        

        return redirect()->route('settings'); 
    }
    
    public static function updatePassword(Request $request)
    {
        $currentuser = HomeController::getUser(); 
        
        if ($request->new_password == $request->new_password_confirm) 
        {
            if (Hash::check($request->input('old_password'), $currentuser->password))
            {
                $currentuser->password = Hash::make($request->new_password);   
                $currentuser->save(); 
                Session::flash('status', 'Mot de passe modifié avec succès'); 
                Session::flash('class', 'alert-success'); 
                            
            }
            else   
            {            
                Session::flash('status', 'Ancien mot de passe <strong>erroné</strong>'); 
                Session::flash('class', 'alert-danger'); 
            }
           
        }
        else
        {
            Session::flash('status', 'Les mots de passes ne correspondent pas!'); 
            Session::flash('class', 'alert-danger'); 
           
        }
         return redirect('settings');
    }
}