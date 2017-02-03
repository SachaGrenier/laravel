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

            $ticket->project = $request->input('project');
            $ticket->title = '[PROJET] '. $request->input('title');
        }
        else
        {
            $ticket->title = $request->input('title');
        }


        if($request->input('applicant_id'))
        {

            $ticket->applicant_id = $request->input('applicant_id');
        }
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
