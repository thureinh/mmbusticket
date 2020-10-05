<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from demo.harnishdesign.net/html/koice/index-invoice-bus.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 03 Oct 2020 18:39:45 GMT -->
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bus Booking Invoice - Koice</title>
<meta name="author" content="harnishdesign.net">

<!-- Web Fonts
======================= -->

<!-- Stylesheet
======================= -->
</head>
<body>
<!-- Container -->
<div class="container-fluid invoice-container"> 
  
  <!-- Header -->
  <header>
    <div class="row align-items-center">
        <div class="col-sm-7 text-center text-sm-left mb-3 mb-sm-0">
          <a href="{{route('home')}}" class="navbar-brand" style="font-family: 'Cinzel Decorative', cursive; font-weight: bold; font-size: 20px; color:  #e74c3c ;"><img id="logo" src="{{$message->embed(public_path() . '/mm-bus-ticket/image/logo1.jfif')}}" title="Koice" alt="Koice" /> Online MM Ticket</a>
        </div>
    </div>
    <div class="row">
      <div class="offset-sm-7 col-sm-5 text-center text-sm-right mb-0">
        <h4 class="mb-0">Invoice</h4>
        <p class="mb-0">Invoice Number - {{rand(111111, 999999)}}</p>
      </div>
    </div>
    <hr class="my-2">
  </header>
  
  <!-- Main Content -->
  <main>
    <div class="row">
      <img src="{!! $message->embedData(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(200)->generate($booking->code), 'QrCode.png', 'image/png') !!}" class="rounded mx-auto my-3 d-block" alt="...">
    </div>
    <div class="row">
      <div class="col-sm-6 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">@lang('mail.route')</span><br>
        <span class="font-weight-500 text-3">
        	@foreach($itinerary->locations->sortBy(function($location){return $location->pivot->sequence_number;})->all() as $key => $location)
        		{{$location->name}}@if($key !== count($itinerary->locations) - 1)-@endif
        	@endforeach
        </span>
      </div>
      <div class="col-sm-6"> <span class="text-black-50 text-uppercase">@lang('mail.doj')</span><br>
          <span class="font-weight-500 text-3">{{\Carbon\Carbon::parse($itinerary->departure)->toFormattedDateString()}}</span>
      </div>
    </div>
    <hr class="my-4">
    <div class="row">
      <div class="col-sm-5 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">@lang('mail.departure')</span><br>
        <span class="font-weight-500 text-3">{{\Carbon\Carbon::parse($itinerary->departure)->format(' h:i A')}}</span>
      </div>
      <div class="col-sm-7"> <span class="text-black-50 text-uppercase">@lang('mail.ticketid')</span><br>
        <span class="font-weight-500 text-3">{{$booking->code}}</span> 
      </div>
    </div>
    <hr class="my-4">
    <div class="row">
      <div class="col-sm-4 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">@lang('mail.passenger')</span><br>
        <span class="font-weight-500 text-3">{{$booking->customerinfo->name}}</span> 
      </div>
      <div class="col-sm-4 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">@lang('mail.seat')</span><br>
        <span class="font-weight-500 text-3">
          @foreach($seats as $key => $seat){{$seat}}@if($key !== count($seats) - 1),@endif @endforeach
        </span> 
      </div>
      <div class="col-sm-3"> <span class="text-black-50 text-uppercase">Ticket PNR</span><br>
        <span class="font-weight-500 text-3">{{rand(111111, 999999)}}-{{rand(111111, 999999)}}</span> 
      </div>
    </div>
    <hr class="my-4">
    <div class="row">
      <div class="col-sm-4 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">@lang('mail.travel')</span><br>
        <span class="font-weight-500 text-3">{{$itinerary->seats->first()->bus->company->name}}</span> </div>
      <div class="col-sm-4 mb-3 mb-sm-0"> <span class="text-black-50 text-uppercase">@lang('mail.bustype')</span><br>
        <span class="font-weight-500 text-3">{{$itinerary->seats->first()->bus->bustype->name}}</span> </div>
    </div>
    <!-- Total Fare -->
    <p class="bg-light-4 p-3 text-right font-weight-500 text-4 rounded my-4">@lang('mail.totalfare'): <span class="pl-2">{{$booking->totalprice}}&nbsp;MMK</span> </p>
    <!-- Notice -->
    <p class="text-center text-black-50">**Always Carry ticket print out and your ID proof while traveling.</p>
  </main>
  
  <!-- Footer -->
  <footer class="text-center">
  <hr class="my-4">
  <p><strong>Koice Inc.</strong><br>
    4th Floor, Plot No.22, Above Public Park, 145 Murphy Canyon Rd,<br>
    Suite 100-18, San Diego CA 2028. </p>
  <hr>
  <!-- Note -->
  <p class="text-1 text-muted"><strong>NOTE :</strong> This is computer generated receipt and does not require physical signature.</p>
  <!-- Button -->
  <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a> <a href="#" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-download"></i> Download</a> </div>
  </footer>
</div>
<!-- Back to My Account Link -->
</body>

<!-- Mirrored from demo.harnishdesign.net/html/koice/index-invoice-bus.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 03 Oct 2020 18:39:50 GMT -->
</html>