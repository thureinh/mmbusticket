<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{asset('admin_template/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{asset('admin_template/vendor/font-awesome/css/font-awesome.min.css')}}">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="{{asset('admin_template/css/fontastic.css')}}">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('admin_template/css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('admin_template/css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('admin_template/img/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_template/DataTables/datatables.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.css')}}">
    @yield('stylesheet')
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="page">
      <!-- Main Navbar-->
      <header class="header">
      @include('subviews.navbar')
      </header>
      <div class="page-content d-flex align-items-stretch"> 
        <!-- Side Navbar -->
        @include('subviews.sidenavbar')
        <div class="content-inner">
          @yield('content')
        </div>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('admin_template/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admin_template/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admin_template/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin_template/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admin_template/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admin_template/DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('admin_template/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    @section('javascript')
      <script src="{{asset('admin_template/js/charts-home.js')}}"></script>
      <script src="{{asset('admin_template/js/front.js')}}"></script>
    @show
    <!-- Main File-->
  </body>
</html>