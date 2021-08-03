@extends('layouts/fullLayoutMaster')

@section('title', 'Register Page')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/css/pages/page-auth.css') }}">
@endsection

@section('content')
<div class="auth-wrapper auth-v1 px-2">
  <div class="auth-inner py-2">
    <!-- Register v1 -->
    <div class="card mb-0">
      <div class="card-body">
        @php
        $defaultLogos=\App\Library\Helpers\Helper::getDefaultLogos();
        $show_logo_in_signup_page=config('global.show_logo_in_signup_page');
        if($show_logo_in_signup_page=='yes'){
          $site_logo=config('global.site_logo');
          $logo=$defaultLogos['logo'];
          if(isset($site_logo) && !empty($site_logo)){
              $logo=$site_logo;
          }
        }
        @endphp

        @if($show_logo_in_signup_page=='yes')
        <a href="javascript:void(0);" class="brand-logo">
         <img style="max-height:99px;" src="{{asset($logo)}}" alt="logo">
        </a>
        @endif

        @if(session()->has('error'))
          <div class="alert alert-danger"><div class="alert-body">{{ session()->get('error') }}</div></div>
        @endif

        @if(session()->has('success'))
          <div class="alert alert-success"><div class="alert-body">{{ session()->get('success') }}</div></div>
        @endif

         <h4 class="card-title mb-1">{{ __('locale.create_an_account') }}</h4>
        <!--<p class="card-text mb-2">Make your app management easy and fun!</p> -->

        <form class="auth-register-form mt-2" method="POST" action="{{ route('custom.register') }}">
          @csrf
          {!!  GoogleReCaptchaV3::renderField('register_id','register_action') !!}
          <div class="form-group">
            <label for="register-name" class="form-label">{{ __('locale.name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="register-name" name="name" placeholder="{{ __('locale.name') }}" aria-describedby="register-name" tabindex="1" autofocus value="{{ old('name') }}" />
            @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="form-group">
            <label for="register-username" class="form-label">{{ __('locale.username') }}</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="register-username" name="username" placeholder="{{ __('locale.username') }}" aria-describedby="register-username" tabindex="1" autofocus value="{{ old('username') }}" />
            @error('username')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          
          <!-- <div class="form-group">
            <label for="register-email" class="form-label">Email</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="register-email" name="email" placeholder="john@example.com" aria-describedby="register-email" tabindex="2" value="{{ old('email') }}" />
            @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div> -->

          <div class="form-group">
            <label for="register-password" class="form-label">{{ __('locale.password') }}</label>

            <div class="input-group input-group-merge form-password-toggle @error('password') is-invalid @enderror">
              <input type="password" class="form-control form-control-merge @error('password') is-invalid @enderror" id="register-password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="register-password" tabindex="3" />
              <div class="input-group-append">
                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
              </div>
            </div>
            @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="form-group">
            <label for="register-password-confirm" class="form-label">{{ __('locale.confirm_password') }}</label>

            <div class="input-group input-group-merge form-password-toggle">
              <input type="password" class="form-control form-control-merge" id="register-password-confirm" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="register-password" tabindex="3" />
              <div class="input-group-append">
                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
              </div>
            </div>
            @error('password_confirmation')
              <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" id="register-privacy-policy" tabindex="4" />
              <label class="custom-control-label" for="register-privacy-policy">
              {{ __('locale.i_agree_to') }} <a href="javascript:void(0);">{{ __('locale.privacy_policy_terms') }}</a>
              </label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block" tabindex="5">{{ __('locale.register') }}</button>
        </form>

        <p class="text-center mt-2">
          <span>{{ __('locale.already_have_an_account') }}</span>
          @if (Route::has('login'))
          <a href="{{ route('login') }}">
            <span>{{ __('locale.sign_in') }}</span>
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
    <!-- /Register v1 -->
  </div>
</div>
@endsection
@section('page-script')
{!!  GoogleReCaptchaV3::init() !!}
@endsection
