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
       $sectors = Sector::find(1);
             

        return $sectors;
    }
    public static function getTickets($type = "all")
    {
        switch ($type) 
        {
            case 'all':
                $tickets =  Ticket::all();
                break;

            case 'project':
                $tickets =  Ticket::where('project',1)->get();
                break;

            case 'archived':
                $tickets =  Ticket::where('archived',1)->get();
                break;

            default:
                $tickets =  Ticket::all();
                break;
        }

    	return $tickets;
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


            return redirect()->route('index');
            
        }
        else
            return redirect()->route('parameters');        
    }
    
    public static function modifyPassord(Request $request)
    {
        $currentuser = HomeController::getUser(); 

        if ($request->newPassword1 == $request->newPassword2) 
        {
            if (Hash::check($request->input('oldPassword'), $currentuser->password))
            {
                $currentuser->password = Hash::make($request->newPassword1);   
                $currentuser->save();               
            }
            else
                return redirect('parametres')->with('status', 'Ancien mot de passe <strong>erronés</strong>');
        }
        else
            return redirect('parametres')->with('status', 'Les nouveaux mot de passe doivent-être <strong>identique</strong>');
    }
}
