<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sector;
use App\Ticket;
use App\Title;


class HomeController extends Controller
{
    protected $layout = "layouts.default";
    
     public static function index()
    {
       $sectors = Sector::find(1);
             

        return $sectors;
    }
    public static function getTickets($type = "all")
    {
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

    	return $tickets;
    }
 
     public static function getSectors()
    {
         return Sector::all();
    }

    public static function getTitles()
    {
         return Title::all();
    }
}
