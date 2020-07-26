<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $feature_Items = Product::where('status','!=',0)->orderByRaw('RAND()')->take(4)->get();
        return view('home',compact('feature_Items'));
    }
}
