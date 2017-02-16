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
        $file = $request->image;
        $destinationPath = 'img/profilepictures';

        if ($file->isValid()) 
        {           
                    
            $currentuser = HomeController::getUser(); 
            $file->move($destinationPath,$file->getClientOriginalName());            

            $currentuser->picture_path = 'img/profilepictures/'.$file->getClientOriginalName();

            $currentuser->save();
            return redirect()->route('settings');            
        }
        else
            return redirect()->route('settings');        
    }

    //get user and update his email
    public static function updateEmail(Request $request)
    {
        $user = User::find(session('id'));
        $user->email = $request->email;
        $user->save();

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
                return redirect('settings');              
            }
            else               
                return redirect('settings')->with('status','Ancien mot de passe <strong>erroné</strong>');
        }
        else
            return redirect('settings')->with('status', 'Les mots de passes ne correspond pas!');
        
    }
}
