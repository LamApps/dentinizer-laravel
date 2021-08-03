@extends('layouts.default')

@section('content')
<div class="text-center">
    <a href="#" class="login-logo text-center">
        <img class="logo-dark logo-img logo-img-lg" src="{{ asset('/images/logo-dark.png') }}" style="width: 250px;" alt="logo-dark">
    </a>
</div>
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="row justify-content-md-center">
        <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12">
            <div class="login-screen" style="margin: 20px auto;">
                <div class="login-box">
                    <a href="#" class="login-logo mb-2">
                        {{ __('Reset Password') }}
                    </a>
                    <div class="form-group row">
                        <label for="email" class="col-md-12 col-form-label">{{ __('E-Mail Address') }}</label>
                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection