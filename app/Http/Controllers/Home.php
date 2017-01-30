<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Home extends Controller
{
     public static function index()
    {
        $sectors = DB::table('t_sector')->get();

        return $sectors;
    }
}
