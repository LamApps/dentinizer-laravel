@extends('layouts/fullLayoutMaster')

@section('title', 'Landing Page')

@section('page-style')
{{-- Page Css files --}}
<!-- <link rel="stylesheet" href="{{ asset('new-assets/app-assets/css/pages/page-auth.css') }}"> -->
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/css/pages/page-misc.css') }}">
@endsection

@php
$defaultLogos=\App\Library\Helpers\Helper::getDefaultLogos();
$show_logo_in_signin_page=config('global.show_logo_in_signin_page');
$site_logo=config('global.site_logo');
$logo=$defaultLogos['logo'];
if(isset($site_logo) && !empty($site_logo)){
$logo=$site_logo;
}
@endphp

@section('content')

<div class="misc-wrapper">
    <a class="brand-logo" href="javascript:void(0);">
        <img style="max-height:99px;" src="{{asset($logo)}}" alt="logo">
        <!-- <h2 class="brand-text text-primary ml-1">Vuexy</h2> -->
    </a>
    <div class="misc-inner p-2 p-sm-3">
        <div class="w-100 text-center">
            <h2 class="mb-1">Welcome to dentinizer App</h2>
            <p class="mb-3">Please add clinic to login</p>
            <form class="form-inline justify-content-center row m-0 mb-2" id="FORM_SEARCH">
                <input class="form-control col-12 col-md-5 mb-1 mr-md-2" name="subdomain" type="text" placeholder="clinic" required/>
                <button class="btn btn-outline-primary mb-1 btn-sm-block" type="submit">Search <span id="SPAN_SEARCH"></span></button>
            </form>

            <p><span id="alert_result_message"></span> <a href="/login" style="display:none;" id="btn_hidden_login">Login</a></p>
            

            <p class="text-center mt-2">
                <span>Already have an account?</span>
                @if (Route::has('login'))
                <a href="{{ route('login') }}">
                    <span>Sign in instead</span>
                </a>
                @endif
            </p>
            <p class="text-center mt-2">
                <span>New on our platform?</span>
                @if (Route::has('register'))
                <a href="{{ route('register') }}">
                    <span>Create an account</span>
                </a>
                @endif
            </p>

        </div>
    </div>
</div>



@endsection

@section('page-script')
<!-- Vendor js files -->
<script src="{{ asset('new-assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<script>
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
$("#FORM_SEARCH").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SEARCH").addClass("spinner-border spinner-border-sm");
        var formData = $(form).serializeArray(); // convert form to array
        $.ajax({
            type: "POST",
            url: "/search/subdomain",
            data: formData,
            dataType: "JSON",
            success: function(result) {
                $("#SPAN_SEARCH").removeClass("spinner-border spinner-border-sm");
                //console.log(result.subdomain);
                
                if(result.success){
                    $("#alert_result_message").html(result.msg+' : '+result.subdomain);
                    $("#btn_hidden_login").show();
                    $("#alert_result_message").removeClass('text-danger');
                    $("#alert_result_message").addClass('text-success');
                }else{
                    $("#alert_result_message").html(result.msg);
                    $("#btn_hidden_login").hide();
                    $("#alert_result_message").removeClass('text-success');
                    $("#alert_result_message").addClass('text-danger');
                }
                
                $("#btn_hidden_login").attr("href", result.subdomain);
            },
            error: function(error) {},
            complete: function(resultat, statut) {
                
            },
        });
        return false;
    },
});
function goToSubDomain(){
    $("#btn_hidden_login").click();
    console.log('goToSubDomain');
}
</script>
@endsection