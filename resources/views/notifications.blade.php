@extends('layouts/layoutMaster')

@section('title', 'My patients')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/css/classic.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/css/classic.date.css') }}" />
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
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title">{{ __('locale.notifications') }}</h4></div>
                    <div class="col-md-6 text-right">
                        <div class="d-flex justify-content-end">
                            <div class="custom-control custom-radio mr-1">
                                <input type="radio" name="length" id="month" class="custom-control-input" value="month" {{$length=="month"?"checked":""}}>
                                <label class="custom-control-label" for="month"> {{ __('locale.last_30_days') }} </label>
                            </div>
                            <div class="custom-control custom-radio mr-1">
                                <input type="radio" name="length" id="half" class="custom-control-input" value="half" {{$length=="half"?"checked":""}}>
                                <label class="custom-control-label" for="half"> {{ __('locale.last_6_months') }} </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" name="length" id="year" class="custom-control-input" value="year" {{$length=="year"?"checked":""}}>
                                <label class="custom-control-label" for="year"> {{ __('locale.last_year') }} </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="datatable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.date') }}</th>
                                <th>{{ __('locale.content') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($my_notifications as $notification)
                            <tr>
                                <td><span>{{ $notification->created_at }}</span></td>
                                <td><span>{{ $notification->notification }}</span> @if(Auth::user()->user_type=='reception') {!!strpos($notification->read_users, Auth::user()->username)=== false?'<span class="badge badge-danger">new</span>':''!!} @else {!!$notification->is_read==0?'<span class="badge badge-danger">new</span>':''!!}@endif</td>
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
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>
$(document).ready(function() {
    var table = $('.datatable').DataTable({
        responsive: true,
        order: [[ 0, "desc" ]]
        @if($lang=='ar')
        language: {
            url: '/json/datatable/ar.json'
        },
        @endif
    });
    
    $("input[type=radio]").click(function(e){
        location.href='/notifications/'+$(e.target).attr('value');
    })
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: "/notifications/read_all/"+$("input[type=radio]:checked").attr('value'),
        type: "GET",
        dataType: "JSON",
        success: function(result, status) {
            
        }
    });
});
</script>
@endsection