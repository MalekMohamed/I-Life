<?php
/**
 * Created by PhpStorm.
 * User: Strix
 * Date: 8/3/2019
 * Time: 11:54 PM
 */
?>
@extends('layouts.app')
@section('additionalCSS')
    <link rel="stylesheet" href="{{asset('style/sign-up.css')}}">
@endsection
@section('content')
    <section class="login padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card-box">
                        <h4 class="header-title mb-4">Addresses</h4>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="nav card flex-column nav-pills nav-pills-tab" id="v-pills-tab"
                                     role="tablist" aria-orientation="vertical">
                                    <a class="nav-link mb-2" href="{{route('Orders.index')}}">
                                        <i class="fas fa-shopping-basket"></i> Orders</a>
                                    <a class="nav-link mb-2" href="{{route('account.index')}}">
                                        <i class="fas fa-wrench"></i> Settings</a>
                                    <a class="nav-link active show  mb-2" href="{{route('account.address')}}">
                                        <i class="fas fa-address-book"></i> Address</a>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-sm-9">
                                <div class="tab-content card p-3">
                                    <div class="tab-pane fade active show">
                                        <div class="card-body">
                                            <h4 class="mb-3 header-title">Add New Address</h4>
                                            @if(session()->has('msg'))
                                                <div class="alert alert-{!! \Session::get('status') !!} alert-dismissible bg-{!! \Session::get('status') !!} text-white border-0 fade show"
                                                     role="alert">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    {!! \Session::get('msg') !!}
                                                </div>
                                            @endif
                                            <form class="form-horizontal" action="{{route('address.store')}}"
                                                  method="post">
                                                @csrf
                                                <div class="form-group row mb-3">
                                                    <label for="address_name" class="col-3 col-form-label">Address
                                                        name</label>
                                                    <div class="col-9">
                                                        <input type="text" name="address_name"
                                                               value="{{old('address_name') ?? ''}}"
                                                               class="form-control @error('address_name') is-invalid @enderror"
                                                               id="address_name"
                                                               placeholder="Home, Work etc...">
                                                        @error('address_name')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="address" class="col-3 col-form-label">Address</label>
                                                    <div class="col-9">
                                                        <input type="text" name="address"
                                                               value="{{old('address') ?? ''}}"
                                                               class="form-control @error('address') is-invalid @enderror"
                                                               id="address"
                                                               placeholder="House No. - Street - City - State">
                                                        @error('address')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 justify-content-end row">
                                                    <div class="col-9">
                                                        <button type="submit"
                                                                class="btn btn-info">Submit
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>


                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-2">
                                    <table id="cart" class="table table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($addresses->Addresses as $address)
                                            <tr>
                                                <td data-th="Id">
                                                    # {{$address->id}}
                                                </td>
                                                <td>
                                                    {{$address->address_name}}
                                                </td>
                                                <td data-th="Id">
                                                    {{$address->address}}
                                                </td>
                                                <td>
                                                    {{ date('d-M-Y', strtotime($address->created_at))}}
                                                </td>
                                                <td>
                                                    @if($address->status == 0)
                                                        <a href="{{route('address.set',$address)}}" class="btn btn-dark btn-sm reorder"
                                                                data-id="{{ $address->id }}">Set as Default
                                                        </a>
                                                        @else
                                                        <a href="#" class="btn btn-primary btn-sm reorder"
                                                           data-id="{{ $address->id }}">Active
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div> <!-- end col-->
                        </div>
                    </div>
                </div> <!-- end card-box-->
            </div>
        </div>
    </section>
@endsection
