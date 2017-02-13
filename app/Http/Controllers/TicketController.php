<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sector;
use App\Ticket;
use App\User;
use App\Applicant;
use App\Redirect;
use Illuminate\Support\Facades\Input;


class TicketController extends Controller
{
    public static function getTicket($id)
    {
        $ticket = Ticket::find($id);
        
        return $ticket ?: redirect()->route('index');
  


    }
    public function store(request $request)
    {   
        echo '<pre>';
        print_r($request->input());
        echo '</pre>';

         $this->validate($request, [
        'title' => 'required|max:255',
        'content' => 'required',
            ]);

        $ticket = new Ticket;

        if($request->input('project'))
        {
            

            $ticket->project = $request->input('project');
            $ticket->title = '[PROJET] '. $request->input('title');
        }
        else
            $ticket->title = $request->input('title');
        


        if($request->input('applicant_id'))
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
        
        if($request->input('user_id'))
            $ticket->user_id = $request->input('user_id');

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

    public static function getUsersFromSector()
    {
    	return User::where('sector_id',1)->get();
    }
    public static function getApplicants()
    {
    	return Applicant::all();
    }
}
