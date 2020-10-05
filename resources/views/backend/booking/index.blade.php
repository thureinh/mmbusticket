@extends('layouts.backendtemplate')
@section('title', 'index')
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
      <li class="breadcrumb-item active">Booking</li>
    </ul>
  </div>
  <!-- Forms Section-->
  <div class="container-fluid my-3">
    <div class="row bg-white has-shadow">
      <div class="container-fluid my-3">
        <table id="booking_table" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Buy Date</th>
              <th>Seat</th>
              <th>Itinerary</th>
              <th>Departure</th>
              {{-- <th>Detail</th> --}}
            </tr>
          <tbody>
            @foreach($bookings as $key => $booking)
              <tr>
                <td>{{$key + 1}}</td>
                <td>{{$booking->customerinfo->name}}</td>
                <td>{{\Carbon\Carbon::parse($booking->buy_date)->toFormattedDateString()}}</td>
                <td>
                  @foreach($booking->seats as $key => $seat)
                    {{$seat->seat_number}}
                    @if($key !== count($booking->seats)-1),@endif
                  @endforeach
                </td>
                <td>
                  @foreach($booking->itinerary->locations as $key => $location)
                    {{$location->translations['name']['en']}}({{$location->translations['name']['mm']}})
                    @if($key !== count($booking->itinerary->locations)-1)-@endif
                  @endforeach
                </td>
                <td>
                  {{\Carbon\Carbon::parse($booking->itinerary->departure)->toDayDateTimeString()}}
                </td>
                {{-- <td>
                  <button class="btn btn-info btn-sm btn-block" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-window-restore"></i></button>
                </td> --}}
              </tr>
            @endforeach
          </tbody>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
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

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Booking Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="card mb-3 w-100">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img src="" class="card-img" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
<script type="text/javascript">
  $(document).ready(function(){
    let datatable = $('#booking_table').DataTable();
    datatable.on( 'order.dt search.dt', function () {
      datatable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      });
    }).draw();
  });
</script>
@endsection