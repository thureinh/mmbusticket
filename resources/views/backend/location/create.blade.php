@extends('layouts.backendtemplate')
@section('title', 'create')
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
      <li class="breadcrumb-item"><a href="{{ route('locations.index') }}">Location</a></li>
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
              <h3 class="h4">Create Location Form</h3>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-center mb-3">
                <img src="{{ asset('static/images/default-placeholder-200x200.png') }}" alt="" width="200px" height="200px" id="location_image" class="img-thumbnail">
              </div>
              <form class="form-horizontal" action="{{ route('locations.store') }}" method="POST" enctype="multipart/form-data">
              	@csrf
              	<div class="form-group row">
                  <label for="fileInput" class="col-sm-3 form-control-label">File input</label>
                  <div class="col-sm-9">
                    <input id="fileInput" name="image" type="file" class="form-control-file @error('image') is-invalid @enderror">
                    @error('image')
                    	<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">Location Name [English&nbsp;<img src="{{asset('admin_template/img/flag_icons/united-kingdom.svg')}}" alt="" width="32" height="32" title="Bootstrap">]</label>
                  <div class="col-sm-9">
                    <input type="text" name="location_name_eng" class="form-control @error('location_name_eng') is-invalid @enderror"><small class="help-block-none">Write location name in English</small>
                    @error('location_name_eng')
                    	<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">Location Name [Myanmar&nbsp;<img src="{{asset('admin_template/img/flag_icons/myanmar.svg')}}" alt="" width="32" height="32" title="Bootstrap">]</label>
                  <div class="col-sm-9">
                    <input type="text" name="location_name_mm" class="form-control @error('location_name_mm') is-invalid @enderror"><small class="help-block-none">Write location name in Myanmar</small>
                    @error('location_name_mm')
                    	<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                    @enderror
                  </div>
                </div>
                <div class="line"></div>
                <div class="form-group row">
                  <div class="col-sm-4 offset-sm-3">
                    <a href="{{ route('locations.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Add Location</button>
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
<script type="text/javascript">
  $(document).ready(function(){
    $("#fileInput").change(function(){
      readURL(this);
    });
    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#location_image').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
    }
    $("#fileInput").change(function(){
        readURL(this);
    });
  })
</script>
@endsection