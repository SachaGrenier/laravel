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

    	return response()->json($tickets, 200);
   }
}


