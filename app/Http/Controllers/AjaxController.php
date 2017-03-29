<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\User;
use App\Sector;
use App\File;
use App\Contact;
use Carbon\Carbon;

class AjaxController extends Controller
{
    ///index
    //returns JSON array of tickets
    //parameter $type, used to know what kind of information we need
    public function index($type)
    { 
        switch ($type) 
        {
            case 'sector':
                $user = User::find(session('id'));            
                $tickets = Ticket::where('sector_id',$user->sector->id)->where('archived',false)->get();
            break;

            case 'all':
                $tickets =  Ticket::where('archived',false)->get();
                break;

            case 'project':
                $tickets =  Ticket::where('project',1)->where('archived',false)->get();
                break;

            case 'archived':
                $tickets =  Ticket::where('archived',1)->get();
                break;

          	case 'mine':
                $tickets =  Ticket::where('user_id',session('id'))->where('archived',false)->get();
                break;

            default:
                $tickets =  Ticket::where('archived',false)->get();
                break;
        }
        
        $array = [];
        
        setLocale(LC_TIME,config('app.locale'));

        foreach ($tickets as $key => $value)
        {
            $isarchived = $value->archived ? "[ARCHIVE] " : "";
            $isproject = $value->project ? "[PROJET] " : "";
            $isproject2 = $value->project ? 'style="color:green"' : "";
            $isarchived2 = $value->archived ? 'style="color:red"' : "";

        	$array[] = new \stdClass();
        	$array[$key]->id = $value->id;
        	$array[$key]->title = '<a href="ticket/' . $value->id.'" '.$isarchived2.' '.$isproject2.'>'.$isarchived.' '.$isproject.''.$value->title.'</a>';
        	$array[$key]->sector = $value->sector['name'];
        	$array[$key]->user = $value->user['first_name']. ' ' . $value->user['last_name'];
        	$array[$key]->applicant = $value->applicant['first_name']. ' ' . $value->applicant['last_name'];
        	$array[$key]->created_at = $value->created_at->formatLocalized('%d %B %Y');
        	$array[$key]->time_limit = $value->time_limit == null ? "Aucun" : Carbon::parse($value->time_limit)->formatLocalized('%d %B %Y');
        }

    	return $array;
    }
    ///getUsers
    //get all the users that are in a specified sector, expect if the parameter is all.
    //returns array of objects with all the users asked
    public function getUsers($sector_id)
    {
        if($sector_id == "all")
        {
            return User::all();
        }
        else
        {
            return User::where('sector_id',$sector_id)->get();
        }
    }
    ///deletefile
    //find the file with id submited and deletes it. It also removes the line in the database
    //return success(200) if everything went good
    public function deletefile($id_file)
    {
        $file = File::find($id_file);
        unlink($file->path);
        if($file->delete())
        {
            return response(200);
        }
    }
    ///deletecontact
    //find the contact with id submited and removes the line in the database
    //return success(200) if everything went good
    public function deletecontact($id_contact_id_ticket)
    {
        $terms = explode("&", $id_contact_id_ticket);
        $ticket= Ticket::find($terms[1]);
        
        if($ticket->contact()->detach($terms[0]))
        {
            return response(200);
        }
    }
}


