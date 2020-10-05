@extends('layouts.customauthtemplate')
@section('title', 'Login')
@section('content')
<div class="row">
    <!-- Logo & Information Panel-->
    <div class="col-lg-6">
      <div class="info d-flex align-items-center">
        <div class="content">
          <div class="logo">
            <h1>Dashboard</h1>
          </div>
          <p>It's fine to celebrate success but it is more important to heed the lessons of failure.</p>
        </div>
      </div>
    </div>
    <!-- Form Panel    -->
    <div class="col-lg-6 bg-white">
      <div class="form d-flex align-items-center">
        <div class="content">
          <form method="POST" action="{{ route('login') }}" class="form-validate">
            @csrf
            <div class="form-group">
              <input id="email" type="email" data-msg="Please enter your email" class="input-material @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
              <label for="email" class="label-material">User Name</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
              <input id="password" type="password" data-msg="Please enter your password" class="input-material @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              <label for="password" class="label-material">Password</label>
            </div><button type="submit" id="login" class="btn btn-primary">Login</button>
            <!-- This should be submit button but I replaced it with <a> for demo purposes-->
          </form><a href="{{ route('password.request') }}" class="forgot-pass">Forgot Password?</a>
        </div>
      </div>
    </div>
</div>
@endsection