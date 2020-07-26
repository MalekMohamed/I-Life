@extends('layouts.app')
@section('additionalCSS')
    <link rel="stylesheet" href="{{asset('style/sign-up.css')}}">
@endsection
@section('content')
    <section class="login padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="login-form">
                        <h5>Create an account</h5>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" name="first-name"
                                           class="form-control @error('first-name') is-invalid @enderror" autofocus value="{{old('first-name')}}"
                                           placeholder="First name *">
                                    @error('first-name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="text" name="last-name"
                                           class="form-control @error('last-name') is-invalid @enderror" value="{{old('last-name')}}"
                                           placeholder="Last name *">
                                    @error('last-name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}"
                                   placeholder="Email address *">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <input type="tel" name="phone" maxlength="15" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}"
                                   placeholder="Phone number *">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <input id="password" type="password" placeholder="Password*"
                                   class="form-control @error('password') is-invalid @enderror" name="password" required
                                   autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <input placeholder="repeat-password*" id="password-confirm" type="password"
                                   class="form-control" name="password_confirmation" required
                                   autocomplete="new-password">

                            <button type="submit" name="submit" class="btn">Submit</button>
                            <h6>Already have an account? <a href="{{route('login')}}"><span>Sign In</span></a></h6>
                        </form>

                    </div>
                </div>
                <div class="col-lg-5 ">
                    <div class="social-up">
                        <h5>Or create an account using social media</h5>
                        <div class="social">
                            <a href="{{url('/redirect/facebook')}}" class="btn">Facebook</a>
                            <a href="{{url('/redirect/google')}}" class="btn">Google</a>
                            <a href="{{url('/redirect/linkedin')}}" class="btn" style="display: none;">LinkedIn</a>
                            <a href="{{url('/redirect/twitter')}}" class="btn" style="display: none;">Twitter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
