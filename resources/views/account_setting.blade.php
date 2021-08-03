@extends('layouts/layoutMaster')

@section('title', 'Account Setting')

@section('vendor-style')
<!-- vendor css files -->

@endsection

@section('page-style')
{{-- Page Css files --}}

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Account Setting</h4>
                <form method="POST" action="{{ route('changepassword') }}">
                    @csrf
                    <h5>Change Password</h5>
                    <div class="form-group">
                        <label class="form-label" for="password">{{ __('Password') }}</label>
                        <input id="password" type="password"
                            class="form-control form-control-lg @error('password') is-invalid @enderror" name="password"
                            placeholder="Enter your passcode" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="confirmpassword">{{ __('Password') }}</label>
                        <input id="confirmpassword" type="password"
                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                            name="password_confirmation" placeholder="Enter your passcode" required
                            autocomplete="current-password">
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary btn-block">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('vendor-script')

@endsection
@section('page-script')

@endsection