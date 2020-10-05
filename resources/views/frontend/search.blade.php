@extends('layouts.frontendtemplate')
@section('content')
<!-- main content -->
<div class="container booking">
	<!-- search form -->
	<div class="card my-2 text-left">
		<div class="card-header">
			<h5 style="font-weight: normal;">Search Trip</h5>
		</div>
		<div class="card-body">
			<form action="{{route('search')}}" method="POST" name="mainform" class="form">
				@csrf
				<div class="row">
					<div class="form-group col-12 col-md-3">
						<label for="leavingfrom">@lang('lang.leaving_from')</label>
						<select class="form-control" id="leavingfrom" required="required" name="leavingfrom">
							@foreach($locations as $location)
								<option value="{{$location->id}}" @if($location->id == $pre['leavingfrom']){{'selected'}}@endif>
									{{$location->name}}
								</option>
							@endforeach
						</select>		
					</div>
					<div class="form-group col-12 col-md-3">
						<label for="goingto">@lang('lang.going_to')</label>
							<select class="form-control" id="goingto" required="required" name="goingto">
								@foreach($locations as $location)
									<option value="{{$location->id}}" @if($location->id == $pre['goingto']){{'selected'}}@endif>
										{{$location->name}}
									</option>
								@endforeach
							</select>
					</div>
					<div class="form-group col-6 col-md">
						<label for="depaturedate">@lang('lang.departure_date')</label>
						<input type="text" name="date" value="{{$pre['date']}}" id="depaturedate" class="form-control" placeholder="Pick a Date" required="required">	
					</div>

					<div class="form-group col-6 col-md">
						<label for="noseats">@lang('lang.number_of_seats')</label>
						<select class="form-control" id="noseats" required="required" name="noseats">
							<option value="1" @if($pre['noseats'] == '1'){{'selected'}}@endif>1</option>
							<option value="2" @if($pre['noseats'] == '2'){{'selected'}}@endif>2</option>
							<option value="3" @if($pre['noseats'] == '3'){{'selected'}}@endif>3</option>
							<option value="4" @if($pre['noseats'] == '4'){{'selected'}}@endif>4</option>
							<option value="5" @if($pre['noseats'] == '5'){{'selected'}}@endif>4</option>
							<option value="6" @if($pre['noseats'] == '6'){{'selected'}}@endif>4</option>
						</select>
					</div>
					<div class="form-group col-6 col-md">
						<label for="nationality">@lang('lang.nationality')</label>
						<select class="form-control" id="nationality" required="required" name="nationality">
							<option @if(\Illuminate\Support\Str::lower($pre['nationality']) == 'myanmar'){{'selected'}}@endif>Myanmar</option>
							<option @if(\Illuminate\Support\Str::lower($pre['nationality']) == 'foreigner'){{'selected'}}@endif>Foreigner</option>
						</select>
					</div>
						<div class="form-group col-6 col-md">
						<label class="text-light">.</label>
						<button class="btn btn-outline-info form-control" type="submit" id="submit">SearchNow</button>
					</div>
				</div>		
			</form>
		</div>
	</div>
	<!-- time category -->
	<div class="row mb-2">
		<div class="col-lg-3 col-md-3 col-sm-12 d-none d-md-block">
			<div class="card">
				<div class="card-header">
					<h5>@lang('lang.cartype')</h5>
				</div>
				<div class="card-body">
					<input type="radio" name="radio" id="anytimebtn" value="Anytime" checked="checked"> 
					<label for="anytimebtn">AnyCar</label><br/>
					@foreach($bustypes as $key => $bustype)
						<input type="radio" name="radio" id="anytimebtn-{{$key}}" value="{{$bustype->id}}">
						<label for="anytimebtn-{{$key}}">{{$bustype->name}}</label><br/>
					@endforeach
				</div>
			</div>
		</div>
		<!-- show routes bus -->
		<div class="col-lg-9 col-md-9 col-sm-12">
			@foreach($final_results as $itinerary)
			<div class="card my-1 bustype-wrapper {{\Illuminate\Support\Str::kebab($itinerary->seats->first()->bus->bustype->translations['name']['en'])}}">
				<div class="card-body" id="anytime1">
						<div class="row">
							<div class="col-md-4 col-12 my-3">
								{{\Carbon\Carbon::parse($itinerary->departure)->format('h:i A')}}
								<span>-</span>{{$itinerary->seats->first()->bus->bustype->manufacturer}}<br>
								<p class="my-1">
									@foreach($itinerary->locations->sortBy(function($location){ return $location->pivot->sequence_number;})->values() as $key => $itinerary_location)
										{{$itinerary_location->name}} @if(last($itinerary->locations->sortBy(function($location){ return $location->pivot->sequence_number;})->keys()->toArray()) !== $key) - @endif
									@endforeach
								</p>
								<p><span class="mx-2"></span>{{$itinerary->seats->first()->bus->bustype->name}}</p>
							</div>
							<div class="col-md-4 col-6 text-center my-3">
								<img src="{{asset('storage/' . $itinerary->seats->first()->bus->company->logo)}}" width="100px" height="50px;">
								<p class="my-2">{{$itinerary->seats->first()->bus->company->name}}</p>
							</div>
							<div class="col-md-4 col-6 text-center">
								<p class="text-info" style="font-size:25px;">{{$itinerary->price * $pre['noseats']}}&nbsp;MMK</p>
								<p>{{$pre['noseats']}}&nbsp;seats <span>x</span> {{$itinerary->price}}&nbsp;MMK</p>
								<a href="{{ route('itineraryDetail', ['id' => $itinerary->id]) }}" class="btn btn-info selectseat">Select Seats</a>
							</div>
						</div>
				</div>
			</div>	
			@endforeach		
		</div>
	</div>
</div>
@endsection	
@push('scripts')
<script type="text/javascript">
	$('document').ready(function(){
		$('#anytimebtn').click(function(){
			$('.bustype-wrapper').show()
		})
		@foreach($bustypes as $key => $bustype)
			$('#anytimebtn-{{$key}}').click(function(){
				$('.bustype-wrapper').hide()
				$('.bustype-wrapper.{{\Illuminate\Support\Str::kebab($bustype->translations['name']['en'])}}').show()
			});
		@endforeach
	})
</script>
@endpush