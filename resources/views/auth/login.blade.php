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
                        <h5>Sign in to continue</h5>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror" autofocus
                                   value="{{old('email')}}"
                                   placeholder="{{ __('E-Mail Address') }}*">
                            @error('email')
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
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remember">Remember Me.</label>
                            </div>
                            <button type="submit" name="submit" class="btn">Sign in</button>
                            @if (Route::has('password.request'))
                                <h6>Forgot password?<a href="{{ route('password.request') }}">
                                        <span>let's recover it</span>
                                    </a></h6>
                            @endif
                            <h6>Not a member yet? <a href="{{route('register')}}"><span> let's Create an account</span></a></h6>
                        </form>

                    </div>
                </div>
                <div class="col-lg-5 ">
                    <div class="social-up">
                        <h5>Or Sign in using social media</h5>
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
