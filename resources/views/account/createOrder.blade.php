<?php
/**
 * Created by PhpStorm.
 * User: Strix
 * Date: 8/2/2019
 * Time: 4:42 PM
 */
?>
@extends('layouts.app')
@section('additionalCSS')
    <link rel="stylesheet" href="{{asset('style/shop.css')}}">
    <style>
        .row .logo {
            text-align: center;
            width: 40%;
            float: left;
            font-size: 80px;
            font-weight: bold;
            font-family: "Montserrat Alternates", sans-serif;
        }

        .logo span .ie {
            color: #ff6600;
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5 mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row p-5">
                            <div class="col-md-6">
                                <div class="logo"><span><span class="ie">i</span> Life</span></div>
                            </div>

                            <div class="col-md-6 text-right">
                                <p class="font-weight-bold mb-1">Invoice #{{$Order}}</p>
                                <p class="text-muted">Due to: {{ date('d M, Y', strtotime(now()))}} </p>
                            </div>
                        </div>

                        <hr class="my-5">
                        <div class="row pb-5 p-5">
                            <div class="col-md-6">
                                <p class="font-weight-bold mb-4">Client Information</p>
                                <p class="mb-1">{{\Illuminate\Support\Facades\Auth::user()->firstname}}</p>
                                <p class="mb-1">0{{\Illuminate\Support\Facades\Auth::user()->phone}}</p>
                                <p class="mb-1">{{\Illuminate\Support\Facades\Auth::user()->address}} </p>
                            </div>

                        </div>

                        <div class="row p-5">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="border-0 text-uppercase small font-weight-bold">ID</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Item</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Description</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Quantity</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Unit Cost</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Sub Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $total = 0 ?>
                                    @foreach($items as $id => $details)
                                        <?php $total += $details['price'] * $details['quantity']; ?>
                                        <tr>
                                            <td>
                                                {{ $id }}
                                            </td>
                                            <td data-th="Product">
                                                {{ $details['name'] }}
                                            </td>
                                            <td data-th="color">
                                                {{ $details['selected-color'] }}
                                            </td>
                                            <td data-th="Quantity">
                                                {{ $details['quantity'] }}
                                            </td>
                                            <td data-th="Price">${{ $details['price'] }}</td>
                                            <td data-th="sub-total">
                                                {{ $details['price']*$details['quantity'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex flex-row-reverse bg-dark text-white p-4">
                            @if(session()->has('cart_total'))
                                <?php
                                $grand = $total - ($total * session('cart_total') / 100);
                                ?>
                            @endif
                            <div class="py-3 px-5 text-right">
                                <div class="mb-2">Grand total</div>
                                <div class="h2 font-weight-light">${{$grand ?? $total}}</div>
                            </div>
                            @if(session()->has('cart_total'))
                                <div class="py-3 px-5 text-right">
                                    <div class="mb-2">Discount</div>
                                    <div class="h2 font-weight-light">{{session('cart_total')}}%</div>
                                </div>
                                <?php
                                session()->forget('cart_total');
                                ?>
                            @endif
                            <div class="py-3 px-5 text-right">
                                <div class="mb-2">Total amount</div>
                                <div class="h2 font-weight-light">${{$total}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection