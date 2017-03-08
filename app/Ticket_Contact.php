<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Ticket_Contact extends Model
{
    protected $table = 'ticket_contact';
    public $timestamps = false;

   	public function contact()
    {
        //return $this->belongsTo('App\Contact');
        return $this->belongsToMany('App\Contact')->withPivot('first_name', 'last_name');
    }
    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }
}
