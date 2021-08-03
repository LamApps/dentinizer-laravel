@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
<!-- vendor css files -->

@endsection

@section('page-style')
{{-- Page Css files --}}

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-0">Dashboard</h4>
            </div>
        </div>
    </div>
</div>

<!-- Stats Vertical Card -->
<div class="row">
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center">
            <div class="card-body">
                <div class="avatar bg-light-info p-50 mb-1">
                    <div class="avatar-content">
                        <i data-feather="calendar" class="font-medium-5"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder">{{count($appointments)}}</h2>
                <p class="card-text">Appointments</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center">
            <div class="card-body" onClick="window.location.href = 'patient'" style="cursor: url(hand.cur), pointer">
                <div class="avatar bg-light-warning p-50 mb-1">
                    <div class="avatar-content">
                        <i data-feather="user-plus" class="font-medium-5"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder">{{count($patients)}}</h2>
                <p class="card-text">New Patients</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center">
            <div class="card-body">
                <div class="avatar bg-light-danger p-50 mb-1">
                    <div class="avatar-content">
                        <i data-feather="thermometer" class="font-medium-5"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder">{{count($doctors)}}</h2>
                <p class="card-text">Doctors</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center">
            <div class="card-body">
                <div class="avatar bg-light-primary p-50 mb-1">
                    <div class="avatar-content">
                        <i data-feather="users" class="font-medium-5"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder">{{count($users)}}</h2>
                <p class="card-text">Users</p>
            </div>
        </div>
    </div>
</div>
<!--/ Stats Vertical Card -->


<!-- <div class="row gutters">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
        <div class="hospital-tiles primary">
            <img src="{{ asset('assets/images/hospital/appointment.svg') }}" alt="Appointments" />
            <p>Appointments</p>
            <h2>{{count($appointments)}}</h2>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
        <div class="hospital-tiles blue" style="cursor: url(hand.cur), pointer"
            onClick="window.location.href = 'patient'">
            <img src="{{ asset('assets/images/hospital/patient.svg') }}" alt="Patients" />
            <p>New Patients</p>
            <h2>{{count($patients)}}</h2>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
        <div class="hospital-tiles green">
            <img src="{{ asset('assets/images/hospital/doctor.svg') }}" alt="Doctors" />
            <p>Doctors</p>
            <h2>{{count($doctors)}}</h2>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
        <div class="hospital-tiles secondary">
            <img src="{{ asset('assets/images/hospital/staff.svg') }}" alt="Staff" />
            <p>Users</p>
            <h2>{{count($users)}}</h2>
        </div>
    </div>
</div> -->


<!-- Row start -->
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Clinic target</div>
            </div>
            <div class="card-body">
                <div class="line-chart" id="filledLineChart" style="min-height:350px"></div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('vendor-script')
<script src="{{ asset('assets/plugins/apex/apexcharts.min.js') }}"></script>
@endsection
@section('page-script')
<script>
$(document).ready(function() {
    var series = {
        "monthDataSeries1": {
            "prices": [110, 80, 125, 65, 95, 75, 90, 110, 80, 125, 70, 95],
            "dates": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
        }
    }


    var options = {
        chart: {
            height: 300,
            type: 'area'
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 3,
        },
        series: [{
            name: "",
            data: series.monthDataSeries1.prices
        }],
        grid: {
            row: {
                colors: ['#f4f5fb', '#ffffff'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        labels: series.monthDataSeries1.dates,
        xaxis: {
            type: 'month',
        },
        yaxis: {
            opposite: true
        },
        theme: {
            monochrome: {
                enabled: true,
                color: '#074b9c',
                shadeIntensity: 0.1
            },
        },
        markers: {
            size: 0,
            opacity: 0.2,
            colors: ["#074b9c"],
            strokeColor: "#fff",
            strokeWidth: 2,
            hover: {
                size: 7,
            }
        },
    }

    var chart = new ApexCharts(
        document.querySelector("#filledLineChart"),
        options
    );

    chart.render();
});
</script>
@endsection