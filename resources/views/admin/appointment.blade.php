@extends('layouts/layoutMaster')

@section('title', 'Appointments Lists')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
@endsection

@section('page-style')
{{-- Page Css files --}}

@endsection

@section('content')

@php
$lang='en';
if(session()->has('locale')){
    $lang=session()->get('locale');
}
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('locale.appointments') }}</h4>
                <!-- <h5 class='text-success'>You have total {{ count($appointments) }} Appointments.</h5> -->
                <div class="table-responsive">
                    <table class="datatable table table-striped dataex-html5-selectors table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.patient') }}</th>
                                <th>{{ __('locale.doctor') }}</th>
                                <th>{{ __('locale.start_time') }}</th>
                                <th>{{ __('locale.duration') }}</th>
                                <th>{{ __('locale.comments') }}</th>
                                <th>{{ __('locale.status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(json_decode($appointments) as $appointment)
                            <tr>
                                <td style="cursor:pointer">
                                    <span onClick="window.location.href = '/profile/patient/{{$appointment->patient_id}}'">{{ ($appointment->ar_name)?$appointment->ar_name:$appointment->name }}</span>
                                </td>
                                <td onClick="window.location.href = '/profile/patient/{{$appointment->patient_id}}'"
                                    style="cursor:pointer">
                                    <span>{{ ($appointment->doctor_name)?$appointment->doctor_name:'' }}</span>
                                </td>
                                <td><span>{{ $appointment->start_time }}</span></td>
                                <td><span>{{ $appointment->duration }}</span></td>
                                <td><span>{{ $appointment->comments }}</span></td>
                                <td>
                                    @if($appointment->status == 1)
                                    <span class="tb-status text-success">Booked</span>
                                    @elseif($appointment->status == 2)
                                    <span class="tb-status text-warning">Confirmed</span>
                                    @elseif($appointment->status == 3)
                                    <span class="tb-status text-danger">Canceled</span>
                                    @elseif($appointment->status == 4)
                                    <span class="tb-status text-info">Attended</span>
                                    @else
                                    <span class="tb-status">None</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
@endsection
@section('page-script')
<script>
$(document).ready(function() {
    var table = $('.datatable').DataTable({
        responsive: true,
        @if($lang=='ar')
        language: {
                url: '/json/datatable/ar.json'
        },
        @endif
    });
});
</script>
@endsection












