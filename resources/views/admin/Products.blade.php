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
    <link href="{{asset('admin/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
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
                <h4 class="header-title">Products</h4>
                <?php
                echo "<script>var Products = " . json_encode($Products) . "</script>";
                ?>
                <div class="form-group float-right ml-2" style="margin-top: 0.55rem!important;">
                    <a data-toggle="modal" data-target="#add-modal" href="javascript:void(0);"
                       class="btn btn-primary"><i class="mdi mdi-plus-circle"></i> Add New Product</a>
                </div>
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
                        <th data-field="id" data-sortable="true" width="10">ID</th>
                        <th data-field="name" data-sortable="true" data-formatter="nameFormatter">Name</th>
                        <th data-field="category" data-sortable="true" data-formatter="categoryFormatter">Category</th>
                        <th data-field="date" data-sortable="true" data-formatter="dateFormatter">Updated Date</th>
                        <th data-field="colors" data-align="center" data-sortable="true">Colors</th>
                        <th data-field="Quantity" data-align="center" data-sortable="true">Quantity</th>
                        <th data-field="amount" data-align="center" data-sortable="true" data-sorter="priceSorter">
                            Price
                        </th>
                        <th data-align="center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($Products as $Product)
                        <?php
                        $Product['specification'] = json_decode($Product['specification']);

                        $Colors = explode(',', $Product->color);
                        ?>
                        <tr>
                            <td></td>
                            <td>{{$Product->id}}</td>
                            <td data-product="{{$Product->id}}"
                                data-category="{{str_replace(' ','-',strtolower($Product->category))}}">{{$Product->name}} </td>
                            <td>{{$Product->category}}</td>
                            <td>{{ date('d-M-Y@h:m A', strtotime($Product->updated_at))}}</td>
                            <td>
                                @foreach($Colors as $Color)
                                    <?php
                                    if (strtolower($Color) == 'white') {
                                        $Color = '#ced4da';
                                    }
                                    ?>
                                    <button disabled class="btn" style="background-color: {{$Color ?? '#ced4da'}};">

                                    </button>
                                @endforeach
                            </td>
                            <td>
                                <p>{!! $Product->Status() !!} </p> {{$Product->quantity ?? 0}}
                                Units
                            </td>

                            <td>$ {{ number_format($Product->price) ?? 0}}</td>
                            <td>
                                <button onclick="editProduct({{$Product['id']}})" role="button"
                                        class="btn btn-primary waves-effect waves-light"><i class="far fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $Products->links() }}
                <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog"
                     aria-labelledby="edit-modalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="edit-modalLabel">Edit Product</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                </button>
                            </div>
                            <form class="edit-product" action="#">
                                <div class="modal-body">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="id" class="control-label" style="">Product id</label>
                                                <input type="number" readonly class="form-control" name="id"
                                                       id="Product-id" placeholder="id">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="control-label"
                                                       style="">Name</label>
                                                <input type="text" class="form-control" name="name" required
                                                       id="Product-name" placeholder="Product name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Product-category" class="control-label"
                                                       style="">Category</label>
                                                <select id="Product-category" class="form-control" name="category"
                                                        required>
                                                    @foreach(\App\Product::$categories as $category)
                                                        <option id="{{$category}}"
                                                                value="{{$category}}">{{$category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Product-price" class="control-label"
                                                       style="">Price</label>
                                                <input type="text" class="form-control" name="price" required
                                                       id="Product-price" placeholder="Product Price">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Product-quantity" class="control-label"
                                                       style="">Quantity</label>
                                                <input type="number" class="form-control" min="0" name="quantity"
                                                       required
                                                       onchange="if($(this).val() ==0) {$('#Product-status').val(0),$('#Product-status option[value=1] ').css('display','none') } else {$('#Product-status option[value=1]').css('display','block') } "
                                                       id="Product-quantity">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Product-status" class="control-label"
                                                       style="">Status</label>
                                                <select id="Product-status" class="form-control" name="status" required>
                                                    <option value="1">Available</option>
                                                    <option value="0">Out of Stock.</option>
                                                    <option value="2">Hidden</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Product-color" class="control-label"
                                                       style="">Colors</label>
                                                <input type="text" class="form-control" pattern="^?([A-Za-z])+,$"
                                                       required
                                                       name="colors"
                                                       id="Product-color" placeholder="White,Red,Gray,Black,....">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Product-description" class="control-label"
                                                       style="">Description</label>
                                                <textarea class="form-control" id="Product-description"
                                                          name="description" style="height: 150px"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Product-specs" class="control-label"
                                                       style="">Additional Data</label>
                                                <textarea class="form-control" id="Product-specification"
                                                          name="specification"
                                                          placeholder="ex: Brand" style="height: 150px"></textarea>
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
                <div id="add-modal" class="modal fade" tabindex="-1" role="dialog"
                     aria-labelledby="add-modalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="add-modalLabel">Add Product</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                </button>
                            </div>
                            <form class="add-product" method="post"
                                  action="{{route('Products.store')}}" enctype="multipart/form-data">
                                <div class="modal-body">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="control-label"
                                                       style="">Name</label>
                                                <input type="text" class="form-control" name="name" required
                                                       id="Product-name" placeholder="Product name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Product-Category" class="control-label"
                                                       style="">Category</label>
                                                <select id="Product-Category" class="form-control" name="category"
                                                        required>
                                                    @foreach(\App\Product::$categories as $category)
                                                        <option id="{{$category}}"
                                                                value="{{$category}}">{{$category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Product-price" class="control-label"
                                                       style="">Price</label>
                                                <input type="text" class="form-control" name="price" required
                                                       id="Product-price" placeholder="Product Price">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Product-quantity" class="control-label"
                                                       style="">Quantity</label>
                                                <input type="number" class="form-control" min="0" name="quantity"
                                                       required
                                                       onchange="if($(this).val() ==0) {$('#add-modal').find('#Product-status').val(0),$('#add-modal').find('#Product-status option[value=1] ').css('display','none') } else {$('#add-modal').find('#Product-status option[value=1] ').css('display','block') } "
                                                       id="Product-quantity">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Product-status" class="control-label"
                                                       style="">Status</label>
                                                <select id="Product-status" class="form-control" name="status" required>
                                                    <option value="1">Available</option>
                                                    <option value="0">Out of Stock.</option>
                                                    <option value="2">Hidden</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Product-color" class="control-label"
                                                       style="">Colors</label>
                                                <input type="text" class="form-control" pattern="^?([A-Za-z])+,$"
                                                       required
                                                       name="colors"
                                                       id="Product-color" placeholder="White,Red,Gray,Black,....">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Product-description" class="control-label"
                                                       style="">Description</label>
                                                <textarea class="form-control" id="Product-description"
                                                          name="description" style="height: 150px"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="images[]"
                                                               accept="image/x-png,image/gif,image/jpeg"
                                                               class="custom-file-input" multiple
                                                               id="inputGroupFile04">
                                                        <label class="custom-file-label" for="inputGroupFile04">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="details-row">

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" onclick="addNewInput()"
                                                    class="add-input-btn btn btn-danger waves-effect waves-light"><i
                                                        class="fas fa-plus"></i> Add new Field
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-success waves-effect waves-light"><i
                                                class="fas fa-check"></i> Add
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
    <script src="{{asset('admin/libs/dropzone/dropzone.min.js')}}"></script>

    <script>
        $('.pagination').addClass('justify-content-end pagination-rounded');

        function removeOrder(e, z, t) {
            $.ajax({
                url: '{{ route('Products.remove') }}',
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

        function editProduct(id) {
            var Product = Products.data.find(x => x.id == id);
            $.each(Product, function (key, value) {
                $('#edit-modal').find('.modal-body').find('#Product-' + key).val(value);
            });
            $('#edit-modal').modal('show');
        }

        $('.edit-product').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('Products.update') }}',
                method: "patch",
                data: $('.edit-product').serialize(),
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
        /*Dropzone.options.myAwesomeDropzone =
            {
                maxFilesize: 12,
                renameFile: function(file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time+file.name;
                },
                acceptedFiles: ".jpeg,.jpg,.png",
                uploadMultiple:true,
                parallelUploads: 5,
                maxFiles:5,
                paramName:'images',
                addRemoveLinks: true,
                timeout: 5000,
                successmultiple: function (file) {
                },
                error: function(file, response)
                {
                    return false;
                }
            };*/
        $('.add-product').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('.add-product')[0]);
            $.ajax({
                url: $('.add-product').attr('action'),
                method: "post",
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    response = $.parseJSON(response);
                    console.log(response);
                    $('#add-modal').modal('hide');
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

        function saveInput(field) {
            if ($('#Input-' + field + '-type').val() !== 'textarea') {
                var newfield = '<div class="col-md-12">\n' +
                    '                                            <div class="form-group">\n' +
                    '                                                <label for="' + $('#Input-' + field + '-name').val() + '" class="control-label"\n' +
                    '                                                       style="">' + $('#Input-' + field + '-name').val() + '</label>\n' +
                    '                                                <input type="' + $('#Input-' + field + '-type').val() + '" class="form-control"\n' +
                    '                                                       id="' + $('#Input-' + field + '-name').val() + '" name="specification[' + $('#Input-' + field + '-name').val() + ']" placeholder="ex: Brand">\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                       </div>\n' +
                    '                                    </div>';
            } else {
                var newfield = '<div class="col-md-12">\n' +
                    '                                            <div class="form-group">\n' +
                    '                                                <label for="' + $('#Input-' + field + '-name').val() + '" class="control-label"\n' +
                    '                                                       style="">' + $('#Input-' + field + '-name').val() + '</label>\n' +
                    '                                                <textarea class="form-control"\n' +
                    '                                                       id="' + $('#Input-' + field + '-name').val() + '" name="specification[' + $('#Input-' + field + '-name').val() + ']" placeholder="ex: Brand"></textarea>\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                       </div>\n' +
                    '                                    </div>';
            }
            $('#input-' + field).html(newfield);
        }

        var i = 1;

        function addNewInput() {
            var field = ' <div class="row" id="input-' + i + '">\n' +
                '                                        <div class="col-md-4">\n' +
                '                                            <div class="form-group">\n' +
                '                                                <label for="Input-' + i + '-name" class="control-label"\n' +
                '                                                       style="">Input Name</label>\n' +
                '                                                <input type="text" class="form-control"\n' +
                '                                                       id="Input-' + i + '-name" value="Input-' + i + '" placeholder="ex: Brand">\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="col-md-4">\n' +
                '                                          <div class="form-group">\n' +
                '                                                <label for="Input-' + i + '-type" class="control-label"\n' +
                '                                                       style="">Input Type</label>\n' +
                '                                                <select class="form-control" id="Input-' + i + '-type"><option value="text" selected>Text</option><option value="Number">Number</option> <option value="textarea">TextArea</option>\n' +
                '                                                </select>\n' +
                '                                            </div></div>\n' +
                '                                       <div class="col-md-4 mt-3">\n' +
                '                                       <button type="button" class="btn btn-success waves-effect" onclick="saveInput(' + i + ');"><i class="fas fa-check"></i></button>\n' +
                '                                       <button type="button" class="btn btn-danger waves-effect" onclick="$(\'#input-' + i + '\').slideUp(\'normal\', function() {$(this).remove()});"><i class="fas fa-times"></i> </button>\n' +
                '                                        </div>\n' +
                '                                    </div>';

            $('.details-row').append(field);
            i++;
        }
    </script>
    <script src="{{asset('admin/js/pages/bootstrap-tables.init.js')}}"></script>
@endsection