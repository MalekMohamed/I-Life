@extends('layouts.app')
@section('additionalCSS')
    <link rel="stylesheet" href="{{asset('style/product.css')}}">
    <link rel="stylesheet" href="{{asset('style/sass/plugins/css-stars.css')}}">
@endsection
@section('content')
    <section class="product-section padding">
        <div class="container">
            <div class="row product-container">
                <div class="left-part col-lg-6">
                    <div class="row">
                        <h1 class=" product-title">@if ($item['status']) {{$item['name']}} @else
                                <del>{{$item['name']}}</del> <span class="text-danger">Out of Stock</span> @endif</h1>
                        <div class="col-lg-12 product-img">
                            <?php
                            $images = json_decode($item['images']) ?? 'default.png';
                            ?>
                            <img src="{!! $item->images() !!}" class="img-fluid"
                                 alt="product"></div>
                        <div class="col-lg-12 product-sm-img">
                            <div class="row">
                                <div class="col text-center thubmals">
                                    @if ($images != 'default.png')
                                        @foreach($images as $img)
                                            <img src="{{asset('img/shop/'.$item['id'].'/'.$img)}}" class="img-fluid "
                                                 alt="thubmal-1">
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-part col-lg-6">
                    <h2 class="h1 price">{{$item['price']}} EGP</h2>
                    <h6 class=" free-shoping">Free shipping <span><a href="#">Details</a></span></h6>
                    <hr>
                    <?php
                    $total = 0;
                    $UserRate = 0;
                    $rate = 0;
                    if (count($item['rating']) != 0) {
                        foreach ($item['rating'] as $value) {
                            $total = $value['rate'] + $total;
                        }
                        $rate = floor($total / count($item['rating']));

                    }
                    ?>
                    @auth
                        <?php
                        $UserRate = array_search(\Illuminate\Support\Facades\Auth::user()->id, array_column($item['rating']->toArray(), 'user_id')) ?? 'not_found';
                        ?>
                    @endauth
                    <div class="stars">
                        <div class="br-wrapper br-theme-css-stars"><select id="section1" style="display: none;">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>

                        </div>
                        <p class="normal">{{$rate}} ({{count($item['rating'])}}) </p>
                    </div>

                    <div class="color">
                        <h6>Color: </h6>
                        <br>
                        <ul class="list-unstyled text-center">
                            <?php
                            $item['color'] = explode(',', $item['color']);
                            ?>
                            @foreach($item['color'] as $color)
                                <li>
                                    <a onclick="$('.color-selected').removeClass('color-selected'),$(this).addClass('color-selected');"
                                       data-color="{{$color}}" style="background-color: {{$color}}"></a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="color">

                        <h6>Quantity: </h6>
                        <div class="text-center" style="margin-left: 100px;margin-top: -35px;">
                            <input type="number" class="form-control"
                                   style="width: 15%" id="quantity" value="1">
                        </div>
                    </div>
                    @if ($item['description'])
                        <div class="description">
                            <h6>Description: </h6>
                            <p class="lead">
                                {{$item['description']}}
                            </p>
                        </div>
                    @endif
                    <?php
                    echo "<script>var Product = " . json_encode($item) . "</script>";
                    ?>
                    @if ($item['status'])
                        <button onclick="addCart(Product,$('#quantity').val(),$('.color-selected').data('color'));"
                                class="add text-center">Add to cart
                        </button>
                    @else
                        <button disabled class="add text-center">Add to cart</button>
                    @endif


                </div>
            </div>
                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" style="display: none;"
                     role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <p class="msg-area"></p>
                </div>

            <hr>
        </div>
    </section>
    @php
        $specs = json_decode($item['specification']);
    @endphp
    @if(count((array) $specs) != 0)
        <section class="product-section2 mt-n5">
            <div class="container">
                <h2 class="h1 product-info">Product information</h2>
                <h4>Specifications</h4>
                <div class="specifications">

                    @foreach($specs as $key => $value)
                        <h6>{{$key}}</h6>
                        <p>{{$value}}</p>
                    @endforeach
                </div>
                <div class="clearfix"></div>
            </div>
        </section>
    @endif
    <section class="product-rating padding mt-n5">
        <div class="container">
            <div class="col-md-12">
                <hr>
                <h4 class="text-center mt-5">Customer Reviews</h4>

                <div class="row">
                    <div class="col-lg-6 rate-sec1 text-center">
                        <div class="circle">
                            <p class="text-center">{{$rate}}</p>
                        </div>
                        <div class="star">
                            <div class="br-wrapper br-theme-css-stars"><select id="stars-circle" style="display: none;">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>

                        <p class="lead">{{$rate}} out of 5</p>
                        <p class="lead">{{count($item['rating'])}} rating</p>
                    </div>

                    <div class="col-lg-6 rate-it ">
                        <h3 class="text-center">Rate This Product</h3>
                        <form class="rate-form" method="post" action="#">
                            @csrf
                            <input type="hidden" value="{{$item['id']}}" name="product_id">
                            @auth<input type="hidden" value="{{\Illuminate\Support\Facades\Auth::user()->id}}"
                                        name="user_id">@endauth
                            <div class="star ">
                                <select name="rate" id="rating">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="input-group p-2 mt-5">
                                <input type="text" name="comment" class="form-control" @auth placeholder="Comment.."
                                       @else placeholder="Please login to rate this product" disabled=""@endauth>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-warning">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (count($item['rating']) != 0)
        <section class="product-customer">
            <div class="container">
                <div class="col-md-12">
                    @foreach ($rates as $rateing)
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title float-right mt-2">
                                    @for($i = 0;$i<$rateing['rate'];$i++)
                                        <span class="fa fa-star text-warning"></span>
                                    @endfor
                                    @for($i = 0;$i<5-$rateing['rate'];$i++)
                                        <span class="fa fa-star"></span>
                                    @endfor
                                </div>
                                <div class="card-title float-left mt-2"><span
                                            class="name bold">{{$rateing['User']['firstname']}}</span></div>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{$rateing['comment']}}</p>
                            </div>
                            <div class="card-footer text-muted">
                                {{ date('d-M-Y', strtotime($rateing->updated_at)) ?? date('d-m-Y', strtotime($rateing->created_at)) }}
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <?php
    if ($UserRate == 'not_found' || $UserRate == false) {
        $UserRate = 0;
    } else {
        $UserRate = $item['rating'][$UserRate]['rate'];
    }
    ?>

@endsection
@section('additionalJS')
    <script src="{{asset('js/jquery.barrating.min.js')}}"></script>
    <script src="{{asset('js/script-prod.js')}}"></script>
    <script type="application/javascript">
        //----------Active Rate -----------
        $('#section1').barrating({
            theme: 'css-stars',
            initialRating: '{{$rate}}',
            readonly: true,
        });
        $('#stars-circle').barrating({
            theme: 'css-stars',
            initialRating: '{{$rate}}',
            readonly: true,
        });

        $('#rating').barrating({
            theme: 'css-stars',
            initialRating: '{{$UserRate ?? 0}}',
            readonly: false,
        });
        $('.rate-form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ url('rate-product') }}',
                method: "POST",
                data: $('.rate-form').serialize(),
                success: function (response) {
                    response = $.parseJSON(response);
                    if (response.status == 'success') {
                        $('.rate-form .form-control').val('');
                        var msg = '   <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show"\n' +
                            '                     role="alert">\n' +
                            '              ' + response.msg + '</div>';
                        $('.rate-form').after().append(msg);
                        window.location.reload();
                    }
                }
            });
        });

        function addCart(Item, Quantity, Color) {
            $.ajax({
                url: '{{ route('product.addCart') }}',
                method: "POST",
                data: {Item: Item, Color: Color, Quantity: Quantity,_token: '{{csrf_token()}}'},
                success: function (response) {
                    response = $.parseJSON(response);
                   $('.alert').show();
                   $('.msg-area').text(response.msg);
                    setTimeout(function(){ window.location.reload() },2000);
                }
            });
        }
    </script>
@endsection