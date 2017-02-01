<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sector;
use App\Ticket;

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
    	 $sectors = Sector::all();
             

        return $sectors;
    }
}
