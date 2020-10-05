<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Bus Ticket
	</title>
	<script type="text/javascript" src="{{asset('mm-bus-ticket/bootstrap/js/jquery.min.js')}}"></script>

	<link rel="stylesheet" type="text/css" href="{{asset('mm-bus-ticket/bootstrap/css/bootstrap.min.css')}}">

	<script type="text/javascript" src="{{asset('mm-bus-ticket/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<!-- datpicker -->
	<link rel="stylesheet" type="text/css" href="{{asset('mm-bus-ticket/css/jquery-ui.css')}}">
	<script type="text/javascript" src="{{asset('mm-bus-ticket/js/jquery-1.12.4.js')}}"></script>
	<script type="text/javascript" src="{{asset('mm-bus-ticket/js/jquery-ui.js')}}"></script>


	<link rel="stylesheet" type="text/css" href="{{asset('mm-bus-ticket/fontawesome/css/all.min.css')}}">

	<link rel="stylesheet" type="text/css" href="{{asset('mm-bus-ticket/style.css')}}">

	<link href="https://fonts.googleapis.com/css?family=Cinzel+Decorative&display=swap" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Arapey|Poiret+One&display=swap" rel="stylesheet">

	<script type="text/javascript" src="{{asset('mm-bus-ticket/jq.js')}}"></script>
</head>
<body>
	<!-- nav -->
	<nav class="navbar navbar-expand-lg bg-light navbar-light py-3 shadow fixed-top">
		<div class="container">
			<a href="/" class="navbar-brand" style="font-family: 'Cinzel Decorative', cursive; font-weight: bold; font-size: 30px; color:  #e74c3c ;"><img src="{{asset('mm-bus-ticket/image/logo1.jfif')}}" id="logo" class="mr-4">Online MM Ticket</a>
			<button class="navbar-toggler" data-toggle="collapse" data-target="#myNav">
				<span class="navbar-toggler-icon">	
				</span>
			</button>
			<div id="myNav" class="collapse navbar-collapse">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item"><a class="nav-link" href="">HOME</a></li>
					<li class="nav-item" id="routebtn"><a class="nav-link" href="#">ROUTE</a></li>
					@guest
					<li class="nav-item"><a class="nav-link" href="{{route('login')}}">LOGIN</a></li>
					@endguest
					@auth
					<li class="nav-item"><a class="nav-link" href="{{route('dashboard')}}">Dashboard</a></li>
					@endauth
					<li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				          @if(session('lang', 'en') === 'en')
				          	English
				          @else
				          	Myanmar
				          @endif
				        </a>
				        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
				          	<a class="dropdown-item" href="/lang/en"><img src="{{asset('mm-bus-ticket/flag/united-kingdom.png')}}" width="30" height="30"/>&nbsp;English</a>
				          	<div class="dropdown-divider"></div>
				          	<a class="dropdown-item" href="/lang/mm"><img src="{{asset('mm-bus-ticket/flag/myanmar.png')}}" width="30" height="30"/>&nbsp;Myanmar</a>
				        </div>
				     </li>
				</ul>
			</div>
		</div>
	</nav>
	@yield('content')
	<!-- footer -->
	<footer class="site-footer text-light" style="background-color:#283747;">
		<div class="footer-widgets">
			<div class="container">
				<div class="row">
					<div class="col-12 col-md-6 col-lg-4 mb-md-4 mb-lg-0">
						<div class="foot-contact my-3">
							<h5>Contact</h5>
							<span style="color:#808b96;" ><i class="fa fa-phone mr-2"></i>09-761051414 </span>
							<br>
							<br/>
							<h5>We accept</h5>
							<img src="{{asset('mm-bus-ticket/image/accept.png')}}" alt="">
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-4 my-3" id="information">
						<h5>Information</h5>
						<ul>
							<li><a href="/retrieve">Find/Print Your Ticket </a></li>
							<li><a href='/article/mpu-ecommerce'>How to open MPU Ecommerce </a></li>
							<li><a href='/article/how-to-buy-with-bank-transfer'>How to buy using bank transfer </a></li>
							<li><a href="/terms">Terms & Conditions </a></li>
							<li><a href="/privacy">Privacy Policy </a></li>
						</ul>
					</div>
					<div class="col-12 col-md-6 col-lg-4 my-3" id="btninfo">
						<h5>Online MM Ticket</h5>
						<ul>
							<li><a href="index.html">HOME</a></li>
							<li><a href="#gallery">GALLERY</a></li>
							<li><a href="">CONTACT</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-bar" style="background-color: #17202a; height: 50px;">
			<div class="container text-center" style="padding: auto;">
				<p class="m-0 py-2">
					&copy; 2019 Online MM Ticket
				</p>
			</div>
		</div>
	</footer>
	@stack('scripts')
</body>
</html>