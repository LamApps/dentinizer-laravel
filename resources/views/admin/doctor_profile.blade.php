@extends('layouts/layoutMaster')

@section('title', 'Doctor List')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
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
                <h4 class="card-title">{{ __('locale.doctor_profile') }}</h4>

                <div class="table-responsive">
                    <table class="datatable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.name') }}</th>
                                <th>{{ __('locale.date') }}</th>
                                <th>{{ __('locale.rate') }}</th>
                                <th>
                                {{ __('locale.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctors as $doctor)
                            <tr>
                                <td><span>{{ $doctor->name }}</span></td>
                                <td><span>{{ $doctor->rate_date }}</span></td>
                                <td><span>{{ is_null($doctor->rate)?'':$doctor->rate.'%' }}</span></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a data-id="{{ $doctor->id }}" title="Rate" class="btn btn-icon btn-sm btn-outline-primary rate-btn">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('STAR')!!}</a>
                                    </div>
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


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="rate_modal">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Doctor Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="answer_form">
                    <input type="hidden" name="sel_id" id="sel_id">
                <table class="table">
                    <thead>
                        <th>Question</th>
                        <th>Answer</th>
                    </thead>
                    <tbody id="question_tbody">
                    </tbody>
                </table>
                </form>
            </div><!-- .modal-body -->
            <div class="modal-footer">
                <button href="#" class="btn btn-primary" id="save_btn"><i data-feather="save"></i>&nbsp;Save</button>
                <button href="#" data-dismiss="modal" class="btn btn-danger"><i data-feather="x"></i>&nbsp;Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

@endsection

@section('vendor-script')
<script src="{{ asset('new-assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<!-- responsive -->
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>


@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>
function delete_func(val) {
    document.getElementById(val).submit();
}
$(document).ready(function() {
    var table = $('.datatable').DataTable({
        responsive: true,
        @if($lang=='ar')
        language: {
                url: '/json/datatable/ar.json'
        },
        @endif
    });
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    /* $(".form_datetime").datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: "2020-01-01 10:00",
        minuteStep: 10
    }); */


    $(".datatable").on('click', '.rate-btn', function(e){
        var doctor_id = $(e.currentTarget).data('id');
        $("#sel_id").val(doctor_id);
        var spinner ='<tr><td colspan="2" class="text-center"><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></td></tr>';
        $("#question_tbody").html(spinner)
        $("#rate_modal").modal('show');
        $.ajax({
            url: '/admin/doctor/get_rate/'+doctor_id,
            type: "GET",
            success: function(response) {
                $("#question_tbody").html(response);
            },
        });
    })


    $("#save_btn").click(function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("admin.doctor.profile_save") }}',
            type: "POST",
            data: $("#answer_form").serialize(),
            success: function(response) {
                $("#rate_modal").modal('hide');
                _showResponseMessage("success", 'Success.');
                setTimeout(function(){ window.location.href = '{{route("admin.doctor.profile")}}'; }, 1500);
            },
        });
    });

});

</script>
@endsection


