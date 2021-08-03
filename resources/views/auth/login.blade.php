@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/css/pages/page-auth.css') }}">
@endsection

@section('content')

@php
$lang='en';
if(session()->has('locale')){
    $lang=session()->get('locale');
}
@endphp

<div class="auth-wrapper auth-v1 px-2">
  <div class="auth-inner py-2">
    <!-- Login v1 -->
    <div class="card mb-0">
      <div class="card-body">
        @php
        $defaultLogos=\App\Library\Helpers\Helper::getDefaultLogos();
        $show_logo_in_signin_page=config('global.show_logo_in_signin_page');
        if($show_logo_in_signin_page=='yes'){
          $site_logo=config('global.site_logo');
          $logo=$defaultLogos['logo'];
          if(isset($site_logo) && !empty($site_logo)){
              $logo=$site_logo;
          }
        }
        @endphp

        @if($show_logo_in_signin_page=='yes')
        <a href="javascript:void(0);" class="brand-logo">
         <img style="max-height:99px;" src="{{asset($logo)}}" alt="logo">
        </a>
        @endif
        <!-- <h4 class="card-title mb-1">Welcome to Vuexy! 👋</h4>
        <p class="card-text mb-2">Please sign-in to your account and start the adventure</p> -->

        @if(session()->has('error'))
          <div class="alert alert-danger"><div class="alert-body">{{ session()->get('error') }}</div></div>
        @endif

        <form id="LOGIN_FORM" class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
          @csrf
          {!!  GoogleReCaptchaV3::renderField('login_ajax_id','login_ajax_action') !!}
          <div class="form-group">
            <label for="login-username" class="form-label">{{ __('locale.username') }}</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="{{ __('locale.username') }}" aria-describedby="login-username" tabindex="1" autofocus value="{{ old('username') }}" />
            @error('username')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="form-group">
            <div class="d-flex justify-content-between">
              <label for="login-password">{{ __('locale.password') }}</label>
              @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}">
                <small>{{ __('locale.forgot_password') }}</small>
              </a>
              @endif
            </div>
            <div class="input-group input-group-merge form-password-toggle">
              <input type="password" class="form-control form-control-merge" id="login-password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />
              <div class="input-group-append">
                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" id="remember-me" name="remember-me" tabindex="3" {{ old('remember-me') ? 'checked' : '' }} />
              <label class="custom-control-label" for="remember-me"> {{ __('locale.remember_me') }} </label>
            </div>
          </div>
          <button type="submit" id="SUBMIT_LOGIN_FORM" class="btn btn-primary btn-block" tabindex="4">{{ __('locale.sign_in') }} </button>
        </form>

        <p class="text-center mt-2">
          <span>{{ __('locale.new_on_our_platform') }}</span>
          @if (Route::has('register'))
          <a href="{{ route('register') }}">
            <span>{{ __('locale.create_an_account') }}</span>
          </a>
          @endif
        </p>

        <!-- <div class="divider my-2">
          <div class="divider-text">or</div>
        </div>

        <div class="auth-footer-btn d-flex justify-content-center">
          <a href="javascript:void(0)" class="btn btn-facebook">
            <i data-feather="facebook"></i>
          </a>
          <a href="javascript:void(0)" class="btn btn-twitter white">
            <i data-feather="twitter"></i>
          </a>
          <a href="javascript:void(0)" class="btn btn-google">
            <i data-feather="mail"></i>
          </a>
          <a href="javascript:void(0)" class="btn btn-github">
            <i data-feather="github"></i>
          </a>
        </div> -->

      </div>
    </div>
    <!-- /Login v1 -->
  </div>
</div>
@endsection

@section('page-script')
{!!  GoogleReCaptchaV3::init() !!}
@endsection
