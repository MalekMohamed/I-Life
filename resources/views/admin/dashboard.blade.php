<?php
/**
 * Created by PhpStorm.
 * User: Strix
 * Date: 8/5/2019
 * Time: 11:46 AM
 */
?>
@extends('admin.layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">i-Life</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded bg-soft-primary">
                            <i class="dripicons-wallet font-24 avatar-title text-primary"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1">$<span data-plugin="counterup">{{number_format($TotalRevenue)}}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Total Revenue</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded bg-soft-success">
                            <i class="dripicons-basket font-24 avatar-title text-success"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{number_format($TotalOrders)}}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Orders</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded bg-soft-info">
                            <i class="dripicons-store font-24 avatar-title text-info"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{number_format($TotalProducts)}}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Stores</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded bg-soft-warning">
                            <i class="dripicons-user-group font-24 avatar-title text-warning"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{number_format($TotalUsers)}}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Sellers</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card-box">
                <a href="{{route('Admin.Orders')}}" class="btn btn-primary waves-effect waves-light float-right">See more</a>
                <h4 class="header-title mb-3">Orders History</h4>

                <div class="table-responsive">
                    <table class="table table-centered table-hover mb-0">
                        <thead>
                        <tr>
                            <th class="border-top-0">User</th>
                            <th class="border-top-0">Product</th>
                            <th class="border-top-0">Color</th>
                            <th class="border-top-0">Date</th>
                            <th class="border-top-0">Amount</th>
                            <th class="border-top-0">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($Orders as $Order)
                            <?php
                            $Order['details'] = json_decode($Order['details']);
                            ?>
                            @if ($Order->Product)
                                <tr>
                                    <td>
                                        <span class="ml-2">{{$Order->User->firstname}}</span>
                                    </td>
                                    <td>
                                        <img src="{{$Order->Product->images()}}" alt="user-card" height="24">
                                        <a href="{{route('product.show',$Order->Product)}}"><span class="ml-2">{{$Order->Product->name}}</span></a>
                                    </td>
                                    <?php
                                    if (strtolower($Order['details']->color) == 'white') {
                                        $Order['details']->color = '#ced4da';
                                    }
                                    ?>
                                    <td>
                                        <button disabled class="btn"
                                                style="background-color: {{$Order['details']->color ?? '#ced4da'}};">

                                        </button>
                                    </td>
                                    <td>{{ date('d-M-Y@h:m A', strtotime($Order->updated_at))}}</td>
                                    <td>{{ number_format($Order['details']->quantity)}} Units</td>
                                    <td>
                                        <div class="badge label-table badge-{{\App\Order::$Status[$Order->status]['class']}}"> {{\App\Order::$Status[$Order->status]['status']}}</div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div> <!-- end table-responsive -->

            </div> <!-- end card-box-->
        </div> <!-- end col-->
        <div class="col-xl-6">
            <div class="card-box">
                <a href="{{route('Admin.Products')}}" class="btn btn-primary waves-effect waves-light float-right">See more</a>
                <h4 class="header-title mb-3">Recent Products</h4>

                <div class="table-responsive">
                    <table class="table table-centered table-hover mb-0">
                        <thead>
                        <tr>
                            <th class="border-top-0">Product</th>
                            <th class="border-top-0">Category</th>

                            <th class="border-top-0">Quantity</th>
                            <th class="border-top-0">Price</th>
                            <th class="border-top-0">Added Date</th>
                            <th class="border-top-0">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($Products as $Product)
                            <?php
                            $Product['specification'] = json_decode($Product['specification']);

                            $Colors = explode(',', $Product->color);
                            ?>
                            <tr>
                                <td> <img src="{{$Product->images()}}" alt="user-card" height="36"><a href="{{route('product.show',$Product)}}"><span class="ml-2">{{$Product->name}}</span></a></td>
                                <td>{{$Product->category}}</td>

                                <td>
                                    {{$Product->quantity ?? 0}}
                                    Units
                                </td>
                                <td>$ {{ number_format($Product->price) ?? 0}}</td>
                                <td>{{ date('d-M-Y', strtotime($Product->updated_at))}}</td>
                                <td><p>{!! $Product->Status() !!} </p> </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div> <!-- end table-responsive -->
            </div> <!-- end card-box-->
        </div> <!-- end col-->
    </div>
@endsection
@section('customJS')
    <script src="{{asset('admin/libs/bootstrap-table/bootstrap-table.min.js')}}"></script>
    <script src="{{asset('admin/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script>
        $('.pagination').addClass('justify-content-end pagination-rounded');

        function removeOrder(e, z, t) {
            $.ajax({
                url: '{{ route('Orders.remove') }}',
                method: "delete",
                data: {_token: '{{csrf_token()}}', data: e},
                success: function (response) {
                    response = $.parseJSON(response);
                    if (response.status == 'success') {
                        z.value && Swal.fire("Deleted!", response.msg, response.status);
                        t.bootstrapTable("remove", {
                            field: "id",
                            values: e
                        }), $("#demo-delete-row").prop("disabled", !0);
                    }
                }
            });
        }

        function editUser(id) {
            var Order = Items.data.find(x => x.id == id);
            var OrderDetails = $.parseJSON(Order.details);
            var Colors = Order.product.color.split(',');
            var Status = $.parseJSON('<?php echo json_encode(\App\Order::$Status);?>');
            $('#edit-modalLabel').text('Edit Order #' + id);
            $('#Order-status , #Order-color').html('');
            $.each(Status, function (key, value) {
                if (value == Status[Order.status].status) {
                    $('#edit-modal').find('.modal-body').find('#Order-status').append('<option selected value="' + key + '">' + value.status + '</option>');
                } else {
                    $('#edit-modal').find('.modal-body').find('#Order-status').append('<option value="' + key + '">' + value.status + '</option>');
                }
            });
            $.each(Colors, function (key, value) {
                if (value == OrderDetails.color) {
                    $('#edit-modal').find('.modal-body').find('#Order-color').append('<option selected value="' + value + '">' + value + '</option>');
                } else {
                    $('#edit-modal').find('.modal-body').find('#Order-color').append('<option value="' + value + '">' + value + '</option>');
                }
            });
            $.each(Order, function (key, value) {
                if (typeof value !== 'object') {
                    $('#edit-modal').find('.modal-body').find('#Order-' + key).val(value);
                }
            });
            $('#edit-modal').find('.modal-body').find('#Order-product_id').val(Order.product.name);
            $.each(OrderDetails, function (key, value) {
                if (key !== 'promo' && key !== 'total') {
                    $('#edit-modal').find('.details-row').find('#Order-' + key).val(value);
                }
            });
            $('#edit-modal').find('.details-row').find('#Order-total').val($('#Order-quantity').val() * Order.product.price);
            $('#edit-modal').modal('show');
        }
    </script>
    <script src="{{asset('admin/js/pages/bootstrap-tables.init.js')}}"></script>
@endsection