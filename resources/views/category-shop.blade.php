@extends('layouts.app')
@section('additionalCSS')
    <link rel="stylesheet" href="{{asset('style/shop.css')}}">
@endsection
@section('content')
    <section class="products  text-center ">
        <div class="container">
            <h2 class="h1">{{str_replace('-',' ',strtoupper(request('category')))}}</h2>
            <div class="row">
                @foreach($items as $item)
                    <div class="product col-lg-4 col-sm-12">
                        <a href="{{ url('product/'.$item['id']) }}">
                            <img src="{!! $item->images() !!}" class="rounded img-thumbnail"
                                 alt="{{$item['name']}}">
                            <h6>@if ($item['status']) {{$item['name']}} @else <del>{{$item['name']}}</del> <span class="text-danger">Out of Stock</span> @endif</h6>
                            <p>{{$item['price']}} USD</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection