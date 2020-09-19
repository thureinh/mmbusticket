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
    <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Company</a></li>
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
            <h3 class="h4">Create Company Form</h3>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-center mb-3">
              <img src="{{ asset('static/images/default-placeholder-200x200.png') }}" alt="" width="200px" height="200px" id="company_image" class="img-thumbnail">
            </div>
            <form class="form-horizontal" action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row border-top border-bottom p-4">
                <div class="col-md-6">

                  <h2 class="text-center mb-4">Company Information</h2>
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
                    <label class="col-sm-3 form-control-label">Company Name</label>
                    <div class="col-sm-9">
                      <input type="text" name="company_name" value="{{ old('company_name') }}" class="form-control @error('company_name') is-invalid @enderror"><small class="help-block-none">Write location name in Myanmar</small>
                      @error('company_name')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                  </div>

                </div>
                <div class="col-md-6">

                  <h2 class="text-center mb-4">Register Manager</h2>
                    <div class="form-group row">
                      <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                      <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                      <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                      <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                      <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                      </div>
                    </div>

                </div>
              </div>

              <div class="form-group row mt-3">
                <div class="col-sm-4 offset-sm-3">
                  <a href="{{ route('locations.index') }}" class="btn btn-secondary btn-lg">Back</a>
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
<script type="text/javascript">
  $(document).ready(function() {
    $("#fileInput").change(function() {
      readURL(this);
    });

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#company_image').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#fileInput").change(function() {
      readURL(this);
    });
  })
</script>
@endsection