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
                <h4 class="card-title">{{ __('locale.receptions') }}</h4>
                <div class="row">
                    <div class="col-md-12">
                        
<!--                         <a style="float:right;" target="_blank" href="/report/pdf/doctor/daily/0/1" title="daily report all doctors" class="btn btn-icon btn-outline-primary ml-1"><i data-feather="download"></i> {{ __('locale.daily_doctors_report') }}</a>
                        <button style="float:right;" onclick="_formDoctor(0)" title="New doctor" class="btn btn-icon btn-outline-primary">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('NEW')!!}</button> -->
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="datatable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.name') }}</th>
                                <th>{{ __('locale.appointments_30days') }}</th>
                                <th>{{ __('locale.rate') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($receptions as $value)
                            <tr>
                                <td><span>{{ $value->name }}</span></td>
                                <td><span>{{ $value->count_monthly?$value->count_monthly:0 }}</span></td>
                                <td><span>{{ is_null($value->rate)?100:$value->rate }}%ee</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="set_target_modal">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="basicModalLabel">Set Target</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="s_doctor_id" name="s_doctor_id">
                <input type="hidden" id="s_user_id" name="s_user_id">
                <div class="row gy-4">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="display-name">Email*</label>
                            <input type="text" id="s_email" name="s_email" class="form-control form-control-lg"
                                placeholder="Enter Email" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="default-05">Target({{env('CURRENCY_SYMBOL')}})</label>
                            <div class="form-control-wrap">
                                <input type="number" min="1" max="9999999999" id="s_target" name="s_target"
                                    class="form-control form-control-lg">
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .modal-body -->
            <div class="modal-footer">
                <button href="#" class="btn btn-primary" id="target_set_btn"><i data-feather="save"></i>&nbsp;Set</button>
                <button href="#" data-dismiss="modal" class="btn btn-danger"><i data-feather="x"></i>&nbsp;Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->


<x-modal-form id="modal_form_doctor" formName="DOCTOR" content="modal_form_doctor_content" />
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


<script src="{{ asset('assets/plugins/datepicker/js/picker.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/picker.date.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/custom-picker.js') }}"></script>
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
    /* $(".form_datetime").datetimepicker({
        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: "2020-01-01 10:00",
        minuteStep: 10
    }); */



    $('#set_target_modal').on('show.bs.modal', function(e) {
        var doctor_data = $(e.relatedTarget).data('id');
        $("#s_doctor_id").val(doctor_data['d_id']); //id
        $("#s_user_id").val(doctor_data['id']); //user_id
        $("#s_email").val(doctor_data['email']);
        $("#s_target").val(doctor_data['target']);
    });


    $("#target_set_btn").click(function(e) {
        e.preventDefault();
        var id = $("#s_doctor_id").val();
        var user_id = $("#s_user_id").val();
        var email = $("#s_email").val();
        var target = $("#s_target").val();

        if (target != "") {
            $.ajax({
                url: '{{ route("admin.doctor.settarget") }}',
                type: "POST",
                data: {
                    id: id,
                    user_id: user_id,
                    target: target,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    $("#set_target_modal").modal('hide');
                    _showResponseMessage("success", 'Success.');
                    setTimeout(function(){ window.location.href = '{{route("admin.doctor")}}'; }, 1500);
                },
            });
        }
    });


    $("#search_btn").click(function(e) {
        e.preventDefault();

        var start_time = $("#s_start_time").val();
        var finish_time = $("#s_finish_time").val();

        if (start_time != "" && finish_time != "") {
            $.ajax({
                url: '{{ route("admin.doctor.search") }}',
                type: "POST",
                data: {
                    start_time: start_time,
                    finish_time: finish_time,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {

                },
            });
        }
    });



});

function _formDoctor(doctor_id) {
    var modal_id = "modal_form_doctor";
    var modal_content_id = "modal_form_doctor_content";
    var spinner ='<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = (doctor_id > 0)? "{{ __('locale.edit') }}" : "{{ __('locale.new') }}";
    $("#DOCTOR_MODAL_TITLE").html('{!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT ')!!} ' + modalTitle);
    $.ajax({
        url: "/admin/form/doctor/" + doctor_id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);
        },
    });
};
$("#FORM_DOCTOR").validate({
    rules: {},
    messages: {},
    submitHandler: function(form) {
        $("#SPAN_SAVE_DOCTOR").addClass("spinner-border spinner-border-sm");
        var formData = $(form).serializeArray(); // convert form to array
        $.ajax({
            type: "POST",
            url: "/admin/form/doctor",
            data: formData,
            dataType: "JSON",
            success: function(result) {
                if (result.success) {
                    _showResponseMessage("success", result.msg);
                    $("#modal_form_doctor").modal("hide");
                } else {
                    _showResponseMessage("error", result.msg);
                }
            },
            error: function(error) {
                _showResponseMessage(
                    "error",
                    "Oooops..."
                );
            },
            complete: function(resultat, statut) {
                $("#SPAN_SAVE_DOCTOR").removeClass("spinner-border spinner-border-sm");
                setTimeout(function(){ window.location.href = '{{route("admin.doctor")}}'; }, 1500);
            },
        });
        return false;
    },
});
</script>
@endsection


