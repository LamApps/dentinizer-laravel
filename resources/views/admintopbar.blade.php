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
                <a class="nav-link  {{ (request()->is('admin/home')) ? 'active-page':'' }}" href="{{ route('admin.home') }}">
                    <i class="icon-devices_other nav-icon"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('admin/services')) ? 'active-page':'' }}" href="{{ route('admin.services') }}">
                    <i class="icon-settings1 nav-icon"></i> Services
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('admin/users')) ? 'active-page':'' }}" href="{{ route('admin.users') }}">
                    <i class="icon-users nav-icon"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('admin/doctor')) ? 'active-page':'' }}" href="{{ route('admin.doctor') }}">
                    <i class="icon-user-plus nav-icon"></i> Doctors
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('admin/patient')) ? 'active-page':'' }}" href="{{ route('admin.patient') }}">
                    <i class="icon-user-x nav-icon"></i> Patients
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('admin/appointment')) ? 'active-page':'' }}" href="{{ route('admin.appointment') }}">
                    <i class="icon-event_note nav-icon"></i> Appointments
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ (request()->is('admin/officetime')) ? 'active-page':'' }}" href="{{ route('admin.officetime') }}">
                    <i class="icon-clock nav-icon"></i> Office Time
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ (request()->is('admin/clinic')) ? 'active-page':'' }}" href="{{ route('admin.clinic') }}">
                    <i class="icon-target nav-icon"></i> Clinic
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ (request()->is('admin/schedules')) ? 'active-page':'' }}" href="{{ route('admin.schedules') }}">
                    <i class="icon-target nav-icon"></i> Schedule Timings
                </a>
            </li>
        </ul>
    </div>
</nav>