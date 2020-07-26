<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [];
    protected $table = 'addresses';
   public function User()
   {
       return $this->belongsTo(User::Class);
   }

}
