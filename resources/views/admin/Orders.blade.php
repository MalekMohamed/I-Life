<?php
/**
 * Created by PhpStorm.
 * User: Strix
 * Date: 8/5/2019
 * Time: 5:36 PM
 */
?>
@extends('admin.layout')
@section('customCSS')
    <link href="{{asset('admin/libs/bootstrap-table/bootstrap-table.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .control-label:first-letter, option, select {
            text-transform: capitalize !important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title">Users Orders</h4>
                <?php
                echo "<script>var Items = " . json_encode($Orders) . "</script>";
                ?>
                <button id="demo-delete-row" class="btn btn-danger btn-sm" disabled><i class="mdi mdi-close mr-1"></i>Delete
                </button>
                <table id="demo-custom-toolbar" data-toggle="table"
                       data-toolbar="#demo-delete-row"
                       data-search="true"
                       data-show-columns="true"
                       data-sort-name="id" class="table-borderless">
                    <thead class="thead-light">
                    <tr>
                        <th data-field="state" data-checkbox="true"></th>
                        <th data-field="id" data-sortable="true" data-formatter="invoiceFormatter">Order ID</th>
                        <th data-field="name" data-sortable="true" data-formatter="nameFormatter">Name</th>
                        <th data-field="date" data-sortable="true" data-formatter="dateFormatter">Order Date</th>
                        <th data-field="color" data-sortable="true">Color</th>
                        <th data-field="quantity" data-align="center" data-sortable="true">Quantity</th>
                        <th data-field="amount" data-align="center" data-sortable="true" data-sorter="priceSorter">
                            Price
                        </th>
                        <th data-field="status" data-align="center" data-sortable="true"
                            data-formatter="statusFormatter">Status
                        </th>
                        <th data-align="center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($Orders as $Order)
                        <?php
                        $Order['details'] = json_decode($Order['details']);
                        ?>
                        @if ($Order->Product)
                            <tr>
                                <td></td>
                                <td>{{$Order->id}}</td>
                                <td data-product="{{$Order->Product->id}}"
                                    data-price="{{$Order->Product->price}}">{{$Order->Product->name}} </td>
                                <td>{{ date('d-M-Y@h:m A', strtotime($Order->updated_at))}}</td>
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
                                <td>{{$Order['details']->quantity ?? 1}}</td>
                                <td>$ {{ number_format($Order['details']->total) ?? 0}}</td>
                                <td>
                                    <div class="badge font-13 label-table badge-{{\App\Order::$Status[$Order->status]['class']}}"> {{\App\Order::$Status[$Order->status]['status']}}</div>
                                </td>
                                <td>
                                    <button onclick="editOrder({{$Order['id']}})" role="button"
                                            class="btn btn-primary waves-effect waves-light"><i class="far fa-edit"></i>
                                    </button>
                                    @if($Order['details']->promo)
                                        <div class="btn btn-danger"><i class="fas fa-tag mr-1"></i> Offer</div>
                                    @endif

                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                {{ $Orders->links() }}
                <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog"
                     aria-labelledby="edit-modalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="edit-modalLabel">Edit Order</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                </button>
                            </div>
                            <form class="edit-order" action="#">
                                <div class="modal-body">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="id" class="control-label" style="">Order id</label>
                                                <input type="number" readonly class="form-control" name="id"
                                                       id="Order-id" placeholder="id">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user_id" class="control-label" style="">User id</label>
                                                <input type="number" readonly class="form-control" name="user_id"
                                                       id="Order-user_id" placeholder="user_id">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_id" class="control-label"
                                                       style="">Product</label>
                                                <input type="text" readonly class="form-control" name="product_id"
                                                       id="Order-product_id" placeholder="product_id">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Order-status" class="control-label" style="">status</label>
                                                <select id="Order-status" class="form-control" name="status">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row details-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Order-color" class="control-label">color</label>
                                                <select id="Order-color" class="form-control" name="color">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="quantity" class="control-label">quantity</label>
                                                <input type="number" class="form-control"
                                                       onchange="$('#Order-total').val($(this).val() * parseInt($('.product-link').parent().data('price')));"
                                                       name="quantity"
                                                       id="Order-quantity" placeholder="Quantity">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row details-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="total" class="control-label">total</label>
                                                <input type="number" class="form-control" name="total" readonly
                                                       id="Order-total" placeholder="total">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light"><i
                                                class="fas fa-check"></i> Save
                                    </button>
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div>
        </div>
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

        function editOrder(id) {
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

        $('.edit-order').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('Orders.update') }}',
                method: "patch",
                data: $('.edit-order').serialize(),
                success: function (response) {
                    response = $.parseJSON(response);
                    console.log(response);
                    $('#edit-modal').modal('hide');
                    if (response.status == 'success') {
                        Swal.fire({
                            title: "Saved!",
                            text: response.msg,
                            type: response.status,
                            confirmButtonClass: "btn btn-confirm mt-2"
                        });
                    } else {
                        Swal.fire({
                            type: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                            confirmButtonClass: "btn btn-confirm mt-2",
                            footer: '<a href="{{route('help')}}">Why do I have this issue?</a>'
                        })
                    }
                }
            });
        });

    </script>
    <script src="{{asset('admin/js/pages/bootstrap-tables.init.js')}}"></script>
@endsection