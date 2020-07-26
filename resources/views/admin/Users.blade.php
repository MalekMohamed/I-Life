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
                <h4 class="header-title">Users</h4>
                <?php
                echo "<script>var Users = " . json_encode($Users) . "</script>";
                ?>
                <div class="form-group float-right ml-2" style="margin-top: 0.55rem!important;">
                    <a data-toggle="modal" data-target="#add-modal" href="javascript:void(0);" class="btn btn-primary"><i class="mdi mdi-plus-circle"></i> Add New User</a>
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
                        <th data-field="id" data-sortable="true">ID</th>
                        <th data-field="name" data-sortable="true">Name</th>
                        <th data-field="phone" data-sortable="true">Phone</th>
                        <th data-field="email" data-sortable="true">Email</th>
                        <th data-field="date" data-sortable="true" data-formatter="dateFormatter">Created Date</th>
                        <th data-align="center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($Users as $User)
                        <tr>
                            <td></td>
                            <td>{{$User->id}}</td>
                            <td><span class="@if($User->isAdmin()) text-danger @endif">{{$User->firstname}} {{$User->lastname}}</span> </td>
                            <td>{{$User->phone}}</td>
                            <td>{{$User->email}}</td>
                            <td>{{ date('d-M-Y@h:m A', strtotime($User->updated_at))}}</td>
                            <td>
                                <button onclick="editUser({{$User->id}})" role="button"
                                        class="btn btn-primary waves-effect waves-light"><i class="far fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $Users->links() }}
                <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog"
                     aria-labelledby="edit-modalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="edit-modalLabel">Edit User</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                </button>
                            </div>
                            <form class="edit-user" action="#">
                                <div class="modal-body">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="User-id" class="control-label" style="">User id</label>
                                                <input type="number" required readonly class="form-control" name="id"
                                                       id="User-id" placeholder="id">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="User-firstname" class="control-label" style="">First
                                                    name</label>
                                                <input type="text" required class="form-control" name="firstname"
                                                       id="User-firstname" placeholder="First name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="User-lastname" class="control-label" style="">Last
                                                    name</label>
                                                <input type="text" required class="form-control" name="lastname"
                                                       id="User-lastname" placeholder="Last name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="User-email" class="control-label" style="">Email</label>
                                                <input type="email" required class="form-control" name="email"
                                                       id="User-email" placeholder="Email@domain.com">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="User-password" class="control-label" style="">Password</label>
                                                <input type="password" class="form-control" name="password"
                                                       id="User-password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="User-address" class="control-label">Address</label>
                                                <input type="text" class="form-control" name="address"
                                                       id="User-address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="User-admin" class="control-label">Is Admin</label>
                                                <select id="User-admin" class="form-control" name="admin">
                                                    <option value="1">True</option>
                                                    <option value="0">False</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="User-phone" class="control-label" style="">Phone</label>
                                                <input type="text" class="form-control" name="phone"
                                                       id="User-phone">
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
                                <h4 class="modal-title" id="add-modalLabel">Add User</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                </button>
                            </div>
                            <form class="add-user" action="#">
                                <div class="modal-body">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="User-firstname" class="control-label" style="">First
                                                    name</label>
                                                <input type="text" required class="form-control" name="firstname"
                                                       id="User-firstname" placeholder="First name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="User-lastname" class="control-label" style="">Last
                                                    name</label>
                                                <input type="text" required class="form-control" name="lastname"
                                                       id="User-lastname" placeholder="Last name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="User-email" class="control-label" style="">Email</label>
                                                <input type="email" required class="form-control" name="email"
                                                       id="User-email" placeholder="Email@domain.com">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="User-password" class="control-label" style="">Password</label>
                                                <input type="password" class="form-control" name="password"
                                                       id="User-password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="User-address" class="control-label">Address</label>
                                                <input type="text" class="form-control" name="address"
                                                       id="User-address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="User-admin" class="control-label">Is Admin</label>
                                                <select id="User-admin" class="form-control" name="admin">
                                                    <option value="1">True</option>
                                                    <option value="0">False</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="User-phone" class="control-label" style="">Phone</label>
                                                <input type="text" class="form-control" name="phone"
                                                       id="User-phone">
                                            </div>
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
    <script>
        $('.pagination').addClass('justify-content-end pagination-rounded');

        function removeOrder(e, z, t) {
            $.ajax({
                url: '{{ route('Users.remove') }}',
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
            var User = Users.data.find(x => x.id == id);

            $('#edit-modalLabel').text('Edit User #' + id);
            $.each(User, function (key, value) {
                if (typeof value !== 'object') {
                    $('#edit-modal').find('.modal-body').find('#User-' + key).val(value);
                }
            });
            $('#edit-modal').modal('show');
        }

        $('.edit-user').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('Users.update') }}',
                method: "patch",
                data: $('.edit-user').serialize(),
                success: function (response) {
                    response = $.parseJSON(response);
                    console.log(response);
                    if (response.status == 'success') {
                        $('#edit-modal').modal('hide');
                        Swal.fire({
                            title: "Saved!",
                            text: response.msg,
                            type: response.status,
                            confirmButtonClass: "btn btn-confirm mt-2"
                        });
                    } else {
                        if (response.errors.length != 0) {
                            $('.invalid-feedback').remove();
                            $('#edit-modal').find('.modal-body').find('.is-invalid').removeClass('is-invalid');
                            $.each(response.errors, function (key, value) {
                                if (!$('#User-' + key).next('.invalid-feedback').length) {
                                    $('#edit-modal').find('.modal-body').find('#User-' + key).after('<div class="invalid-feedback" style="display: block;">' + value + '</div>');
                                    $('#edit-modal').find('.modal-body').find('#User-' + key).addClass('is-invalid');
                                }
                            });
                        } else {
                            Swal.fire({
                                type: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                                confirmButtonClass: "btn btn-confirm mt-2",
                                footer: '<a href="{{route('help')}}">Why do I have this issue?</a>'
                            });
                        }
                    }
                }
            });
        });
        $('.add-user').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('Users.create') }}',
                method: "post",
                data: $('.add-user').serialize(),
                success: function (response) {
                    response = $.parseJSON(response);
                    console.log(response);
                    if (response.status == 'success') {
                        $('#add-modal').modal('hide');
                        Swal.fire({
                            title: "Saved!",
                            text: response.msg,
                            type: response.status,
                            confirmButtonClass: "btn btn-confirm mt-2"
                        });
                    } else {
                        if (response.errors.length != 0) {
                            $('.invalid-feedback').remove();
                            $('#add-modal').find('.modal-body').find('.is-invalid').removeClass('is-invalid');
                            $.each(response.errors, function (key, value) {
                                if (!$('#User-' + key).next('.invalid-feedback').length) {
                                    $('#add-modal').find('.modal-body').find('#User-' + key).after('<div class="invalid-feedback" style="display: block;">' + value + '</div>');
                                    $('#add-modal').find('.modal-body').find('#User-' + key).addClass('is-invalid');
                                }
                            });
                        } else {
                            Swal.fire({
                                type: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                                confirmButtonClass: "btn btn-confirm mt-2",
                                footer: '<a href="{{route('help')}}">Why do I have this issue?</a>'
                            });
                        }
                    }
                }
            });
        });
    </script>
    <script src="{{asset('admin/js/pages/bootstrap-tables.init.js')}}"></script>
@endsection