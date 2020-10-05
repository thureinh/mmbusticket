@extends('layouts.customauthtemplate')
@section('title', 'Register')
@section('content')
<div class="row">
  <!-- Logo & Information Panel-->
  <div class="col-lg-6">
    <div class="info d-flex align-items-center">
      <div class="content">
        <div class="logo">
          <h1>Dashboard</h1>
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
      </div>
    </div>
  </div>
  <!-- Form Panel    -->
  <div class="col-lg-6 bg-white">
    <div class="form d-flex align-items-center">
      <div class="content">
        <form class="form-validate">
          <div class="form-group">
            <input id="register-username" type="text" name="registerUsername" required data-msg="Please enter your username" class="input-material">
            <label for="register-username" class="label-material">User Name</label>
          </div>
          <div class="form-group">
            <input id="register-email" type="email" name="registerEmail" required data-msg="Please enter a valid email address" class="input-material">
            <label for="register-email" class="label-material">Email Address</label>
          </div>
          <div class="form-group">
            <input id="register-password" type="password" name="registerPassword" required data-msg="Please enter your password" class="input-material">
            <label for="register-password" class="label-material">password</label>
          </div>
          <div class="form-group">
            <input id="register-password" type="password" name="password_confirmation" required data-msg="Please enter your password" class="input-material">
            <label for="register-password" class="label-material">password</label>
          </div>
          <div class="form-group terms-conditions">
            <input id="register-agree" name="registerAgree" type="checkbox" required value="1" data-msg="Your agreement is required" class="checkbox-template">
            <label for="register-agree">Agree the terms and policy</label>
          </div>
          <div class="form-group">
            <button id="regidter" type="submit" name="registerSubmit" class="btn btn-primary">Register</button>
          </div>
        </form><small>Already have an account? </small><a href="login.html" class="signup">Login</a>
      </div>
    </div>
  </div>
</div>
@endsection