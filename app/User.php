<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
   protected $table = 'user';

   	 public function sector()
    {
        return $this->belongsTo('App\Sector');
    }
         public function title()
    {
        return $this->belongsTo('App\Title');
    }
}
