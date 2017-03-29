<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Title;
use App\Ticket;
use App\Sector;

use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /// store
    //validates the request inputs
    //Used to store an user
    //hashes the password, settings the default profile picture
    //setting the username with first name and last name (exemple for Marco Polo : "marco_polo")
    //returns with flashed data (good, error)
    public function store(request $request)
    {
    	$this->validate($request, [
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'email' => 'required|max:255',
        'title_id' => 'required'
            ]);

		$DEFAULT_PROFILE_PICTURE_PATH = 'img/profilepictures/default.jpg';
        
        $user = new User;

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->login = strtolower($request->input('first_name').'_'.$request->input('last_name'));
        $user->password = Hash::make('secret');       
        $user->picture_path = $DEFAULT_PROFILE_PICTURE_PATH;
		
		if ($request->input('admin')) 
			$user->type = $request->input('admin');
		else
			$user->type = 0;
				
		$user->title_id = $request->input('title_id');
		$user->sector_id = $request->input('sector_id');

        if($user->save())
        {
            Session::flash('status', 'L\'utilisateur <strong>'.$user->first_name.' '.$user->last_name.'</strong> à bien été crée. <strong><a href="/edituser/'.$user->id.'">Modifier</a></strong>'); 
            Session::flash('class', 'alert-success'); 
        }
        else
        {
            Session::flash('status', 'Une erreur est intervenue'); 
            Session::flash('class', 'alert-danger');
        }
        return redirect('admin');
    }

    /// storetitle
    //simply stores the title into the database
    //returns with flashed data (good, error)
    public function storetitle(request $request)
    {
        $title = new Title;
        $title->name = $request->input('name');
        
        if($title->save())
        {
            Session::flash('status', 'Le rôle <strong>'.$title->name.'</strong> à bien été  crée'); 
            Session::flash('class', 'alert-success'); 
        }
        else
        {
            Session::flash('status', 'Une erreur est intervenue'); 
            Session::flash('class', 'alert-danger');
        }
        return redirect('admin');

    }
    ///storesector
    //simply stores the sector into the database
    //returns with flashed data (good, error)
    public function storesector(request $request)
    {
        $sector = new Sector;
        $sector->name = $request->input('name');
        
        if($sector->save())
        {
            Session::flash('status', 'Le secteur <strong>'.$sector->name.'</strong> à bien été  crée'); 
            Session::flash('class', 'alert-success'); 
        }
        else
        {
            Session::flash('status', 'Une erreur est intervenue'); 
            Session::flash('class', 'alert-danger');
        }
        return redirect('admin');
    }
    ///getUsers
    //returns all the users from the database
    public static function getUsers()
    {
        return User::all();
    }
    ///getUser
    //$id -> user's id
    //returns user's data from the database
    public static function getUser($id)
    {
        return User::find($id);
    }
    ///deleteuser
    //first checks if the user is assigned to some tickets, then set null to ticket's user assigned
    //removes user's profile picture
    //removes user from database
    public function deleteuser(request $request)
    {
        $user = User::find($request->input('id'));    
        $tickets = Ticket::where('user_id', $request->input('id'))->get();

        foreach ($tickets as $ticket)
        {
            $ticket->note .= "\nAncien utilisateur assigné : ".$user->first_name.' '.$user->last_name;
            $ticket->user_id = null;
            $ticket->save();
        }

        if($user->picture_path != "img/profilepictures/default.jpg")
        {
            if($user->picture_path != null)
                unlink($user->picture_path);
        }


        if($user->delete())
        {
            Session::flash('status', 'Le profil à correctement été supprimé'); 
            Session::flash('class', 'alert-success');       
        }
        else
        {
            Session::flash('status', 'Une erreur est intervenue'); 
            Session::flash('class', 'alert-danger');
        }

        return redirect('admin');
    }
    ///deletesector
    //first get tickets where the sector is set, and sets null to them
    //then get users attribuated to this sector and make a list of users
    //if there are users, returns the list into flashed data
    //else, get the sector with the ID and removes it from database
    //returns flashed data with result of the request(good, error)
    public function deletesector(request $request)
    {
        $tickets = Ticket::where('sector_id', $request->input('id'))->get();

        foreach ($tickets as $ticket)
        {
            $ticket->sector_id = null;
            $ticket->save();
        }
        $users = User::where('sector_id', $request->input('id'))->get();

        $listnames = "";
            
        foreach ($users as $user)
        {
            $listnames .= $user->first_name.' '.$user->last_name.',';
        }
        $listnames=rtrim($listnames,", ");
        
        if (count($users) > 0) 
        {
            if(count($users) == 1)
                Session::flash('status', 'L\'utilisateur '.$listnames.' est actuellement dans ce secteur. Veuillez le modifier!'); 
            else
                Session::flash('status', 'Les utilisateurs '.$listnames.' sont actuellement dans ce secteur. Veuillez les modifier!'); 

            Session::flash('class', 'alert-danger');
        }
        else
        {
            $sector = Sector::find($request->input('id'));

            if($sector->delete())
            {
                Session::flash('status', 'Le secteur <strong>'. $sector->name. '</strong> à correctement été supprimé'); 
                Session::flash('class', 'alert-success');   
            }
            else
            {
                Session::flash('status', 'Une erreur est intervenue'); 
                Session::flash('class', 'alert-danger');
            }
        }
        return redirect('admin');

    }
    ///deletetitle
    //first it gets all the users attached to this title
    //if there are some, it creates a list of the users and returns them with an error
    //else, it finds the title and removes it  from the database
    //returns flashed data with result of the request(good, error)
    public function deletetitle(request $request)
    {
        $users = User::where('title_id', $request->input('id'))->get();
        
        $listnames = "";
            
        foreach ($users as $user)
        {
            $listnames .= $user->first_name.' '.$user->last_name.',';
        }
        $listnames=rtrim($listnames,", ");

        if (count($users) > 0) 
        {
            if(count($users) == 1)
            Session::flash('status', 'L\'utilisateur '.$listnames.' à actuellement ce rôle. Veuillez le modifier!'); 
            else
            Session::flash('status', 'Les utilisateurs '.$listnames.' ont actuellement ce rôle. Veuillez les modifier!'); 

            Session::flash('class', 'alert-danger');
        }
        else
        {
            $title = Title::find($request->input('id'));
            if($title->delete())
            {
                Session::flash('status', 'Le rôle <strong>'. $title->name. '</strong> à correctement été supprimé'); 
                Session::flash('class', 'alert-success');                   
            }
            else
            {
                Session::flash('status', 'Une erreur est intervenue'); 
                Session::flash('class', 'alert-danger');
            }
        }
        return redirect('admin');
    }
    ///updateuser
    //simply replace the database values using the new ones and saves it
    //returns flashed data with result of the request(good, error)
    public function updateuser(request $request)
    {
        $user = User::find($request->input('id'));
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->login = $request->input('login');
        $user->sector_id = $request->input('sector_id');
        $user->title_id = $request->input('title_id');
        
        if ($request->input('admin')) 
            $user->type = $request->input('admin');
        else
            $user->type = 0;

        if($user->save())
        {
            Session::flash('status', 'Le profil à correctement été mis à jour'); 
            Session::flash('class', 'alert-success');
        }
        else
        {
            Session::flash('status', 'Une erreur est intervenue'); 
            Session::flash('class', 'alert-danger');
        }
        return redirect('edituser/'. $request->input('id'));
    }
    ///resetpassword
    //get the user using the id
    //hashes the new password and replace the old password
    //returns flashed data with result of the request(good, error)
    public function resetpassword(request $request)
    {
        $user = User::find($request->input('id'));
        $user->password = Hash::make('secret');
        
        if($user->save())
        {
            Session::flash('status', 'Le mot de passe à bien été réinitialisé'); 
            Session::flash('class', 'alert-success'); 
        }
        else
        {
            Session::flash('status', 'Une erreur est intervenue'); 
            Session::flash('class', 'alert-danger');
        }
        return redirect('edituser/'. $request->input('id'));
    }

}
