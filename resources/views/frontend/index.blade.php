@extends('layouts.frontendtemplate')
 @section('content')
	<!-- main content -->
	<div class="container booking">
		<div class="row">
			<div class="col-md-8 my-1">
				<div class="card text-center home">
					<div class="card-body shadow">
						<form action="{{route('search')}}" method="POST" name="mainform" class="form">
							@csrf
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="leavingfrom">@lang('lang.leaving_from')</label>
									<select class="form-control" id="leavingfrom" required="required" name="leavingfrom">
										<option value>@lang('lang.choose_start')</option>
										@foreach($locations as $location)
											<option value="{{$location->id}}">
												{{$location->name}}
											</option>
										@endforeach
									</select>
									@error('leavingfrom')
				                      	<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
				                    @enderror
								</div>
								<div class="form-group col-md-6">
									<label for="goingto">@lang('lang.going_to')</label>
									<select class="form-control" id="goingto" required="required" name="goingto">
										<option value>@lang('lang.choose_end')</option>
										@foreach($locations as $location)
											<option value="{{$location->id}}">
												{{$location->name}}
											</option>
										@endforeach
									</select>
									@error('goingto')
				                      	<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
				                    @enderror
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="depaturedate">@lang('lang.departure_date')</label>
									<input type="text" name="date" id="depaturedate" class="form-control" placeholder="Pick a Date" required="required" autocomplete="off"> 
								</div>
								<div class="form-group col-md-6">
									<label for="noseats">@lang('lang.number_of_seats')</label>
									<select class="form-control" id="noseats" required="required" name="noseats">
										<option disabled="disabled">Select</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
									</select>
									@error('noseats')
				                      	<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
				                    @enderror
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="nationality">@lang('lang.nationality')</label>
									<select class="form-control" id="nationality" required="required" name="nationality">
										<option value>Choose</option>
										<option>Myanmar</option>
										<option>Foreigner</option>
									</select> 
									@error('nationality')
				                      	<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
				                    @enderror
								</div>
								<div class="form-group col-md-6">
									<label class="text-light">.</label>
									<button class="btn btn-outline-info form-control" id="submit" type="submit">Search Now</button>	
								</div>
							</div>
						</form>
					</div>	
				</div>
			</div>
			<div class="card col-md-4 my-1 poster shadow">	
				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="4"></li>

					</ol>
					<div class="carousel-inner">
						<div class="carousel-item">
							<img src="{{asset('mm-bus-ticket/image/visa.png')}}" class="d-block w-100" alt="...">
						</div>
						<div class="carousel-item">
							<img src="{{asset('mm-bus-ticket/image/paypal.jfif')}}" class="d-block w-100" alt="...">
						</div>
						<div class="carousel-item">
							<img src="{{asset('mm-bus-ticket/image/wave1.jfif')}}" class="d-block w-100" alt="...">
						</div>
						<div class="carousel-item">
							<img src="{{asset('mm-bus-ticket/image/okdollor.jfif')}}" class="d-block w-100" alt="...">
						</div>
						<div class="carousel-item active">
							<img src="{{asset('mm-bus-ticket/image/cb1.jfif')}}" class="d-block w-100" alt="...">
						</div>
					</div>
					<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only"></span>
					</a>
					<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only"></span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<!-- Services show -->
	<div class="container-fluid service">
		<hr>
		<div class="row">
			<div class="col-md-3 text-center">
				<h1 class="text-info"><i class="fas fa-bus-alt"></i></h1>
				<h4>50+ Bus Operators</h4>
				<p>Choose from 50+ major bus operators covering 200 destinations.</p>
			</div>
			<div class="col-md-3 text-center">
				<h1 class="text-info"><i class="fas fa-stopwatch"></i></h1>
				<h4>Instant Time</h4>
				<p>Book your trip in less than 5 min. Instant confirmation after payment.</p>
			</div>
			<div class="col-md-3 text-center">
				<h1 class="text-info"><i class="fas fa-shield-alt"></i></h1>
				<h4>Secure Payment</h4>
				<p>Pay with VISA, MASTER, MPU, WaveMoney, KBZPay, MAB, and CBPay.</p>
			</div>
			<div class="col-md-3 text-center">
				<h1 class="text-info"><i class="far fa-question-circle"></i></h1>
				<h4>Help</h4>
				Our support center is available 24/7 for your questions and concerns. 
			</div>
		</div>
		<hr>
	</div>	
	<!-- popular routes -->
	<div class="container my-5 text-center" id="route">
		<h4 class="my-3">Popular Routes</h4>
		<hr class="divider mb-5">
		<div class="row">
			<div class="col-md-3">
				<div class="card shadow my-1">
					<div class="card-body" style="padding: 0; margin: 0;">
						<img src="{{asset('mm-bus-ticket/image/mandalay.jfif')}}" class="w-100 h-100">
					</div>
					<div class="card-footer popular">
						<a href="" class="btn">Yangon-Mandalay</a>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card shadow my-1">
					<div class="card-body" style="padding: 0; margin: 0;">
						<img src="{{asset('mm-bus-ticket/image/naypyithaw.jfif')}}" class="w-100 h-100">
					</div>
					<div class="card-footer popular">
						<a href="" class="btn">Yangon-Naypyitaw</a>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card shadow my-1">
					<div class="card-body" style="padding: 0; margin: 0;">
						<img src="{{asset('mm-bus-ticket/image/yangon.jfif')}}" class="w-100 h-100">
					</div>
					<div class="card-footer popular">
						<a href="" class="btn">Mandalay-Yangon</a>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card shadow my-1">
					<div class="card-body" style="padding: 0; margin: 0;">
						<img src="{{asset('mm-bus-ticket/image/b1.jfif')}}" class="w-100 h-100">
					</div>
					<div class="card-footer popular">
						<a href="" class="btn">Mandalay-Bagan</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- gallery -->
	<div class="container text-center my-3" id="gallery">
		<h4>Gallery</h4>
		<hr class="divider">
		<div class="row">
			<div class="col-md-4 my-1">
				<div class="card shadow">
					<img src="{{asset('mm-bus-ticket/image/car1.jpg')}}" class="w-100 h-50">
				</div>
			</div>
			<div class="col-md-4 my-1">
				<div class="card shadow">
					<img src="{{asset('mm-bus-ticket/image/car2.jpg')}}" class="w-100 h-50">
				</div>
			</div>
			<div class="col-md-4 my-1">
				<div class="card shadow">
					<img src="{{asset('mm-bus-ticket/image/car3.jpg')}}" class="w-100 h-50">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 my-1">
				<div class="card shadow">
					<img src="{{asset('mm-bus-ticket/image/car4.jpg')}}" class="w-100 h-50">
				</div>
			</div>
			<div class="col-md-4 my-1">
				<div class="card shadow">
					<img src="{{asset('mm-bus-ticket/image/car5.jpg')}}" class="w-100 h-50">
				</div>
			</div>
			<div class="col-md-4 my-1">
				<div class="card shadow">
					<img src="{{asset('mm-bus-ticket/image/car6.jpg')}}" class="w-100 h-50">
				</div>
			</div>
		</div>
	</div>
@endsection	