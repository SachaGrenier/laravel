<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sector;
use App\Ticket;
use App\User;
use App\Applicant;
use Illuminate\Http\Input;

class TicketController extends Controller
{
    public static function getTicket($idTicket)
    {
    }
    public static function store(request $request)
    {   
        echo '<pre>';
        print_r($request->input());
        echo '</pre>';

        $ticket = new Ticket;

        if($request->input('project'))
        {
            $applicant_array = explode(" ", $request->input('project'));

            $applicant = User::where('first_name',$applicant_array[0],'last_name', $applicant_array[1])
            $ticket->applicant_id =  $applicant->id;
        }
        else
        {
            $ticket->title = $request->input('title');
        }


        if($request->input('applicant'))
        {

            $ticket->project = $request->input('project');
            $ticket->title = '[PROJET] '. $request->input('title');
        }
        else
        {
            $ticket->title = $request->input('title');
        }



        
        $ticket->content = $request->input('content');
        $ticket->note = $request->input('note');
        $ticket->sector_id = $request->input('sector');

        

       if($request->input('time_limit'))
             $ticket->time_limit = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('time_limit_value'))));
  
        echo '<pre>';
        print_r($ticket);
        echo '</pre>';
        $ticket->save();
       
    }
    public static function getSectors()
    {
    	 return Sector::all();
    }
    public static function getUsersFromSector()
    {
    	return User::where('sector_id',1)->get();
    }
    public static function getApplicants()
    {
    	return Applicant::all();
    }
}
