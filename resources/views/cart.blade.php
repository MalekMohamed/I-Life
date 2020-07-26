@extends('layouts.app')
@section('additionalCSS')
    @if(session('cart'))
        <link rel="stylesheet" href="{{asset('style/fill-cart.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('style/empty-cart.css')}}">
    @endif
@endsection
@section('content')
    <section class="cart padding ">
        <div class="container">
            <div class="row">
                <div class="col-md-@if(session('cart')){{8}}@else{{12}}@endif">
                    <h4 @if(session('cart')) class=" float-right" @endif>Your Cart</h4>
                    <?php $total = 0 ?>
                    @if(session('cart'))
                        <div class="table-responsive">
                            <a style="width: auto" href="{{ route('shop') }}" role="button"
                               class="btn btn-warning mb-1"><i
                                        class="fas fa-angle-left"></i> Continue Shopping</a>

                            <table id="cart" class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Product</th>
                                    <th style="width: 15%;">Color</th>
                                    <th style="width: 8%">Quantity</th>
                                    <th>Price</th>
                                    <th style="width: 15%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(session('cart') as $id => $details)
                                    <?php $total += $details['price'] * $details['quantity'];
                                    if (is_array(json_decode($details['image']))) {
                                        $image = $details['id'].'/'.json_decode($details['image'])[0];
                                    } else {
                                        $image = '/default.png';
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="col-md-8 hidden-xs"><img
                                                        src="{{asset('img/shop/'.$image)}}"
                                                        class="img-responsive img-thumbnail"/></div>
                                        </td>
                                        <td data-th="Product">
                                            <h5>{{ $details['name'] }}</h5>
                                        </td>

                                        <td data-th="color">
                                            <select class="form-control color" data-id="{{ $id }}">
                                                @foreach($details['colors'] as $color)
                                                    <option value="{{ $color }}"
                                                            @if($color == $details['selected-color']) selected @endif>{{ $color }}</option>
                                                @endforeach
                                            </select>

                                        </td>
                                        <td data-th="Quantity">
                                            <input type="number" data-id="{{ $id }}" value="{{ $details['quantity'] }}"
                                                   class="form-control quantity"/>
                                        </td>
                                        <td data-th="Price">${{ $details['price'] }}</td>
                                        <td class="actions" data-th="">
                                            <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}">
                                                <i
                                                        class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                            </table>
                            @else
                                <svg class="text-center  m-auto d-block" fill="#ff6600" viewBox="0 0 231.523 231.523"
                                     xml:space="preserve"
                                     height="200px" width="200px">
        <g>
            <path d="M107.415,145.798c0.399,3.858,3.656,6.73,7.451,6.73c0.258,0,0.518-0.013,0.78-0.04c4.12-0.426,7.115-4.111,6.689-8.231
		l-3.459-33.468c-0.426-4.12-4.113-7.111-8.231-6.689c-4.12,0.426-7.115,4.111-6.689,8.231L107.415,145.798z"/>
            <path d="M154.351,152.488c0.262,0.027,0.522,0.04,0.78,0.04c3.796,0,7.052-2.872,7.451-6.73l3.458-33.468
		c0.426-4.121-2.569-7.806-6.689-8.231c-4.123-0.421-7.806,2.57-8.232,6.689l-3.458,33.468
		C147.235,148.377,150.23,152.062,154.351,152.488z"/>
            <path d="M96.278,185.088c-12.801,0-23.215,10.414-23.215,23.215c0,12.804,10.414,23.221,23.215,23.221
		c12.801,0,23.216-10.417,23.216-23.221C119.494,195.502,109.079,185.088,96.278,185.088z M96.278,216.523
		c-4.53,0-8.215-3.688-8.215-8.221c0-4.53,3.685-8.215,8.215-8.215c4.53,0,8.216,3.685,8.216,8.215
		C104.494,212.835,100.808,216.523,96.278,216.523z"/>
            <path d="M173.719,185.088c-12.801,0-23.216,10.414-23.216,23.215c0,12.804,10.414,23.221,23.216,23.221
		c12.802,0,23.218-10.417,23.218-23.221C196.937,195.502,186.521,185.088,173.719,185.088z M173.719,216.523
		c-4.53,0-8.216-3.688-8.216-8.221c0-4.53,3.686-8.215,8.216-8.215c4.531,0,8.218,3.685,8.218,8.215
		C181.937,212.835,178.251,216.523,173.719,216.523z"/>
            <path d="M218.58,79.08c-1.42-1.837-3.611-2.913-5.933-2.913H63.152l-6.278-24.141c-0.86-3.305-3.844-5.612-7.259-5.612H18.876
		c-4.142,0-7.5,3.358-7.5,7.5s3.358,7.5,7.5,7.5h24.94l6.227,23.946c0.031,0.134,0.066,0.267,0.104,0.398l23.157,89.046
		c0.86,3.305,3.844,5.612,7.259,5.612h108.874c3.415,0,6.399-2.307,7.259-5.612l23.21-89.25C220.49,83.309,220,80.918,218.58,79.08z
		 M183.638,165.418H86.362l-19.309-74.25h135.895L183.638,165.418z"/>
            <path d="M105.556,52.851c1.464,1.463,3.383,2.195,5.302,2.195c1.92,0,3.84-0.733,5.305-2.198c2.928-2.93,2.927-7.679-0.003-10.607
		L92.573,18.665c-2.93-2.928-7.678-2.927-10.607,0.002c-2.928,2.93-2.927,7.679,0.002,10.607L105.556,52.851z"/>
            <path d="M159.174,55.045c1.92,0,3.841-0.733,5.306-2.199l23.552-23.573c2.928-2.93,2.925-7.679-0.005-10.606
		c-2.93-2.928-7.679-2.925-10.606,0.005l-23.552,23.573c-2.928,2.93-2.925,7.679,0.005,10.607
		C155.338,54.314,157.256,55.045,159.174,55.045z"/>
            <path
                    d="M135.006,48.311c0.001,0,0.001,0,0.002,0c4.141,0,7.499-3.357,7.5-7.498l0.008-33.311c0.001-4.142-3.356-7.501-7.498-7.502
		c-0.001,0-0.001,0-0.001,0c-4.142,0-7.5,3.357-7.501,7.498l-0.008,33.311C127.507,44.951,130.864,48.31,135.006,48.311z"/>
        </g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
      </svg>
                                <h3 class="text-center">Your cart is currently empty.</h3>
                                <a href="{{route('shop')}}">
                                    <button class="btn text-center m-auto d-block">Return to shop</button>
                                </a>

                            @endif
                        </div>
                </div>
                @if(session('cart'))
                    <div class="col-md-4 card pt-2 mb-4 ">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Your cart</span>
                            <span
                                    class="badge badge-secondary badge-pill">{{count(session('cart'))}}</span>
                        </h4>
                        <ul class="list-group mb-3">
                            <li class="list-group-item  d-flex justify-content-between">
                                <span>Total (USD)</span>
                                <span class="total">${{ $total }}</span>
                            </li>
                        </ul>

                        <form class="card p-2 mb-2" method="post" action="#">
                            <div class="input-group">
                                <input type="text" class="form-control code" placeholder="Promo code">
                                <div class="input-group-append">
                                    <button type="button" onclick="checkCode($('.code'));" class="btn btn-secondary">
                                        Redeem
                                    </button>
                                </div>
                            </div>
                        </form>
                        <a href="{{url('cart/check-out')}}" role="button" class="mb-2 btn btn-success"><i
                                    class="fa fa-shopping-cart"></i>
                            Check out</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
@section('additionalJS')
    <script type="text/javascript">

        $(".color").change(function (e) {
            e.preventDefault();
            var ele = $(this);
            updateCart(ele.attr("data-id"), ele.parents("tr").find(".color").val(), ele.parents("tr").find(".quantity").val());
        });
        $(".quantity").change(function (e) {
            e.preventDefault();
            var ele = $(this);
            console.log(ele);
            updateCart(ele.attr("data-id"), ele.parents("tr").find(".color").val(), ele.val());
        });

        function updateCart(id, color, quantity) {
            $.ajax({
                url: '{{ url('update-cart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    color: color,
                    quantity: quantity
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }

        function checkCode(element) {
            $.ajax({
                url: '{{ url('check-code') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    code: element.val()
                },
                success: function (response) {
                    response = $.parseJSON(response);
                    $('.total').html('<del>${{$total}}</del><p class="text-success font-weight-bold">$' + response.data + '</p>');
                    $('.total').parent().find('span:first-child').html('Total (USD) <p class="text-success font-weight-bold">You saved ' + response.discount + '%</p>');
                }
            });
        }

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            if (confirm("Are you sure you want delete this item from the cart?")) {
                $.ajax({
                    url: '{{ url('remove-from-cart') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });

    </script>
@endsection