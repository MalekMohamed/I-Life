@extends('layouts.app')
@section('additionalCSS')
    <link rel="stylesheet" href="{{asset('style/homepage.css')}}">
@endsection
@section('slider')
    <h2 class="art resize text-center" style="font-size: 40px;">THE ART OF WELLBEING</h2>
    <div class="float-down">
        <button class="btn text-center d-block"><i class="fas fa-chevron-circle-down fa-2x"></i></button>
    </div>

    <div class="move">
        <span class="small-dot active-dot b-one"><span class="dot"></span></span>
        <span class="small-dot b-two"><span class="dot"></span></span>
        <span class="small-dot b-three"><span class="dot"></span></span>
        <span class="small-dot b-four"><span class="dot"></span></span>
        <span class="small-dot b-five"><span class="dot"></span></span>
    </div>
@endsection
@section('content')
    <!----- End header------>

    <!----- Start our product------>
    <section class="our-product text-center padding padding-sm">
        <div class="container">
            <h2 class="h1 underline">Our product</h2>
            <div class="row">
                @foreach($feature_Items as $item)
                    <div class="col-lg-3 col-md-6 col-xs-12">
                        <a href="{{ url('product/'.$item['id']) }}"><img class="img-fluid"
                                                                         src="{!! $item->images() !!}"
                                                                         alt="{{$item['name']}}"></a>
                    </div>
                @endforeach
            </div>
            <a href="{{route('shop')}}">
                <button class="see-more btn">See More</button>
            </a>
        </div>
    </section>
    <!----- End our product------>

    <!----- Start Sensors------>
    <section class="sensors padding padding-sm">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 text-center">
                    <img class="img-fluid" src="{{asset('img/homepage/section1.jpg')}}" alt="Sensors">
                </div>
                <div class="col-lg-6 col-md-12 text-center text-lg-left">
                    <h2 class="h1">Create a new life of smart safety</h2>
                    <p class="lead">S1 accesses the sensor/detector through the 433MHz RF signal. Once the
                        sensor/detector is triggered, S1 will sound a buzzer and promptly push you a message</p>
                    <div class="row text-center">
                        <div class="col">
                            <i class="fas fa-user-secret fa-3x"></i>
                            <p>Secured</p>
                        </div>
                        <div class="col">
                            <i class="fas fa-globe-americas fa-3x"></i>
                            <p>Any Where</p>
                        </div>
                        <div class="col">
                            <i class="fas fa-mobile-alt fa-3x"></i>
                            <p>Easy To Use</p>
                        </div>
                        <div class="col">
                            <i class="fas fa-clock fa-3x"></i>
                            <p>Routine</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!----- End Sensors------>

    <!----- Start fixed-img------>
    <section class="fixed-img">
    </section>
    <!----- End fixed-img------>

    <!----- Start Voice Control------>
    <section class="voice padding padding-sm">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 text-center text-lg-left">
                    <h2 class="h1">Control every thing with your voice
                    </h2>
                    <p class="lead">Now you can control TV , Power strip , Electric curtain , Smart socket , Wall switch
                        and meny more using <strong> Alexa or Google Home</strong> with using your voise from all over
                        the internet and from any where in the world . Just ask
                    </p>
                </div>

                <div class="col-lg-6 col-md-12 text-center">
                    <img class="img-fluid" src="{{asset('img/homepage/section4.jpg')}}" alt="Sensors">
                </div>
            </div>
        </div>
    </section>
    <!----- End Voice Control------>

    <!----- Start subscription------>
    <section class="subscription">
        <div class="overlay">
            <div class="container text-center padding">
                <form class="from">
                    <div class="row">
                        <div class="col-lg-10">
                            <input type="email" class="form-control text-center" id="inputEmail"
                                   placeholder="Enter your email for news and specal offers">
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" class="btn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!----- End subscription ------>

@endsection