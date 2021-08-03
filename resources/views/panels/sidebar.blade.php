@php
$defaultLogos=\App\Library\Helpers\Helper::getDefaultLogos();
$sidebar_logo=\App\Library\Helpers\Helper::getSetting('app','sidebar_logo');
$logo=$defaultLogos['sidebar_logo'];
if(isset($sidebar_logo) && !empty($sidebar_logo)){
    $logo=$sidebar_logo;
}
@endphp
<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href=""><span class="brand-logo">

                <img style="max-width:100px;max-height:26px;" src="{{asset($logo)}}" alt="logo">
                
                </span>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @if(Auth::user())
                @if(Auth::user()->user_type == "admin")
                
                <li class=" nav-item {{ Route::currentRouteName() === 'admin.home' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.home') }}"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">{{ __('locale.dashboard') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'admin.services' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.services') }}"><i data-feather="list"></i><span class="menu-title text-truncate" data-i18n="Services">{{ __('locale.services') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'admin.users' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.users') }}"><i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="Users">{{ __('locale.users') }}</span></a></li>
                <li class=" nav-item "><a class="d-flex align-items-center" href="#"><i data-feather="user-plus"></i><span class="menu-title text-truncate" data-i18n="Doctors">{{ __('locale.doctors') }}</span></a>
                    <ul class="menu-content">
                        <li class="{{ Route::currentRouteName() === 'admin.doctor' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.doctor') }}"><i data-feather="user-plus"></i><span class="menu-item" data-i18n="Doctors">{{ __('locale.doctors') }}</span></a>
                        </li>
                        <li class="{{ Route::currentRouteName() === 'admin.doctor.profile' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.doctor.profile') }}"><i data-feather="user-check"></i><span class="menu-item" data-i18n="Doctors">{{ __('locale.doctor_profile') }}</span></a>
                        </li>
                        <li class="{{ Route::currentRouteName() === 'admin.schedules' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.schedules') }}"><i data-feather="clock"></i><span class="menu-item" data-i18n="Schedule Timings">{{ __('locale.schedule_timings') }}</span></a>
                        </li>
                        <li class="{{ Route::currentRouteName() === 'admin.doctor.questions' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.doctor.questions') }}"><i data-feather="help-circle"></i><span class="menu-item" data-i18n="Schedule Timings">{{ __('locale.questions') }}</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item {{ Route::currentRouteName() === 'admin.patient' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.patient') }}"><i data-feather="user-x"></i><span class="menu-title text-truncate" data-i18n="Patients">{{ __('locale.patients') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'admin.reception' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.reception') }}"><i data-feather="user-x"></i><span class="menu-title text-truncate" data-i18n="Receptions">{{ __('locale.receptions') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'admin.reports' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.reports') }}"><i data-feather="bar-chart-2"></i><span class="menu-title text-truncate" data-i18n="Reports">{{ __('locale.reports') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'admin.appointment' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.appointment') }}"><i data-feather="calendar"></i><span class="menu-title text-truncate" data-i18n="Appointments">{{ __('locale.appointments') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'admin.officetime' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.officetime') }}"><i data-feather="clock"></i><span class="menu-title text-truncate" data-i18n="Office Time">{{ __('locale.office_time') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'admin.clinic' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.clinic') }}"><i data-feather="activity"></i><span class="menu-title text-truncate" data-i18n="Clinic">{{ __('locale.clinic') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'admin.requests' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.requests') }}"><i data-feather="mail"></i><span class="menu-title text-truncate" data-i18n="Requests">{{ __('locale.requests') }}</span></a></li> 
                <li class=" nav-item "><a class="d-flex align-items-center" href="#"><i data-feather="settings"></i><span class="menu-title text-truncate" data-i18n="Settings">{{ __('locale.settings') }}</span></a>
                    <ul class="menu-content">
                        <li class="{{ Route::currentRouteName() === 'admin.settings.general' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.settings.general') }}"><i data-feather="edit"></i><span class="menu-item" data-i18n="General">{{ __('locale.general') }}</span></a>
                        </li>
                        <!-- <li class="{{ Route::currentRouteName() === 'admin.schedules' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.schedules') }}"><i data-feather="clock"></i><span class="menu-item" data-i18n="Schedule Timings">Schedule Timings</span></a>
                        </li> -->
                    </ul>
                </li>

                <li class=" nav-item {{ Route::currentRouteName() === 'admin.logs' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.logs') }}"><i data-feather="archive"></i><span class="menu-title text-truncate" data-i18n="Activities logs">{{ __('locale.logs') }}</span></a></li>   
                <li class=" nav-item {{ Route::currentRouteName() === 'admin.backup' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('admin.backup') }}"><i data-feather="hard-drive"></i><span class="menu-title text-truncate" data-i18n="Backup">{{ __('locale.backup') }}</span></a></li>   

                @elseif(Auth::user()->user_type == "doctor")
                <li class=" nav-item {{ Route::currentRouteName() === 'doctor.home' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('doctor.home') }}"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">{{ __('locale.dashboard') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'doctor.appointment' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('doctor.appointment') }}"><i data-feather="calendar"></i><span class="menu-title text-truncate" data-i18n="Appointments">{{ __('locale.appointments') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'doctor.patients' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('doctor.patients') }}"><i data-feather="user-x"></i><span class="menu-title text-truncate" data-i18n="My patients">{{ __('locale.patients') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'doctor.profile' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('doctor.profile') }}"><i data-feather="user-x"></i><span class="menu-title text-truncate" data-i18n="My Profile">{{ __('locale.my_profile') }}</span></a></li>
                @elseif(Auth::user()->user_type == "nurse")
                <li class=" nav-item {{ Route::currentRouteName() === 'nurse.home' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('nurse.home') }}"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">{{ __('locale.dashboard') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'nurse.appointment' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('nurse.appointment') }}"><i data-feather="calendar"></i><span class="menu-title text-truncate" data-i18n="Appointments">{{ __('locale.appointments') }}</span></a></li>
                @elseif(Auth::user()->user_type == "reception")
                <li class=" nav-item {{ Route::currentRouteName() === 'reception.home' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('reception.home') }}"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboard">{{ __('locale.dashboard') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'reception.appointment' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('reception.appointment') }}"><i data-feather="calendar"></i><span class="menu-title text-truncate" data-i18n="Appointments">{{ __('locale.appointments') }}</span></a></li>
                <li class=" nav-item {{ Route::currentRouteName() === 'reception.patient' ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('reception.patient') }}"><i data-feather="user-x"></i><span class="menu-title text-truncate" data-i18n="Patients">{{ __('locale.patients') }}</span></a></li>
                @endif
            @endif
            <!-- <li class=" nav-item "><a class="d-flex align-items-center" target="_blank" href="/messenger"><i data-feather="message-circle"></i><span class="menu-title text-truncate" data-i18n="Messenger">Messenger</span></a></li> -->
            <li class=" nav-item {{ Route::currentRouteName() === 'notifications' ? 'active' : '' }}"><a class="d-flex align-items-center" href="/notifications/month"><i data-feather="bell"></i><span class="menu-title text-truncate" data-i18n="Notifications">{{ __('locale.notifications') }}</span></a></li>
            <li class=" nav-item "><a class="d-flex align-items-center" target="_blank" href="{{env('CHAT_URL')}}/{{Auth::user()->id}}"><i data-feather="message-circle"></i><span class="menu-title text-truncate" data-i18n="Messenger">{{ __('locale.messenger') }}</span></a></li>
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->