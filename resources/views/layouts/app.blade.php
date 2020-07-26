<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>I Life</title>
    <link rel="stylesheet" href="{{asset('style/sass/plugins/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat+Alternates&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:600&display=swap" rel="stylesheet">
    @yield('additionalCSS')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
<style>
    .dropdown-menu a:hover {
        color: #ff6600 !important;
    }
    .dropdown-menu a {
        color: #f8f9fa !important;
        font-size: 15px !important;
    }
</style>
</head>

<body>
<section class="header">
    <div class="overlay">
        <div class="container">
            <!--- Start nav bar---->
            <section class="nav text-center">
                <div class="left-nav">
                    <ul class="list-unstyled">
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li><a href="{{route('shop')}}">Shop</a></li>
                        <li><a href="#">About</a></li>
                    </ul>
                </div>
                <div class="logo"><span><span class="ie">i</span> Life</span></div>
                <div class="right-nav">
                    <ul class="list-unstyled">
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Retailers</a></li>
                        @auth
                            <li class="dropdown" style="">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">Welcome,
                                <span class="pro-user-name">{{auth()->user()->firstname}} <i class="mdi mdi-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href=" {{url('cart')}}"
                                       class="dropdown-item notify-item"> My Cart @if(session()->has('cart'))  <div class="badge badge-danger"> {{count(session('cart'))}}</div> @endif</a>
                                    <!-- item-->
                                    <a href="{{route('account.index')}}" class="dropdown-item notify-item">
                                        <i class="fe-user"></i>
                                        <span>My Account</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <!-- item-->
                                    <a href="{{ route('logout') }}" class="dropdown-item notify-item"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                                class="fe-log-out"></i>
                                        <span>{{ __('Logout') }}</span></a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @else
                            <li><a href="{{route('login')}}">Sign In</a></li>
                        @endauth
                    </ul>
                </div>

                <!--- Slide menu---->
                <div class="burger">
                    <a href="#"><i class="fas fa-bars fa-2x"></i></a>
                </div>
                <div class="slide-menu">
                    <a class="btn-close" href="#">&times;</a>
                    <div class="clearfix"></div>
                    <div class="slide-nav">
                        <ul class="list-unstyled">
                            <li class="list-one"><a href="{{route('home')}}">Home</a></li>
                            <li class="list-two"><a href="{{route('shop')}}">Shop</a></li>
                            <li class="list-three"><a href="#">About</a></li>
                            <li class="list-four"><a href="#">Contact</a></li>
                            <li class="list-five"><a href="#">Retailers</a></li>
                            <li class="list-six"><a href="@auth {{route('cart')}} @else {{route('login')}} @endauth"> @auth My
                                    cart @if(session()->has('cart'))  <div class="badge badge-dark"> {{count(session('cart'))}} @endif</div> @else Sign in  @endauth</a></li>
                        </ul>
                    </div>
                </div>
            <!--- End nav bar---->
            @yield('slider')
            </section>
        </div>
    </div>
</section>
@yield('content')
<footer class="page-footer font-small unique-color-dark">

    <div style="background-color: #FF6600; color:#fff;">
        <div class="container">

            <!-- Grid row-->
            <div class="row py-4 d-flex align-items-center">

                <!-- Grid column -->
                <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
                    <h6 class="mb-0">Get connected with us on social networks!</h6>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-6 col-lg-7 text-center text-md-right">

                    <!-- Facebook -->
                    <a class="fb-ic">
                        <i class="fab fa-facebook-f white-text mr-4"> </i>
                    </a>
                    <!-- Twitter -->
                    <a class="tw-ic">
                        <i class="fab fa-twitter white-text mr-4"> </i>
                    </a>
                    <!-- Google +-->
                    <a class="gplus-ic">
                        <i class="fab fa-google-plus-g white-text mr-4"> </i>
                    </a>
                    <!--Linkedin -->
                    <a class="li-ic">
                        <i class="fab fa-linkedin-in white-text mr-4"> </i>
                    </a>
                    <!--Instagram-->
                    <a class="ins-ic">
                        <i class="fab fa-instagram white-text"> </i>
                    </a>

                </div>
                <!-- Grid column -->

            </div>
            <!-- Grid row-->

        </div>
    </div>

    <!-- Footer Links -->
    <div class="container text-center text-md-left mt-5">

        <!-- Grid row -->
        <div class="row mt-3">

            <!-- Grid column -->
            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

                <!-- Content -->
                <h6 class="text-uppercase font-weight-bold"><span>I</span> l i f e</h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>Here you can use rows and columns to organize your footer content. Lorem ipsum dolor sit amet,
                    consectetur
                    adipisicing elit.</p>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

                <!-- Links -->
                <h6 class="text-uppercase font-weight-bold">Products</h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
@foreach(array_slice(\App\Product::$categories,0,4) as $category)
                <p>
                    <a href="{{url('shop/'.str_replace(' ','-',strtolower($category)))}}">{{strtoupper($category)}}</a>
                </p>
@endforeach

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">

                <!-- Links -->
                <h6 class="text-uppercase font-weight-bold">Useful links</h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>
                    <a href="{{route('account.index')}}">Your Account</a>
                </p>
                <p>
                    <a href="#!">Become a Retailer</a>
                </p>
                <p>
                    <a href="#!">Shipping</a>
                </p>
                <p>
                    <a href="#!">Help</a>
                </p>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

                <!-- Links -->
                <h6 class="text-uppercase font-weight-bold">Contact</h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>
                    <i class="fas fa-home mr-3"></i> NEW GIZA, NY 10012, EG</p>
                <p>
                    <i class="fas fa-envelope mr-3"></i> info@ilife-eg.com</p>
                <p>
                    <i class="fas fa-phone mr-3"></i> + 2 01 122 211 397</p>
                <p>
                    <i class="fas fa-print mr-3"></i> + 2 01 281 526 436</p>

            </div>
            <!-- Grid column -->

        </div>
        <!-- Grid row -->

    </div>
    <!-- Footer Links -->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2019 Copyright:
        <a href="#"> ILife.com</a>
        <br>
        Designed by: <a href="https://www.facebook.com/amirtadros.m" target="_blank">Amir Tadros</a>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->
<!----- End footer ------>

<!-- <div class="loading">
    <div class="spinner"></div>
</div> -->
<script src="{{asset('js/jquery-3.3.1.js')}}"></script>
<script src="{{asset('js/jquery.fittext.js')}}"></script>
<script src="{{asset('js/jquery.nicescroll.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
@yield('additionalJS')
<script src="{{asset('js/script.js')}}"></script>
</body>

</html>