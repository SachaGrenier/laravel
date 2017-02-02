<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sector;
use App\Ticket;
use App\User;
use App\Applicant;

class TicketController extends Controller
{
    public static function getTicket($idTicket)
    {
    	
    }
      public function add()
    {

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
