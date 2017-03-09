<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';
    
 	public function company()
    {
        return $this->belongsTo('App\Company');       
    }
    public function ticket()
    {
    	return $this->belongsToMany('App\Contact','ticket_contact', 'contact_id', 'ticket_id');
    }
}
