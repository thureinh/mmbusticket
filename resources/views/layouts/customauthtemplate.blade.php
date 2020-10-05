<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{asset('admin_template/vendor/bootstrap/css/bootstrap.min.css')}}">
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
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          @yield('content')
        </div>
      </div>
      <div class="copyrights text-center">
        <p>Design by <a href="https://bootstrapious.com/p/admin-template" class="external">Bootstrapious</a>
          <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
        </p>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('admin_template/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admin_template/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admin_template/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin_template/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admin_template/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admin_template/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <!-- Main File-->
    <script src="{{asset('admin_template/js/front.js')}}"></script>
  </body>
</html>