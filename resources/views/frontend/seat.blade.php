@extends('layouts.frontendtemplate')
@section('content')
<div class="container booking" id="app">
	<seat-component 
		:seats='@json($itinerary->seats->map(function($seat){$seat['status']=$seat->pivot->status;return $seat;}))'
		:company='@json($itinerary->seats->first()->bus->company)'
		:itinerary='@json($itinerary->toArray())'
		:locations='@json($itinerary->locations->map(function($location){$location->location_name=$location->translations['name'][session('lang','en')];return $location;})->sortBy(function($location){return $location->pivot->sequence_number;}))'>
	</seat-component>
</div>
@endsection
@push('scripts')
	<script src="{{asset('js/app.js')}}"></script>
@endpush