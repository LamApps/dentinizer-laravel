<nav class="navbar navbar-expand-lg custom-navbar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#royalHospitalsNavbar" aria-controls="royalHospitalsNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i></i>
                <i></i>
                <i></i>
            </span>
        </button>
    <div class="collapse navbar-collapse" id="royalHospitalsNavbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link  {{ (request()->is('reception/home')) ? 'active-page':'' }}" href="{{ route('reception.home') }}">
                    <i class="icon-devices_other nav-icon"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('reception/appointment')) ? 'active-page':'' }}" href="{{ route('reception.appointment') }}">
                    <i class="icon-event_note nav-icon"></i> Appointments
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('reception/patient')) ? 'active-page':'' }}" href="{{ route('reception.patient') }}">
                    <i class="icon-user-x nav-icon"></i> Patients
                </a>
            </li>
         </ul>
    </div>
</nav>