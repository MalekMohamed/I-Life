<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::Class);
    }
}
