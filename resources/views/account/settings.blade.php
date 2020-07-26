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
                        <h4 class="header-title mb-4">Account Settings</h4>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="nav card flex-column nav-pills nav-pills-tab" id="v-pills-tab"
                                     role="tablist" aria-orientation="vertical">
                                    <a class="nav-link mb-2" href="{{route('Orders.index')}}">
                                        <i class="fas fa-shopping-basket"></i> Orders</a>
                                    <a class="nav-link active show mb-2" href="{{route('account.index')}}">
                                        <i class="fas fa-wrench"></i> Settings</a>
                                    <a class="nav-link mb-2" href="{{route('account.address')}}">
                                        <i class="fas fa-address-book"></i> Address</a>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-sm-9">
                                <div class="tab-content card p-3">
                                    <div class="tab-pane fade active show">
                                        <div class="card-body">
                                            <h4 class="mb-3 header-title">Change Password</h4>
                                            @if(session()->has('msg'))
                                                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show"
                                                     role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    {!! \Session::get('msg') !!}
                                                </div>
                                            @endif
                                            <form class="form-horizontal" action="{{route('user.update')}}"
                                                  method="post">
                                                @method('PATCH')
                                                @csrf
                                                <div class="form-group row mb-3">
                                                    <label for="current-password" class="col-3 col-form-label">Current
                                                        Password</label>
                                                    <div class="col-9">
                                                        <input type="password" name="current-password"
                                                               value="{{old('current-password') ?? ''}}"
                                                               class="form-control @error('current-password') is-invalid @enderror"
                                                               id="current-password"
                                                               placeholder="Password">
                                                        @error('current-password')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="newPassword" class="col-3 col-form-label">New
                                                        Password</label>
                                                    <div class="col-9">
                                                        <input type="password" name="newPassword"
                                                               value="{{old('newPassword') ?? ''}}"
                                                               class="form-control @error('newPassword') is-invalid @enderror"
                                                               id="newPassword"
                                                               placeholder="New Password">
                                                        @error('newPassword')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="newPassword_confirmation" class="col-3 col-form-label">Confirm
                                                        New
                                                        Password</label>
                                                    <div class="col-9">
                                                        <input type="password" name="newPassword_confirmation"
                                                               value="{{old('newPassword_confirmation') ?? ''}}"
                                                               class="form-control" id="newPassword_confirmation"
                                                               placeholder="Retype new Password">
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
                            </div> <!-- end col-->
                        </div>
                    </div>
                </div> <!-- end card-box-->
            </div>
        </div>
    </section>
@endsection
