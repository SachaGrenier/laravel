<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
     protected $table = 'ticket';

    public function sector()
    {
        return $this->belongsTo('App\Sector');
    }
     public function user()
    {
        return $this->belongsTo('App\User');
    }
     public function applicant()
    {
        return $this->belongsTo('App\Applicant');
    }
    public function contact()
    {
         return $this->belongsToMany('App\Contact','ticket_contact', 'ticket_id', 'contact_id');
    }
 
}

