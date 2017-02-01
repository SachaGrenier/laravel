<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sector;
use App\Ticket;

class HomeController extends Controller
{
    protected $layout = "layouts.default";
    
     public static function index()
    {
       $sectors = Sector::find(1);
             

        return $sectors;
    }
    public static function getTickets()
    {


		$tickets = Ticket::with('sector')->get();
						
	
    	return $tickets;
    }
 
}
