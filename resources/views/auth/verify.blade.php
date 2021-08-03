@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/css/pages/page-auth.css') }}">
@endsection

@section('content')
<div class="auth-wrapper auth-v1 px-2">
  <div class="auth-inner py-2">
    <!-- Login v1 -->
    <div class="card mb-0">
      <div class="card-body">
        <a href="javascript:void(0);" class="brand-logo">
          <img src="{{asset('new-assets/logo/logo-dark.png')}}" alt="logo dentinizer">
        </a>

        <h4 class="card-title mb-1">Verify Your Email Address! </h4>
        @if (session('resent'))
        <div class="alert alert-success" role="alert">
          {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
        @endif
        <p class="card-text mb-2">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
        <p class="card-text">{{ __('If you did not receive the email') }},

          <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
          </form>
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
