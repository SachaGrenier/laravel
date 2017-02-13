<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ticket;


class AjaxController extends Controller
{
    public function index($type){
      
     

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

        $ui = [];

        foreach ($tickets as $key => $value)
        {
        	$ui[] = new \stdClass();
        	$ui[$key]->id = $value->id;
        	$ui[$key]->title = $value->title;
        	$ui[$key]->sector = $value->sector['name'];
        	$ui[$key]->user = $value->user['first_name']. ' ' . $value->user['last_name'];
        	$ui[$key]->applicant = $value->applicant['first_name']. ' ' . $value->applicant['last_name'];
        	$ui[$key]->created_at = $value->created_at->format('d M Y');
        	$ui[$key]->updated_at = $value->updated_at->format('d M Y');

        }

    	return json_encode($ui);
   }
}


