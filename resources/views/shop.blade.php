@extends('layouts.app')
@section('additionalCSS')
    <link rel="stylesheet" href="{{asset('style/shop.css')}}">
    <style>
        .products .see-more {
            color: #ff6600;
            border: 1px solid #ccc;
            margin-top: 50px;
            font-size: 23px;
            padding: 10px 90px;
            border-radius: 19px;
            transition: all 0.3s ease-in-out;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            -ms-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }
        .products .see-more:hover {
            border: 1px solid #ff6600;
            color: #fff;
            background: #ff6600;
        }
    </style>
@endsection
@section('content')
    <section class="products  text-center">
        <div class="container">
        @foreach(\App\Product::$categories as $category)
            <!---------{{$category}}---------->
                <h2 class="h1">{{strtoupper($category)}}</h2>
                <div class="row">
                    @foreach(\App\Http\Controllers\ProductsController::getItems($category) as $item)
                        @if($item['status'] != 2)
                        <div class="product col-lg-4 col-sm-12">
                            <a href="{{ url('product/'.$item['id']) }}">
                                <img src="{!! $item->images() !!}" class="rounded img-thumbnail"
                                     alt="{{$item['name']}}">
                                <h6>@if ($item['status']) {{$item['name']}} @else <del>{{$item['name']}}</del> <span class="text-danger">Out of Stock</span> @endif</h6>
                                <p>{{$item['price']}} USD</p>
                            </a>
                        </div>
                        @endif
                    @endforeach
                </div>
                <a href="{{url('shop/'.str_replace(' ','-',strtolower($category)))}}">
                    <button class="see-more btn">See More</button>
                </a>
                <!------------------------------>
            @endforeach
        </div>
    </section>
@endsection