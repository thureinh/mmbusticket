@extends('layouts.backendtemplate')
@section('title', 'create')
@section('stylesheet')
  <link href="{{asset('plugins/jQuery.filer/css/jquery.filer.css')}}" type="text/css" rel="stylesheet" />
  <link href="{{asset('plugins/jQuery.filer/css/themes/jquery.filer-dragdropbox-theme.css')}}" type="text/css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="{{asset('plugins/toastr/toastr.min.css')}}">
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
    <li class="breadcrumb-item"><a href="{{ route('buses.index') }}">Bus</a></li>
    <li class="breadcrumb-item active">Create</li>
  </ul>
</div>
<!-- Forms Section-->
<section class="forms">
  <div class="container-fluid">
    <div class="row">
      <!-- Form Elements -->
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h3 class="h4">Create Bus Form</h3>
          </div>
          <div class="card-body">

            <form class="form-horizontal" action="{{ route('buses.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="form-group col-4">
                  <label class="form-control-label">License Plate Number</label>
                    <input type="text" name="license" class="form-control mb-3 @error('license') is-invalid @enderror" value="{{ old('license') }}">
                    @error('license')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                    @enderror
                </div>
                <div class="form-group col-4">
                  <label class="form-control-label">Company</label>
                    <select name="company" class="form-control mb-3 @error('company') is-invalid @enderror">
                      <option value>Chosse a Company</option>
                      @foreach($companies as $company)
                        <option value="{{$company->id}}" @if($company->id == old('company')){{'selected'}}@endif>
                          {{$company->name}}
                        </option>
                      @endforeach
                    </select>
                    @error('company')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                    @enderror
                </div>
                <div class="form-group col-4">
                  <label class="form-control-label">Bus Type</label>
                    <select name="bustype" class="form-control mb-3 @error('bustype') is-invalid @enderror">
                      <option value>Choose a Bus Type</option>
                      @foreach($bustypes as $bustype)
                        <option value="{{$bustype->id}}" @if($bustype->id == old('bustype')){{'selected'}}@endif>
                          English: {{$bustype->translations['name']['en']}} | 
                          Myanmar: {{$bustype->translations['name']['mm']}}
                        </option>
                      @endforeach
                    </select>
                    @error('bustype')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                    @enderror
                </div>
              </div>
              <div class="line"></div>
              @error('images')
                <div class="alert alert-danger col-4" role="alert">
                  {{$message}}
                </div>
              @enderror
              <div class="form-group">
                <label for="filer_input" class="form-control-label">File input</label>
                  <input type="file" class="@error('images') is-invalid @enderror" name="images[]" id="filer_input" multiple="multiple">
              </div>
              <div class="form-group row mt-3">
                <div class="col-sm-4 offset-sm-3">
                  <a href="{{ route('buses.index') }}" class="btn btn-secondary btn-lg">Back</a>
                  <button type="submit" class="btn btn-primary btn-lg">Add Company</button>
                </div>
              </div>
            </form>
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
 <script src="{{asset('plugins/jQuery.filer/js/jquery.filer.min.js')}}"></script> 
 <script type="text/javascript" src="{{ asset('admin_template/js/sweetalert2.all.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
 <script src="{{asset('admin_template/js/filer_custom.js')}}"></script>
@endsection