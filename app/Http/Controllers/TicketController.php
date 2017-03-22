<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sector;
use App\Ticket;
use App\User;
use App\Applicant;
use App\Redirect;
use App\Contact;
use App\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TicketController extends Controller
{
    public static function getTicket($id)
    {
        $ticket = Ticket::find($id);
        
        return $ticket ?: redirect()->route('index');
    }
    public function store(request $request)
    {  
        $ticket = new Ticket;

        if($request->input('project'))
            $ticket->project = $request->input('project'); 
        
        $ticket->title = $request->input('title');

        if($request->input('applicant_id') && $request->input('applicant_id') != 'none')
            $ticket->applicant_id = $request->input('applicant_id');
        else
        {
            $applicant = new Applicant;
            $applicant->first_name = $request->input('first_name');
            $applicant->last_name = $request->input('last_name');
            $applicant->email = $request->input('email');
            $applicant->phone_number = $request->input('phone_number');
            $applicant->save();
            $ticket->applicant_id = $applicant->id;
        }
        
        $ticket->user_id = $request->input('user_id');
        $ticket->content = $request->input('content');
        $ticket->note = $request->input('note');

        if($request->input('sector_id') != "null")
            $ticket->sector_id = $request->input('sector_id');

        if($request->input('time_limit') && $request->input('time_limit') != 'none')
        {
            $date = $request->input('time_limit_value');
            $date = str_replace('/', '-', $date);
            $ticket->time_limit = date('Y-m-d', strtotime($date));
        }
        
        if($ticket->save())
        {
            Session::flash('status', 'Ticket crée avec succès! <a href="ticket/'. $ticket->id .'">Afficher le ticket</a>'); 
            Session::flash('class', 'alert-success'); 
        }
        else
        {
            Session::flash('status', 'Désolé, il semblerait que quelque chose cloche dans votre requête..'); 
            Session::flash('class', 'alert-danger'); 
        }

        $ticket->contact()->attach($request->input('contacts'));
       
        if(count($request->file('file')) > 0)
        {
            foreach ($request->file('file') as $file)
             {
                if($file->isValid())
                {
                    $destinationPath = 'files/';
                    $name = str_random(mt_rand(15,25)).'.'.$file->getClientOriginalExtension();
                    $file->move($destinationPath,$name); 
                    
                    $db_file = new File; 
                    $db_file->path = $destinationPath.$name;
                    $db_file->ext = $file->getClientOriginalExtension();
                    $db_file->ticket_id = $ticket->id;
                    $db_file->save();
                }   
            }
        }
        return redirect('createticket');
    }
    public static function archiveticket(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $ticket->archived = 1;
        $ticket->save();

        if($ticket->save())
        {
                              Session::flash('status', 'Ticket archivé !'); 
            Session::flash('class', 'alert-success'); 
        }
        else
        {
            Session::flash('status', 'Désolé, impossible d\'archiver l\'élément'); 
            Session::flash('class', 'alert-danger'); 
        }
         return redirect('/');                                                          
    }

    public static function updateticket(Request $request)
    {
        echo '<pre>';
        print_r($request->file());
        echo '</pre>';
        
        $ticket = Ticket::find($request->id);
        $ticket->title = $request->input('title');


        $ticket->content = $request->input('content');
        $ticket->note = $request->input('note');
        $ticket->user_id = $request->input('user_id');
        $ticket->applicant_id = $request->input('applicant_id');
        if($request->input('sector_id') != "null")
            $ticket->sector_id = $request->input('sector_id');
        else
            $ticket->sector_id = null;    
        if($request->input('project'))
            $ticket->project = $request->input('project'); 
        if($request->input('project') == null)
            $ticket->project = 0; 

        if($request->input('time_limit_value') && $request->input('time_limit_value') != 'none')
        {
             //$ticket->time_limit = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('time_limit_value'))));
            $date = $request->input('time_limit_value');
            $date = str_replace('/', '-', $date);
            $ticket->time_limit = date('Y-m-d', strtotime($date));
        }

        $ticket->contact()->attach($request->input('contacts'));

        if(count($request->file('files')) > 0)
        {
            foreach ($request->file('files') as $file)
             {
                if($file->isValid())
                {
                    $destinationPath = 'files/';
                    $name = str_random(mt_rand(15,25)).'.'.$file->getClientOriginalExtension();
                    $file->move($destinationPath,$name); 
                    
                    $db_file = new File; 
                    $db_file->path = $destinationPath.$name;
                    $db_file->ext = $file->getClientOriginalExtension();
                    $db_file->ticket_id = $ticket->id;
                    $db_file->save();
                }   
            }
        }

        if($ticket->save())
        {
            Session::flash('status', 'Ticket modifié avec succès !'); 
            Session::flash('class', 'alert-success'); 
        }
        else
        {
            Session::flash('status', 'Désolé, une erreur est intervenue'); 
            Session::flash('class', 'alert-danger'); 
        }
         return redirect('/ticket/'.$ticket->id);  
        $ticket->save();
    }
    public static function getUsersFromSector()
    {
        $user = User::find(session('id'));
    	return User::where('sector_id',$user->sector_id)->get();
    }
    public static function getApplicants()
    {
    	return Applicant::all();
    }
    public static function getSectors()
    {
         return Sector::all();
    }
    public static function getUsers()
    {
         return User::all();

    }
    public static function getFiles($id_ticket)
    {
        return File::where('ticket_id',$id_ticket)->get();
    }

    public static function getTicketsFromApplicant($applicant_id)
    {
        return Ticket::where('applicant_id',$applicant_id)->where('archived',false)->get();
    }
    public static function getContacts()
    {
        return Contact::all();
    }


}
