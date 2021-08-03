@extends('layouts.default')

@section('content')
<div class="text-center">
    <a href="#" class="login-logo text-center">
        <img class="logo-dark logo-img logo-img-lg" src="{{ asset('/images/logo-dark.png') }}" style="width: 250px;" alt="logo-dark">
    </a>
</div>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="row justify-content-md-center">
        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
            <div class="login-screen" style="margin: 20px auto;">
                <div class="login-box">
                    <a href="#" class="login-logo">
                        Sign In
                    </a>
                    <div class="form-group">
                        <label class="form-label" for="default-01">{{ __('Username') }}</label>
                        <input id="username" type="text" class="form-control form-control-lg @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Enter your username" required autocomplete="username" autofocus>
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">{{ __('Password') }}</label>
                        <!-- <a href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                            <span class="passcode-icon icon-show icon-eye"></span>
                            <span class="passcode-icon icon-hide icon-eye-off"></span>
                        </a> -->
                        <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" placeholder="Enter your passcode" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label pt-1" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <div class="actions">
                        
                        <button type="submit" class="btn btn-info btn-block">{{ __('Login') }}</button>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
