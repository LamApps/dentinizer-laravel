@extends('layouts/layoutMaster')

@section('title', 'Appointments Lists')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('new-assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
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
                <div class="table-responsive">
                    <table class="datatable table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('locale.start_time') }}</th>
                                <th>{{ __('locale.duration') }}</th>
                                <th>{{ __('locale.patient') }}</th>
                                <th>{{ __('locale.comments') }}</th>
                                <th>{{ __('locale.status') }}</th>
                                <th>{{ __('locale.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr>
                                <td><span>{{ $event->start_time }}</span></td>
                                <td><span>{{ $event->end }}</span></td>
                                <td><span>{{ ($event->p_ar_name)?$event->p_ar_name:$event->p_name }}</span></td>
                                <td><span>{{ $event->comments }}</span></td>
                                <td>
                                    @if($event->status == 1)
                                    <span class="tb-status text-success">Booked</span>
                                    @elseif($event->status == 2)
                                    <span class="tb-status text-warning">Confirmed</span>
                                    @elseif($event->status == 3)
                                    <span class="tb-status text-danger">Canceled</span>
                                    @elseif($event->status == 4)
                                    <span class="tb-status text-info">Attended</span>
                                    @else
                                    <span class="tb-status">None</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a title="View appointment" class="btn btn-icon btn-sm btn-outline-primary rate-btn" onclick="_formAppointment({{$event->id}},{{$event->p_id}}, '{{($event->p_ar_name)?$event->p_ar_name:$event->p_name}}')">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('VIEW')!!}</a>
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
<input type="hidden" id="sel_appointment_id">
<input type="hidden" id="sel_patient_name">
<input type="hidden" id="sel_patient_id">
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_form_appointment">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="APPONTMENT_MODAL_TITLE">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-lg">
                <form id="FORM_APPOINTMENT">
                    <div id='modal_form_appointment_body'>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button onclick="_submit_form()" class="btn btn-outline-primary"><i
                        data-feather="save"></i> Save <span id="SPAN_SAVE_APPOINTMENT" class="" role="status" aria-hidden="true"></span></button>
                <button data-dismiss="modal" class="btn btn-outline-danger"><i data-feather="x"></i> Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_change_doctor">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request a new appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-lg">
                <form id="request_appointment">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Patient</label>
                                <div class="form-control-wrap">
                                    <input class="form-control" type="text" readonly="" id="patient_name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Doctor</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-control-lg js-select2" data-search="on" required id="request_doctors">
                                        @foreach($doctors as $doctor)
                                            @php
                                                $selected = ($doctor->user_id === Auth::user()->id)?'selected':'';
                                            @endphp
                                            <option value="{{ $doctor->user_id }}" {{$selected}}>{{ $doctor->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button onclick="request_form()" class="btn btn-outline-primary"><i
                        data-feather="save"></i> Save <span id="SPAN_SAVE_APPOINTMENT" class="" role="status" aria-hidden="true"></span></button>
                <button data-dismiss="modal" class="btn btn-outline-danger"><i data-feather="x"></i> Cancel</button>
            </div>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

@endsection

@section('vendor-script')
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>

<!-- <script src="{{ asset('assets/plugins/datepicker/js/picker.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/picker.date.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/js/custom-picker.js') }}"></script> -->
<!-- <script src="{{ asset('new-assets/js/select2/select2.min.js') }}"></script> -->


@endsection
@section('page-script')
<script src="{{ asset('new-assets/js/main.js') }}"></script>
<script>
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
var table = $('.datatable').DataTable({
        responsive: true,
        @if($lang=='ar')
        language: {
                url: '/json/datatable/ar.json'
        },
        @endif
    });
function _formAppointment(id,patient_id, name) {
    $("#sel_appointment_id").val(id);
    $("#sel_patient_name").val(name);
    $("#sel_patient_id").val(patient_id);
    console.log(name);
    var modal_id = "modal_form_appointment";
    var modal_content_id = "modal_form_appointment_body";
    var spinner =
        '<div class="modal-body"><center><div class="spinner-border text-primary text-center" role="status"><span class="sr-only">Loading...</span></div></center></div>';
    $("#" + modal_id).modal("show");
    $("#" + modal_content_id).html(spinner);
    var modalTitle = id > 0 ? 'Edit appointment' : 'Add appointment';
    $("#APPONTMENT_MODAL_TITLE").html('{!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT')!!} ' + modalTitle);
    $.ajax({
        url: "/doctor/form/appointment/" + id+'/'+patient_id,
        type: "GET",
        dataType: "html",
        success: function(html, status) {
            $("#" + modal_content_id).html(html);

            $("#modal_form_appointment_body input, #modal_form_appointment_body textarea, #patient_id, #select_doctor, #duration").prop('disabled', 'true');
            setTimeout(function(){ $("#modal_form_appointment_body input[type=radio]").prop('disabled','true');},1000);
        },
    });
};
function _submit_form() {
    $.ajax({
        url: "/doctor/change_appointment",
        type: "POST",
        data: {
            id:$("#sel_appointment_id").val(),
            value: $("#status").val()
        },
        dataType: "json",
        success: function(res, status) {
            if(res.success){
                $("#modal_form_appointment").modal("hide");
                if($("#status").val()==4){
                    $("#patient_name").val($("#sel_patient_name").val());
                    $("#modal_change_doctor").modal('show');
                }else{
                    Swal.fire({
                        html: res.msg,
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                            cancelButton: 'btn btn-outline-danger ml-1'
                        },
                        buttonsStyling: false,
                    }).then(function(result) {
                        location.href='/doctor/appointment';
                    });
                }
            }else {
                Swal.fire({
                    html: res.msg,
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1'
                    },
                    buttonsStyling: false,
                });
            }
        },
    });
}

function request_form() {
    $.ajax({
        url: "/doctor/request_appointment",
        type: "POST",
        data: {
            patient_id: $("#sel_patient_id").val(),
            doctor_id: $("#request_doctors").val()
        },
        dataType: "json",
        success: function(res) {
            if(res.success){
                $("#modal_change_doctor").modal("hide");
                Swal.fire({
                    html: res.msg,
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1'
                    },
                    buttonsStyling: false,
                }).then(function(result) {
                    location.href='/doctor/appointment';
                });
            }else {
                Swal.fire({
                    html: 'Oops, something went wrong !',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1'
                    },
                    buttonsStyling: false,
                }).then(function(result) {
                    location.href='/doctor/appointment';
                });
            }
        },
    });
}
</script>
@endsection