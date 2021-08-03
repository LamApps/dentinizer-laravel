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
    <link rel="shortcut icon" type="image/png" href="{{asset($favicon)}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    {{-- Include core + vendor Styles --}}
    @include('panels/styles')

</head>

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="">

    {{-- Include Sidebar --}}
    @include('panels.sidebar')

    {{-- Include Navbar --}}
    @include('panels.navbar')

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <!-- BEGIN: Header-->
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>


        <div class="content-wrapper container p-0">

            <!-- <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Layout Boxed</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Layouts</a>
                                    </li>
                                    <li class="breadcrumb-item active">Layout Boxed
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <div class="dropdown">
                            <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    data-feather="grid"></i></button>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                    href="javascript:void(0);"><i class="mr-1" data-feather="check-square"></i><span
                                        class="align-middle">Todo</span></a><a class="dropdown-item"
                                    href="javascript:void(0);"><i class="mr-1" data-feather="message-square"></i><span
                                        class="align-middle">Chat</span></a><a class="dropdown-item"
                                    href="javascript:void(0);"><i class="mr-1" data-feather="mail"></i><span
                                        class="align-middle">Email</span></a><a class="dropdown-item"
                                    href="javascript:void(0);"><i class="mr-1" data-feather="calendar"></i><span
                                        class="align-middle">Calendar</span></a></div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="content-body">
                {{-- Include Page Content --}}
                @yield('content')
            </div>
        </div>

    </div>
    <!-- End: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    {{-- include footer --}}
    @include('panels/footer')

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
    // Page full screen
  $(".nav-link-expand").on("click", function (e) {
      console.log('okkk');
    if (typeof screenfull != "undefined") {
      if (screenfull.isEnabled) {
        screenfull.toggle();
      }
    }
  });
  if (typeof screenfull != "undefined") {
    if (screenfull.isEnabled) {
      $(document).on(screenfull.raw.fullscreenchange, function () {
        if (screenfull.isFullscreen) {
          $(".nav-link-expand")
            .find("i")
            .toggleClass("icon-minimize icon-maximize");
          $("html").addClass("full-screen");
        } else {
          $(".nav-link-expand")
            .find("i")
            .toggleClass("icon-maximize icon-minimize");
          $("html").removeClass("full-screen");
        }
      });
    }
  }

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

// change language according to data-language of dropdown item
$('.dropdown-language .dropdown-item').on('click', function () {
      var $this = $(this);
      $this.siblings('.selected').removeClass('selected');
      $this.addClass('selected');
      var selectedLang = $this.text();
      var selectedFlag = $this.find('.flag-icon').attr('class');
      $('#dropdown-flag .selected-language').text(selectedLang);
      $('#dropdown-flag .flag-icon').removeClass().addClass(selectedFlag);
      var currentLanguage = $this.data('language');
      i18next.changeLanguage(currentLanguage, function (err, t) {
        $('.main-menu, .horizontal-menu-wrapper').localize();
      });
    });

    </script>
</body>

</html>