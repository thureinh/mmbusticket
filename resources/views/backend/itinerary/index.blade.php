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
    <li class="breadcrumb-item active">Itinerary</li>
  </ul>
</div>
<!-- Forms Section-->
<section class="forms pt-3">
  <div class="container-fluid">
    <button onclick="location.href='{{route('itineraries.create')}}';" type="button" class="btn btn-success btn-lg d-block mt-0 mb-4 ml-auto">
          <i class="fas fa-plus-square"></i>&nbsp;Add Itinerary</button>
    <div class="row">
      <!-- Form Elements -->
     	  <div class="col-lg-12">
          <div class="card">
            <div class="card-header d-flex align-items-center">
              <h3 class="h4">Basic Form</h3>
            </div>
            <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-calendar-alt"></i>&nbsp;Calendar View</a>
                <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-table"></i>&nbsp;Table View</a>
              </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="card-body" id="app">
                  <schedule-component :itineraries='@json($itineraries)'></schedule-component>
                </div>
              </div>
              <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="card-body" id="app">
                  <table id="location_table" class="table table-striped table-bordered" width="100%">
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Route</th>
                        <th class="text-center">Departure</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Foreigner</th>
                        <th class="text-center">Seat</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($itineraries as $itinerary)
                      <tr>
                        <td class="text-center"></td>
                        <td>
                          @foreach($itinerary->locations->sortBy(function($element, $index){return $element->pivot->sequence_number;})->all() as $key => $location)
                            {{$location->name}}@if($key !== $itinerary->locations->count() - 1)-@endif
                          @endforeach
                        </td>
                        <td>{{\Carbon\Carbon::parse($itinerary->departure)->toDayDateTimeString()}}</td>
                        <td>{{$itinerary->price}}&nbsp;MMK</td>
                        <td>{{$itinerary->foreigner_allowrance === 0 ? 'Not Allow' : 'Allow'}}</td>
                        <td>{{$itinerary->seats->count()}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>                
              </div>
            </div>
          </div>
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
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
<script type="text/javascript">
  $(function(){
    let datatable = $('#location_table').DataTable();
    datatable.on( 'order.dt search.dt', function () {
      datatable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
    }).draw();
  })
</script>
@endsection