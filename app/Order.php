<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    public static $Status = array(0 => array('status' => 'Received', 'class' => 'danger'), 1 => array('status'=> 'On the Way', 'class' => 'warning'), 2 => array('status'=> 'Delivered', 'class' => 'success'));

    public function Product()
    {
        return $this->belongsTo(Product::Class);
    }
    public function User()
    {
        return $this->belongsTo(User::Class);
    }
}
