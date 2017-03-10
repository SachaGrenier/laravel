<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\User;
use App\Sector;
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
        
        $ui = [];

        foreach ($tickets as $key => $value)
        {
            $isarchived = $value->archived ? "[ARCHIVE] " : "";
            $isproject = $value->project ? "[PROJET] " : "";
            $isproject2 = $value->project ? 'style="color:green"' : "";
            $isarchived2 = $value->archived ? 'style="color:red"' : "";

        	$ui[] = new \stdClass();
        	$ui[$key]->id = $value->id;
        	$ui[$key]->title = '<a href="ticket/' . $value->id.'" '.$isarchived2.' '.$isproject2.'>'.$isarchived.' '.$isproject.''.$value->title.'</a>';
        	$ui[$key]->sector = $value->sector['name'];
        	$ui[$key]->user = $value->user['first_name']. ' ' . $value->user['last_name'];
        	$ui[$key]->applicant = $value->applicant['first_name']. ' ' . $value->applicant['last_name'];
        	$ui[$key]->created_at = $value->created_at->format('d M Y');
        	$ui[$key]->time_limit = $value->time_limit == null ? "Aucun" : Carbon::parse($value->time_limit)->format('d M Y');
        }

    	return $ui;
   }
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
}


