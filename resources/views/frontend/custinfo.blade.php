@extends('layouts.frontendtemplate')
@section('content')
@if (session('status'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
    	$(function(){
    		Swal.fire(
			   'We sent you email with ticket!',
			   '{{session('status')}}',
			   'success',
			).then(function() {
			    window.location.replace("/");
			});
    	});
    </script>
@endif
<div class="container booking" id="app">
	<booking-component :errors='@json($errors->all())' :csrf='@json(csrf_token())'></booking-component>
</div>
@endsection
@push('scripts')
	<script src="{{asset('js/app.js')}}"></script>
@endpush