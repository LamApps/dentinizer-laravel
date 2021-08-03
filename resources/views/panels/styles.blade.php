<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/vendors.min.css') }}" />
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/ui/prism.min.css') }}" />
{{-- Vendor Styles --}}
@yield('vendor-style')
{{-- Theme Styles --}}
@php
$lang='en';
if(session()->has('locale')){
    $lang=session()->get('locale');
}
$direction=($lang=='ar')?'rtl':'ltr';
$cssFolder=($lang=='ar')?'css-rtl':'css';
@endphp
<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('new-assets/app-assets/'.$cssFolder.'/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('new-assets/app-assets/'.$cssFolder.'/bootstrap-extended.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('new-assets/app-assets/'.$cssFolder.'/colors.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('new-assets/app-assets/'.$cssFolder.'/components.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('new-assets/app-assets/'.$cssFolder.'/themes/dark-layout.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('new-assets/app-assets/'.$cssFolder.'/themes/bordered-layout.css') }}">

{{-- Page Styles --}}
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/'.$cssFolder.'/core/menu/menu-types/vertical-menu.css') }}" />

{{-- Page Styles --}}
@yield('page-style')

{{-- Custom RTL Styles --}}



@if($direction === 'rtl'))
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/css-rtl/custom-rtl.css') }}" />
@endif

{{-- user custom styles --}}
<link rel="stylesheet" href="{{ asset('new-assets/assets/css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('new-assets/assets/css/style-rtl.css') }}" />
