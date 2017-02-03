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

        $ticket->title = $request->input('title');
        $ticket->content = $request->input('content');
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
