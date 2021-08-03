<style>
    .modal .modal-header .close{
        opacity: 1;
    }
    .modal .modal-header .close span{
        padding: 0px 7px;
        background: red;
        opacity: 1;
        color: #fff;
        border-radius: 50%;
    }
    .active-page, .active-page i {
        color:red !important;
    }
</style>
<header class="header">
    <div class="container-fluid">

        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <a href="#" class="logo"><img src="{{ asset('/images/logo-dark.png') }}" alt=""></a>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8">

                <!-- Header actions start -->
                <ul class="header-actions">
                    <li class="dropdown d-none d-sm-block">
                    </li>                    
                    <li class="dropdown">
                        <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span class="avatar"><i class="icon-user"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                            <div class="header-profile-actions">
                                <div class="header-user-profile">
                                    <h5>{{ Auth::user()->name }}</h5>
                                    <p>{{ Auth::user()->username }}</p>
                                </div>
                                <a href="{{ route('account_setting') }}"><i class="icon-settings1"></i> Account Settings</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-log-out1"></i> Sign Out</a>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>


