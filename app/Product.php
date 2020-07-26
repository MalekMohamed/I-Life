<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public static $categories = array('wall switches', 'plug', 'voice assistants', 'security', 'rm hub', 'power control', 'elites');
    protected $guarded = [];

    public function rating()
    {
        return $this->hasMany(Rating::Class);
    }

    public function images()
    {
        if (file_exists(public_path('img/shop/' . $this->id . '/'. json_decode($this->images)[0]))) {
            return asset('img/shop/' . $this->id . '/'. json_decode($this->images)[0]);
        } else {
            return asset('img/shop/default.png');
        }
    }
    public function Status()
    {
        if ($this->status == 1) {
            return '<span class="text-success">Available</span>';
        } elseif ($this->status == 0) {
            return '<span class="text-danger">Out of Stock</span>';
        } elseif ($this->status == 2) {
            return '<span class="text-primary">Hidden</span>';
        }
    }
}
