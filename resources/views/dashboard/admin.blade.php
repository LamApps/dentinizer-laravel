@extends('layouts/layoutMaster')

@section('title', 'Admin dashboard')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection

@section('page-style')
{{-- Page Css files --}}

@endsection

@section('content')
@php
$dtNow = Carbon\Carbon::now();
$lang='en';
if(session()->has('locale')){
    $lang=session()->get('locale');
}
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <!-- begin custom range -->
                <div class="row">
                    <div class="col-md-4">
                        <!-- doctors_stats_datatable -->
                        <form id="formFilterStats">
                            <input type="hidden" value="" name="quick_type" id="INPUT_QUICK">
                            <div class="input-group mb-1">
                                <input type="text" class="form-control form-control-sm flatpickr-range"
                                    id="custom-range" name="filter_range" placeholder=""
                                    aria-describedby="button-filter" />
                                <div class="input-group-append" id="button-filter">
                                    <button class="btn btn-outline-primary btn-sm" type="button"
                                        onclick="range_filters()"><i data-feather="search"></i> {{ __('locale.search') }}</button>
                                </div>
                            </div>

                        </form>

                        <div class="spinner-border text-primary d-none" id="SPINNER">
                            <span class="sr-only">Loading...</span>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="btn-group float-right" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                onclick="quick_filters('reset')">{{ __('locale.reset') }}</button>
                            <!-- <button type="button" class="btn btn-outline-primary btn-sm"
                                onclick="quick_filters('today')">Today</button> -->
                            <!-- <button type="button" class="btn btn-outline-primary btn-sm"
                                onclick="quick_filters('this_month')">This month</button> -->
                            <!-- <button type="button" class="btn btn-outline-primary btn-sm"
                                onclick="quick_filters('this_year')">This year</button> -->
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                {{ __('locale.today') }} : {{$dtNow->format('F d')}}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="javascript:void(0);"
                                    onclick="quick_filters('today')">{{ __('locale.today') }}</a>
                                <a class="dropdown-item" href="javascript:void(0);"
                                    onclick="quick_filters('yesterday')">{{ __('locale.yesterday') }}</a>
                                <a class="dropdown-item" href="javascript:void(0);"
                                    onclick="quick_filters('last_7_days')">{{ __('locale.last_7_days') }}</a>
                                <a class="dropdown-item" href="javascript:void(0);"
                                    onclick="quick_filters('last_30_days')">{{ __('locale.last_30_days') }}</a>
                                <a class="dropdown-item" href="javascript:void(0);"
                                    onclick="quick_filters('this_month')">{{ __('locale.this_month') }}</a>
                                <a class="dropdown-item" href="javascript:void(0);"
                                    onclick="quick_filters('last_month')">{{ __('locale.last_month') }}</a>
                                <a class="dropdown-item" href="javascript:void(0);"
                                    onclick="quick_filters('this_year')">{{ __('locale.this_year') }}</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- endcustom range -->

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
                <h2 class="font-weight-bolder" id="appointments">{{count($appointments)}}</h2>
                <p class="card-text">{{ __('locale.appointments') }}</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center">
            <div class="card-body" onClick="window.location.href = 'patient'" style="cursor: pointer;">
                <div class="avatar bg-light-warning p-50 mb-1">
                    <div class="avatar-content">
                        <i data-feather="user-plus" class="font-medium-5"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder" id="patients">{{count($patients)}}</h2>
                <p class="card-text">{{ __('locale.patients') }}</p>
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
                <h2 class="font-weight-bolder" id="doctors">{{count($doctors)}}</h2>
                <p class="card-text">{{ __('locale.doctors') }}</p>
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
                <h2 class="font-weight-bolder" id="invoices"></h2>
                <p class="card-text">{{ __('locale.invoices') }}</p>
            </div>
        </div>
    </div>
</div>
<!--/ Stats Vertical Card -->
<div class="row">
    <!-- Company Table Card -->
    <div class="col-lg-12 col-12">
        <div class="card card-company-table">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="doctors_stats_datatable">
                        <thead>
                            <tr>
                                <th>{{ __('locale.doctor') }}</th>
                                <th>{{ __('locale.income') }}</th>
                                <th>{{ __('locale.refund') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/ Company Table Card -->
</div>

<!-- Row start -->
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{ __('locale.clinic_target') }}</div>
            </div>
            <div class="card-body">
                <div class="line-chart" id="filledLineChart" style="min-height:350px"></div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('vendor-script')
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apex/apexcharts.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>


@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
/* stats */
var dtUrl = '/admin/sdt/doctors/stats';
var doctors_stats_datatable = $('#doctors_stats_datatable');
doctors_stats_datatable.DataTable({
    responsive: true,
    @if($lang=='ar')
    language: {
            url: '/json/datatable/ar.json'
    },
    @endif
    processing: true,
    paging: true,
    ordering: false,
    ajax: {
        url: dtUrl,
        type: 'POST',
        data: {
            pagination: {
                perpage: 50,
            },
        },
    },
    lengthMenu: [5, 10, 25, 50],
    pageLength: 25,
});
var _reload_doctors_stats_datatable = function() {
    $('#doctors_stats_datatable').DataTable().ajax.reload();
}

function quick_filters(type) {
    $('#custom-range').val('');
    $('#INPUT_QUICK').val(type);
    $("#formFilterStats").submit();
}

function range_filters() {
    $('#INPUT_QUICK').val('');
    $("#formFilterStats").submit();
}

//submit form
$("#formFilterStats").submit(function(event) {
    event.preventDefault();
    $("#SPINNER").removeClass('d-none');
    var formData = $(this).serializeArray();
    //ajax dashboard stats
    $('#appointments, #patients, #doctors, #invoices').html('<span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>');
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: formData,
        url: '/admin/dashboard/stats',
        success: function(response) {
            $('#appointments').html(response.appointments);
            $('#patients').html(response.patients);
            $('#doctors').html(response.doctors);
            $('#invoices').html(response.invoices);
        },
    });
    //ajax for datatable doctors
    var table = 'doctors_stats_datatable';
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: formData,
        url: dtUrl,
        success: function(response) {
            if (response.data.length == 0) {
                $('#' + table).dataTable().fnClearTable();
                return 0;
            }
            $('#' + table).dataTable().fnClearTable();
            $("#" + table).dataTable().fnAddData(response.data, true);
        },
        error: function() {
            $('#' + table).dataTable().fnClearTable();
        }
    }).done(function(data) {
        $("#SPINNER").addClass('d-none');
    });
    return false;
});
_loadDashboardStats();
function _loadDashboardStats(){
    $('#appointments, #patients, #doctors, #invoices').html('<span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>');
    $.ajax({
        type: "POST",
        dataType: 'json',
        //data: formData,
        url: '/admin/dashboard/stats',
        success: function(response) {
            $('#appointments').html(response.appointments);
            $('#patients').html(response.patients);
            $('#doctors').html(response.doctors);
            $('#invoices').html(response.invoices);
        },
    });
}

$(document).ready(function() {

    $('#custom-range').flatpickr({
        mode: 'range'
    });

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