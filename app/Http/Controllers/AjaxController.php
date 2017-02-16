<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\User;
use Carbon\Carbon;


class AjaxController extends Controller
{
    public function index($type){
      
     

      switch ($type) 
        {
            case 'sector':
                $user = User::find(session('id'));            
                $tickets = Ticket::where('sector_id',$user->sector->id)->get();
            break;

            case 'all':
                $tickets =  Ticket::all();
                break;

            case 'project':
                $tickets =  Ticket::where('project',1)->get();
                break;

            case 'archived':
                $tickets =  Ticket::where('archived',1)->get();
                break;

          	case 'mine':
                $tickets =  Ticket::where('user_id',session('id'))->get();
                break;

            default:
                $tickets =  Ticket::all();
                break;
        }

        $ui = [];

        foreach ($tickets as $key => $value)
        {
            $isproject = $value->project ? "[PROJET] " : "";
        	$ui[] = new \stdClass();
        	$ui[$key]->id = $value->id;
        	$ui[$key]->title = '<a href="ticket/' . $value->id.'" > '.$isproject.''.$value->title.'</a>';
        	$ui[$key]->sector = $value->sector['name'];
        	$ui[$key]->user = $value->user['first_name']. ' ' . $value->user['last_name'];
        	$ui[$key]->applicant = $value->applicant['first_name']. ' ' . $value->applicant['last_name'];
        	$ui[$key]->created_at = $value->created_at->format('d M Y');
        	$ui[$key]->time_limit = $value->time_limit == null ? "Aucun" : Carbon::parse($value->time_limit)->format('d M Y');

      

        }

    	return $ui;
   }
}


