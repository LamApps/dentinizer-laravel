@php
$defaultLogos=\App\Library\Helpers\Helper::getDefaultLogos();
$app_title=config('global.app_title');
$site_favicon=config('global.favicon');
$favicon=$defaultLogos['favicon'];
if(isset($site_favicon) && !empty($site_favicon)){
$favicon=$site_favicon;
}
$lang='en';
if(session()->has('locale')){
    $lang=session()->get('locale');
}
$direction=($lang=='ar')?'rtl':'ltr';
@endphp
<!DOCTYPE html>

<html class="loading" lang="@if(session()->has('locale')){{session()->get('locale')}}@else 'en' @endif" data-textdirection="{{ $direction }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{$app_title}}</title>
    <link rel="icon" type="image/png" href="{{asset($favicon)}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    {{-- Include core + vendor Styles --}}
    @include('panels/styles')
</head>



<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="blank-page">

    {{-- Include Navbar --}}
    @include('panels.lang-navbar')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-wrapper">
            <div class="content-body">

                {{-- Include Startkit Content --}}
                @yield('content')

            </div>
        </div>
    </div>
    <!-- End: Content-->

    {{-- include default scripts --}}
    @include('panels/scripts')

    <script type="text/javascript">
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })

    $(window).on('load', function () {
        var language = $('html')[0].lang;
        if (language !== null) {
        // get the selected flag class
        var selectedLang = $('.dropdown-language')
            .find('a[data-language=' + language + ']')
            .text();
        var selectedFlag = $('.dropdown-language')
            .find('a[data-language=' + language + '] .flag-icon')
            .attr('class');
        // set the class in button
        $('#dropdown-flag .selected-language').text(selectedLang);
        $('#dropdown-flag .flag-icon').removeClass().addClass(selectedFlag);
        }
    });
    </script>
</body>

</html>