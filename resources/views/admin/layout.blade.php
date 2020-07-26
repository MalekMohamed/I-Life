<?php
/**
 * Created by PhpStorm.
 * User: Strix
 * Date: 8/5/2019
 * Time: 11:51 AM
 */
?>
        <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>iLife - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('admin/favicon.ico')}}">
@yield('customCSS')
<!-- App css -->
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin/css/app.min.css')}}" rel="stylesheet" type="text/css"/>
<style>

</style>
</head>

<body>

<!-- Begin page -->
<div id="wrapper">

    <!-- Topbar Start -->
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown"
                   href="#" role="button" aria-haspopup="false" aria-expanded="false">

                    <span class="pro-user-name ml-1">
                                {{\Illuminate\Support\Facades\Auth::user()->firstname}} <i
                                class="mdi mdi-chevron-down"></i>
                            </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock"></i>
                        <span>Lock Screen</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </li>


        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="{{route('home')}}" class="logo text-center">
                        <span class="logo-lg">
                            <span class="logo-lg-text-light">I - </span><span class="logo-lg-text-dark">Life</span>
                        </span>
                <span class="logo-sm">
                           <span class="logo-sm-text-dark">I</span>
                        </span>
            </a>
        </div>
        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>
        </ul>
    </div>
    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">

        <div class="slimscroll-menu">

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>
                    <li>
                        <a href="{{route('Dashboard')}}">
                            <i class="fe-airplay"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('Admin.Users')}}">
                            <i class="fe-users"></i>
                            <span> Users </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('Admin.Orders')}}">
                            <i class="fe-layers"></i>
                            <span> Orders </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('Admin.Products')}}">
                            <i class="fas fa-shopping-basket"></i>
                            <span> Products </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        2015 - 2019 &copy; UBold theme by <a href="#">Coderthemes</a>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right footer-links d-none d-sm-block">
                            <a href="javascript:void(0);">About Us</a>
                            <a href="javascript:void(0);">Help</a>
                            <a href="javascript:void(0);">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- Vendor js -->
<script src="{{asset('admin/js/vendor.min.js')}}"></script>
<script>
    var url = '{{url('')}}';
</script>
@yield('customJS')
<!-- App js -->
<script src="{{asset('admin/js/app.min.js')}}"></script>

</body>
</html>