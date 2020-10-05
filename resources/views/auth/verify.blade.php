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
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>
                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form><strong>&nbsp;Or&nbsp;</strong> 
                    <a href="#" class="btn btn-link p-0 m-0 align-baseline" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Verify Later</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection