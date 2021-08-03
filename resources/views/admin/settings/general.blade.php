@extends('layouts/layoutMaster')

@section('title', 'Settings - general')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/css/plugins/forms/form-validation.css') }}">
@endsection

@section('page-style')
{{-- Page Css files --}}

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('locale.general') }}</h4>
                <form id="FORM_GENERAL_SETTINGS">
                    {{ csrf_field() }}

                    <div class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">{{ __('locale.site_logo') }}</label>
                        <div class="col-sm-4">
                            <div class="custom-file b-form-file">
                                <input type="file" class="custom-file-input" id="site_logo" name="site_logo"
                                    style="z-index: -5;"><label data-browse="{{ __('locale.browse') }}" class="custom-file-label"
                                    for="site_logo">
                                    <span class="d-block form-file-text"
                                        style="pointer-events: none;">{{ __('locale.choose_file_or_drop_it_here') }}...</span></label>
                                        <small class="text-info">{{ __('locale.size') }} : 148 x 99 px</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @php
                            $logo=$default_site_logo;
                            if(isset($site_logo) && !empty($site_logo)){
                            $logo=$site_logo;
                            }
                            $site_favicon=$default_favicon;
                            if(isset($favicon) && !empty($favicon)){
                            $site_favicon=$favicon;
                            }
                            @endphp
                            <img style="max-height:60px" src="{{asset($logo)}}" alt="site logo">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">{{ __('locale.sidebar_logo') }}</label>
                        <div class="col-sm-4">
                            <div class="custom-file b-form-file">
                                <input type="file" class="custom-file-input" id="sidebar_logo" name="sidebar_logo"
                                    style="z-index: -5;">
                                    <label data-browse="{{ __('locale.browse') }}" class="custom-file-label"
                                    for="sidebar_logo"><span class="d-block form-file-text"
                                        style="pointer-events: none;">{{ __('locale.choose_file_or_drop_it_here') }}...</span></label>
                                        <small class="text-info">{{ __('locale.size') }} : 122 x 26 px</small>
                            </div>
                            
                        </div>
                        <div class="col-sm-6">
                            @php
                            $sidebarLogo=$default_sidebar_logo;
                            if(isset($sidebar_logo) && !empty($sidebar_logo)){
                            $sidebarLogo=$sidebar_logo;
                            }
                            @endphp
                            <img style="max-height:60px" src="{{asset($sidebarLogo)}}" alt="sidebar logo">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">{{ __('locale.favicon') }}</label>
                        <div class="col-sm-4">
                            <div class="custom-file b-form-file">
                                <input type="file" class="custom-file-input" id="favicon" name="favicon"
                                    style="z-index: -5;"><label data-browse="{{ __('locale.browse') }}" class="custom-file-label"
                                    for="favicon"><span class="d-block form-file-text"
                                        style="pointer-events: none;">{{ __('locale.choose_file_or_drop_it_here') }}...</span></label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <img style="max-height:60px" src="{{asset($site_favicon)}}" alt="site favicon">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">{{ __('locale.show_logo_in_signup_page') }}</label>
                        <div class="col-sm-4">
                            <select class="form-control form-control-sm" name="show_logo_in_signin_page">
                                <option {{($show_logo_in_signin_page=='yes')?'selected':''}} value="yes">{{ __('locale.yes') }}</option>
                                <option {{($show_logo_in_signin_page=='no')?'selected':''}} value="no">{{ __('locale.no') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">{{ __('locale.show_logo_in_signup_page') }}</label>
                        <div class="col-sm-4">
                            <select class="form-control form-control-sm" name="show_logo_in_signup_page">
                                <option {{($show_logo_in_signup_page=='yes')?'selected':''}} value="yes">{{ __('locale.yes') }}</option>
                                <option {{($show_logo_in_signup_page=='no')?'selected':''}} value="no">{{ __('locale.no') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="app_title" class="col-sm-2 col-form-label col-form-label-sm">{{ __('locale.app_title') }}</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" value="{{$app_title}}"
                                id="app_title" name="app_title" placeholder="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4 offset-sm-2">
                            <button type="submit" class="btn btn-primary btn-sm mr-1"><i data-feather="save"></i> {{ __('locale.save') }} <span
                                    id="SPAN_SAVE_SETTINGS"></span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('vendor-script')
<script src="{{ asset('new-assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>
$("#FORM_GENERAL_SETTINGS").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SAVE_SETTINGS").addClass("spinner-border spinner-border-sm");
        var formData = new FormData($(form)[0]);
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: formData,
            url: '/admin/settings/general',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    _showResponseMessage("success", response.msg);
                    $("#SPAN_SAVE_SETTINGS").removeClass("spinner-border spinner-border-sm");
                } else {
                    _showResponseMessage("error", response.msg);
                }
            },
            error: function() {}
        }).done(function(data) {
            location.reload();
        });
        return false;
    },
});
</script>
@endsection