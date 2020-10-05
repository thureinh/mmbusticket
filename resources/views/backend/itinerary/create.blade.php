@extends('layouts.backendtemplate')
@section('title', 'create')
@section('stylesheet')
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2-bootstrap4.css')}}">
@endsection
@section('content')
<!-- Page Header-->
<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Forms</h2>
  </div>
</header>
<!-- Breadcrumb-->
<div class="breadcrumb-holder container-fluid">
  <ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('itineraries.index') }}">Itinerary</a></li>
    <li class="breadcrumb-item active">Create</li>
  </ul>
</div>
<!-- Forms Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row" id="app">
      <!-- Form Elements -->
      <div class="col-lg-12">
        <itinerary-create :buses='@json($buses)' :locations='@json($locations)' :csrf='@json(csrf_token())' :url='@json(route("itineraries.store"))' :errors='@json($errors->all())' :back_url='@json(route("itineraries.index"))'></itinerary-create>
      </div>
    </div>
  </div>
</section>
<!-- Page Footer-->
<footer class="main-footer">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <p>Your company &copy; 2017-2020</p>
      </div>
      <div class="col-sm-6 text-right">
        <p>Design by <a href="https://bootstrapious.com/p/admin-template" class="external">Bootstrapious</a></p>
        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
      </div>
    </div>
  </div>
</footer>
@endsection
@section('javascript')
  <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
@endsection