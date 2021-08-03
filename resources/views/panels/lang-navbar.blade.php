<!-- BEGIN: Header-->
<!-- <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow"> -->
<nav class="header-navbar navbar navbar-expand-lg align-items-center">
    <div class="navbar-container d-flex content">
        <ul class="nav navbar-nav align-items-center ml-auto">
            <!-- Languages -->
            <li class="nav-item dropdown dropdown-language">
            <a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="flag-icon flag-icon-us"></i>
                <span class="selected-language">{{ __('locale.enlang') }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                <a class="dropdown-item" href="{{url('lang/en')}}" data-language="en">
                <i class="flag-icon flag-icon-us"></i> {{ __('locale.enlang') }}
                </a>
                <a class="dropdown-item" href="{{url('lang/ar')}}" data-language="ar">
                <i class="flag-icon flag-icon-sa"></i> {{ __('locale.arlang') }}
                </a>
            </div>
            </li>
            <!-- Languages -->
        </ul>
    </div>
</nav>
<!-- END: Header-->