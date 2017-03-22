<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Ticket;
use PDF;

class ItemController extends Controller
{
    public function pdfview(Request $request)
    {
        $ticket = Ticket::find($request->input('id'));
       
        view()->share('ticket',$ticket);

        if($request->has('download'))
        {
            $pdf = PDF::loadView('pdfview');
            $name = 'ticket-'.$ticket->id;
            $name .=$ticket->user ? '-'.$ticket->user->login : '' ;
            $name .='.pdf';
            return $pdf->download($name);
        }

        return view('pdfview');
    }

    public function pdfviewlist(Request $request)
    {
        $tickets = Ticket::where('archived',false)->get();
       
        view()->share('tickets',$tickets);

        if($request->has('download'))
        {
            $pdf = PDF::loadView('pdfviewlist')->setPaper('A4','landscape');
            return $pdf->download('list_tickets.pdf');
        }
        return view('pdfviewlist');
    }
}